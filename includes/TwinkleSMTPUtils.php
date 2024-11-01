<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}


// For Postmark only
use Postmark\PostmarkClient;
use Postmark\Models\PostmarkException;
//use Postmark\PostmarkAdminClient;

//For Sparkpost
use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;

//For Aws
use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

//For Mailgun
use Mailgun\Mailgun;
use Mailgun\Exception\HttpClientException as MailgunException;



if (!class_exists('TwinkleSMTPUtils')) {
    class TwinkleSMTPUtils
    {
        public $admin_class;
        public $logsData = [];

        public function __construct($admin_obj)
        {
            $this->admin_class = $admin_obj;
        }


        function enqueue_style($name, $src = '', $deps = array(), $ver = TWINKLE_SMTP_VERSION, $media = 'all')
        {
            $handle = "twinkle-smtp-" . $name;
            $src = TWINKLE_SMTP_CSS_DIR . $src;
            _wp_scripts_maybe_doing_it_wrong(__FUNCTION__, $handle);
            $wp_styles = wp_styles();
            if ($src) {
                $_handle = explode('?', $handle);
                $wp_styles->add($_handle[0], $src, $deps, $ver, $media);
            }
            $wp_styles->enqueue($handle);
        }

        function enqueue_script($name, $src = '', $deps = array(), $ver = TWINKLE_SMTP_VERSION, $in_footer = false)
        {
            $handle = "twinkle-smtp-" . $name;
            $src = TWINKLE_SMTP_JS_DIR . $src;
            _wp_scripts_maybe_doing_it_wrong(__FUNCTION__, $handle);
            $wp_scripts = wp_scripts();
            if ($src || $in_footer) {
                $_handle = explode('?', $handle);
                if ($src) {
                    $wp_scripts->add($_handle[0], $src, $deps, $ver);
                }
                if ($in_footer) {
                    $wp_scripts->add_data($_handle[0], 'group', 1);
                }
            }
            $wp_scripts->enqueue($handle);
        }

        //Sendgrid  Sent mail
        public function twinkle_smtp_sendgrid_sent_mail($subject, $mail_body, $mail_send_to, $headers, $attachments)
        {
            $sendgrid_api_key = $this->admin_class->db->update_mailer_data('sendgrid_api_key', null);
            $from             = $this->admin_class->db->update_mailer_data('sendgrid_from_email', null);
            $from_name        = $this->admin_class->db->update_mailer_data('sendgrid_from_name', null);

            //Assing logs Data
            $this->logsData['form']        = $from;
            $this->logsData['to']          = $mail_send_to;
            $this->logsData['subject']     = $subject;
            $this->logsData['message']     = $mail_body;
            $this->logsData['headers']     =  serialize($attachments);
            $this->logsData['attachments'] =  serialize($headers);

            $cc  = '';
            $bcc = '';

            foreach ($headers as $header) {
                if (strpos($header, 'Bcc') !== false) {
                    $header_bcc = str_replace("Bcc :", "", $header);
                    $bcc = trim($header_bcc);
                }
                if (strpos($header, 'CC') !== false) {
                    $header_cc = str_replace("CC :", "", $header);
                    $cc = trim($header_cc);
                }
            }

            $email = new \SendGrid\Mail\Mail();
            $email->setFrom($from, $from_name);
            $email->setSubject($subject);
            $email->addTo($mail_send_to);
            $email->addContent("text/html", $mail_body);

            if (!empty($bcc)) {
                $email->addBcc($bcc);
            }

            if (!empty($cc)) {
                $email->addCc($cc);
            }

            $sendgrid = new \SendGrid($sendgrid_api_key);
            try {
                $response = $sendgrid->send($email);
                $statusCode       = $response->statusCode();
                $response_header  = $response->headers();
                $response_message = $response->body();

                if (!empty($response_message)) {
                    $response_message = json_decode($response->body());
                    $response_message = $response_message->errors[0]->message;
                }

                if (empty($response_message)) {
                    $this->logsData['status'] = 'success';
                    $this->logsData['exception_code'] = $statusCode;
                    $this->logsData['error_message']  = '';
                    $_SESSION["send_status"] = 'success';

                    //Update log If already exists
                    $update_log_id = (isset($_SESSION['update_log_id'])) ?  $_SESSION['update_log_id'] : '';

                    if (!empty($update_log_id)) {
                        $update_total_resend = (isset($_SESSION['update_total_resend'])) ?  $_SESSION['update_total_resend'] : 0;

                        $this->logsData['total_resend'] = $update_total_resend + 1;

                        $this->admin_class->db->update_mail_logs($this->logsData, $update_log_id);
                    } else {
                        $this->admin_class->db->insert_mail_logs($this->logsData);
                    }

                    // set session data
                    $_SESSION["send_status"] = "success";
                    // unset session data
                    unset($_SESSION['update_log_id']);
                    unset($_SESSION['update_total_resend']);

                    return;
                } else {
                    $this->logsData['status'] = 'failed';
                    $this->logsData['exception_code'] = $statusCode;
                    $this->logsData['error_message']  = $response_message ? $response_message : '';

                    //Update log If already exists
                    $update_log_id = (isset($_SESSION['update_log_id'])) ?  $_SESSION['update_log_id'] : '';

                    if (!empty($update_log_id)) {
                        $this->admin_class->db->update_mail_logs($this->logsData, $update_log_id);
                    } else {
                        $this->admin_class->db->insert_mail_logs($this->logsData);
                    }

                    // set session data
                    $_SESSION["send_status"] = "failed";
                    // unset session data
                    unset($_SESSION['update_log_id']);
                    return;
                }
            } catch (Exception $e) {
            }
        }

        //Sendinblue Sent  Mail
        public function twinkle_smtp_sendinblue_sent_mail($subject, $mail_body, $mail_send_to, $headers, $attachments)
        {

            $api_key   = $this->admin_class->db->update_mailer_data('sendinblue_api_key', null);
            $from      = $this->admin_class->db->update_mailer_data('sendinblue_from_email', null);
            $from_name = $this->admin_class->db->update_mailer_data('sendinblue_from_name', null);

            //Assing logs Data
            $this->logsData['form']        = $from;
            $this->logsData['to']          = $mail_send_to;
            $this->logsData['subject']     = $subject;
            $this->logsData['message']     = $mail_body;
            $this->logsData['attachments'] = serialize($headers);
            $this->logsData['headers']     = serialize($attachments);

            $cc  = '';
            $bcc = '';

            foreach ($headers as $header) {
                if (strpos($header, 'Bcc') !== false) {
                    $header_bcc = str_replace("Bcc :", "", $header);
                    $bcc = trim($header_bcc);
                }
                if (strpos($header, 'CC') !== false) {
                    $header_cc = str_replace("CC :", "", $header);
                    $cc = trim($header_cc);
                }
            }

            $config = \SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $api_key);

            $apiInstance = new \SendinBlue\Client\Api\TransactionalEmailsApi(
                new \GuzzleHttp\Client(),
                $config
            );
            $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail();
            $sendSmtpEmail['subject'] = $subject;
            $sendSmtpEmail['htmlContent'] = $mail_body;
            $sendSmtpEmail['sender'] = array('name' => $from_name, 'email' => $from);
            $sendSmtpEmail['to'] = array(
                array('email' => $mail_send_to)
            );

             if( !empty($cc) ){
                $sendSmtpEmail['cc'] = array(
                    array('email' => $cc)
                );
             }

            if (!empty($bcc)) {
                $sendSmtpEmail['bcc'] = array(
                    array('email' => $bcc)
                );
            }

            $sendSmtpEmail['replyTo'] = array('email' => $from, 'name' =>  $from_name);
            $sendSmtpEmail['headers'] = array('Some-Custom-Name' => 'unique-id-1234');
            //$sendSmtpEmail['params'] = array('parameter' => 'My param value', 'subject' => 'New Subject');

            try {
                $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
                $this->logsData['status'] = 'success';
                $this->logsData['exception_code'] = '';
                $this->logsData['error_message']  = '';

                //Update log If already exists
                $update_log_id = (isset($_SESSION['update_log_id'])) ?  $_SESSION['update_log_id'] : '';

                if (!empty($update_log_id)) {
                    $update_total_resend = (isset($_SESSION['update_total_resend'])) ?  $_SESSION['update_total_resend'] : 0;

                    $this->logsData['total_resend'] = $update_total_resend + 1;

                    $this->admin_class->db->update_mail_logs($this->logsData, $update_log_id);
                } else {
                    $this->admin_class->db->insert_mail_logs($this->logsData);
                }

                // set session data
                $_SESSION["send_status"] = "success";
                // unset session data
                unset($_SESSION['update_log_id']);
                unset($_SESSION['update_total_resend']);

                return;
            } catch (Exception $e) {
                $response =  $e->getMessage();

                function get_numerics ($str) {
                    preg_match_all('/\d+/', $str, $matches);
                    return $matches[0];
                }

                $exception_code = get_numerics($response)[0];

                $this->logsData['status'] = 'failed';
                $this->logsData['exception_code'] = $exception_code;
                $this->logsData['error_message']  = $response;

                //Update log If already exists
                $update_log_id = (isset($_SESSION['update_log_id'])) ?  $_SESSION['update_log_id'] : '';

                if (!empty($update_log_id)) {
                    $this->admin_class->db->update_mail_logs($this->logsData, $update_log_id);
                } else {
                    $this->admin_class->db->insert_mail_logs($this->logsData);
                }

                // set session data
                $_SESSION["send_status"] = "failed";
                // unset session data
                unset($_SESSION['update_log_id']);
                return;
            }
        }


        //postmark mail sent
        public function twinkle_smtp_postmark_sent_mail($subject, $mail_body, $mail_send_to, $headers, $attachments)
        {
            $apiKey    = $this->admin_class->db->update_mailer_data('postmark_api_key', null);
            $from      = $this->admin_class->db->update_mailer_data('postmark_from_email', null);
            $from_name = $this->admin_class->db->update_mailer_data('postmark_from_name', null);

             //Assing logs Data
             $this->logsData['form']        = $from;
             $this->logsData['to']          = $mail_send_to;
             $this->logsData['subject']     = $subject;
             $this->logsData['message']     = $mail_body;
             $this->logsData['attachments'] = serialize($headers);
             $this->logsData['headers']     = serialize($attachments);
 
             $cc  = '';
             $bcc = '';
 
             foreach ($headers as $header) {
                 if (strpos($header, 'Bcc') !== false) {
                     $header_bcc = str_replace("Bcc :", "", $header);
                     $bcc = trim($header_bcc);
                 }
                 if (strpos($header, 'CC') !== false) {
                     $header_cc = str_replace("CC :", "", $header);
                     $cc = trim($header_cc);
                 }
             }


            try {
                $client = new PostmarkClient($apiKey);
                $sendResult = $client->sendEmail(
                    $from_name . '<'. $from . '>',
                    $mail_send_to,
                    $subject,
                    $mail_body,
                    '',
                    '',
                    '',
                    '',
                    $cc,
                    $bcc
                );

                $this->logsData['status']         = 'success';
                $this->logsData['exception_code'] = '';
                $this->logsData['error_message']  = '';

                //Update log If already exists
                $update_log_id = (isset($_SESSION['update_log_id'])) ?  $_SESSION['update_log_id'] : '';

                if (!empty($update_log_id)) {
                    $update_total_resend = (isset($_SESSION['update_total_resend'])) ?  $_SESSION['update_total_resend'] : 0;

                    $this->logsData['total_resend'] = $update_total_resend + 1;

                    $this->admin_class->db->update_mail_logs($this->logsData, $update_log_id);
                } else {
                    $this->admin_class->db->insert_mail_logs($this->logsData);
                }

                // set session data
                $_SESSION["send_status"] = "success";
                // unset session data
                unset($_SESSION['update_log_id']);
                unset($_SESSION['update_total_resend']);

                return;
            } catch (PostmarkException $ex) {

                $statusCode = $ex->httpStatusCode;
                $message    = $ex->message;

                $this->logsData['status'] = 'failed';
                $this->logsData['exception_code'] = $statusCode;
                $this->logsData['error_message']  = $message ;

                //Update log If already exists
                $update_log_id = (isset($_SESSION['update_log_id'])) ?  $_SESSION['update_log_id'] : '';

                if (!empty($update_log_id)) {
                    $this->admin_class->db->update_mail_logs($this->logsData, $update_log_id);
                } else {
                    $this->admin_class->db->insert_mail_logs($this->logsData);
                }

                // set session data
                $_SESSION["send_status"] = "failed";
                // unset session data
                unset($_SESSION['update_log_id']);
                return;
            } catch (Exception $generalException) {
                return;
            }
        }

        //Sparkpost mail sent
        public function twinkle_smtp_sparkpost_sent_mail($subject, $mail_body, $mail_send_to, $headers, $attachments) {
            $apiKey    = $this->admin_class->db->update_mailer_data('sparkpost_api_key', null);
            $from      = $this->admin_class->db->update_mailer_data('sparkpost_from_email', null);
            $from_name = $this->admin_class->db->update_mailer_data('sparkpost_from_name', null);

             //Assing logs Data
             $this->logsData['form']        = $from;
             $this->logsData['to']          = $mail_send_to;
             $this->logsData['subject']     = $subject;
             $this->logsData['message']     = $mail_body;
             $this->logsData['attachments'] = serialize($headers);
             $this->logsData['headers']     = serialize($attachments);
 
             $cc  = '';
             $bcc = '';


            $httpClient = new GuzzleAdapter(new Client());
            // Good practice to not have API key literals in code - set an environment variable instead
            // For simple example, use synchronous model
            $sparky = new SparkPost($httpClient, ['key' => $apiKey, 'async' => false]);

            try {
                $response = $sparky->transmissions->post([
                    'content' => [
                        'from' => [
                            'name' =>  $from_name,
                            'email' =>  $from,
                        ],
                        'subject' => $subject,
                        'html' => $mail_body,
                    
                    ],
                    'substitution_data' => ['name' => $from_name],
                    'recipients' => [
                        [
                            'address' => [
                                'email' => $mail_send_to,
                            ],
                        ],
                    ],
                    'cc' => [
                        [
                            'address' => [
                                'email' =>  $cc,
                            ],
                        ],
                    ],
                    'bcc' => [
                        [
                            'address' => [
                                'email' =>  $bcc,
                            ],
                        ],
                    ],

                ]);

                $this->logsData['status']         = 'success';
                $this->logsData['exception_code'] = $response->getStatusCode();
                $this->logsData['error_message']  = '';

                //Update log If already exists
                $update_log_id = (isset($_SESSION['update_log_id'])) ?  $_SESSION['update_log_id'] : '';

                if (!empty($update_log_id)) {
                    $update_total_resend = (isset($_SESSION['update_total_resend'])) ?  $_SESSION['update_total_resend'] : 0;

                    $this->logsData['total_resend'] = $update_total_resend + 1;

                    $this->admin_class->db->update_mail_logs($this->logsData, $update_log_id);
                } else {
                    $this->admin_class->db->insert_mail_logs($this->logsData);
                }

                // set session data
                $_SESSION["send_status"] = "success";
                // unset session data
                unset($_SESSION['update_log_id']);
                unset($_SESSION['update_total_resend']);
                return;
            } catch (\Exception $error) {

                $status_code = $error->getCode();
                $message     = $error->getMessage();

                $this->logsData['status']         = 'failed';
                $this->logsData['exception_code'] = $status_code;
                $this->logsData['error_message']  = $message ;

                //Update log If already exists
                $update_log_id = (isset($_SESSION['update_log_id'])) ?  $_SESSION['update_log_id'] : '';

                if (!empty($update_log_id)) {
                    $this->admin_class->db->update_mail_logs($this->logsData, $update_log_id);
                } else {
                    $this->admin_class->db->insert_mail_logs($this->logsData);
                }

                // set session data
                $_SESSION["send_status"] = "failed";
                // unset session data
                unset($_SESSION['update_log_id']);
                return;
            }          
        }

        //Aws mail sent
        public function twinkle_aws_sent_mail($subject, $mail_body, $mail_send_to, $headers, $attachments) {
            $aws_from_email = $this->admin_class->db->update_mailer_data('aws_from_email', null);
            $aws_from_name  = $this->admin_class->db->update_mailer_data('aws_from_name', null);
            $aws_access_key = $this->admin_class->db->update_mailer_data('aws_access_key', null);
            $aws_secret_key = $this->admin_class->db->update_mailer_data('aws_secret_key', null);
            $aws_region     = $this->admin_class->db->update_mailer_data('aws_region', null);

            //Assing logs Data
            $this->logsData['form']        = $aws_from_email;
            $this->logsData['to']          = $mail_send_to;
            $this->logsData['subject']     = $subject;
            $this->logsData['message']     = $mail_body;
            $this->logsData['attachments'] = serialize($headers);
            $this->logsData['headers']     = serialize($attachments);

            $cc  = [];
            $bcc = [];

            foreach ($headers as $header) {
                if (strpos($header, 'Bcc') !== false) {
                    $header_bcc = str_replace("Bcc :", "", $header);
                    $bcc[] = trim($header_bcc);
                }
                if (strpos($header, 'CC') !== false) {
                    $header_cc = str_replace("CC :", "", $header);
                    $cc[] = trim($header_cc);
                }
            }

            $SesClient = new SesClient([
                'version' => 'latest',
                'region'  =>  $aws_region,
                'credentials' => array(
                    'key'       => $aws_access_key,
                    'secret'    =>  $aws_secret_key,
                ),
            ]);

           
            $recipient_emails = [$mail_send_to];
    
            $char_set = 'UTF-8';

            try {
                $result = $SesClient->sendEmail([
                    'Destination' => [
                        'BccAddresses' => $bcc,
                        'CcAddresses' =>  $cc,
                        'ToAddresses' => $recipient_emails,
                    ],
                    'ReplyToAddresses' => [$aws_from_email],
                    'Source' => $aws_from_name . '<' . $aws_from_email . '>',
                    'Message' => [
                        'Body' => [
                            'Html' => [
                                'Charset' => $char_set,
                                'Data' => $mail_body,
                            ]

                        ],
                        'Subject' => [
                            'Charset' => $char_set,
                            'Data' => $subject,
                        ],
                    ],
                    // If you aren't using a configuration set, comment or delete the
                    // following line
                    "Statement" => [

                        "Effect" => "Allow",
                        "Action" => [
                            "ses:*"
                        ],
                        "Resource" => "*"

                    ],

                    'http' => [
                        'verify' => 'path_of_certs\ca-bundle.crt'
                    ],

                ]);
                $messageId = $result['MessageId'];

                $this->logsData['status']         = 'success';
                $this->logsData['exception_code'] = '';
                $this->logsData['error_message']  = '';

                //Update log If already exists
                $update_log_id = (isset($_SESSION['update_log_id'])) ?  $_SESSION['update_log_id'] : '';

                if (!empty($update_log_id)) {
                    $update_total_resend = (isset($_SESSION['update_total_resend'])) ?  $_SESSION['update_total_resend'] : 0;

                    $this->logsData['total_resend'] = $update_total_resend + 1;

                    $this->admin_class->db->update_mail_logs($this->logsData, $update_log_id);
                } else {
                    $this->admin_class->db->insert_mail_logs($this->logsData);
                }

                // set session data
                $_SESSION["send_status"] = "success";
                // unset session data
                unset($_SESSION['update_log_id']);
                unset($_SESSION['update_total_resend']);
                return;
            } catch (AwsException $e) {
                $status_code = $e->getStatusCode();
                $message     = $e->getAwsErrorMessage();

                $this->logsData['status']         = 'failed';
                $this->logsData['exception_code'] = $status_code;
                $this->logsData['error_message']  = $message;

                //Update log If already exists
                $update_log_id = (isset($_SESSION['update_log_id'])) ?  $_SESSION['update_log_id'] : '';

                if (!empty($update_log_id)) {
                    $this->admin_class->db->update_mail_logs($this->logsData, $update_log_id);
                } else {
                    $this->admin_class->db->insert_mail_logs($this->logsData);
                }

                // set session data
                $_SESSION["send_status"] = "failed";
                // unset session data
                unset($_SESSION['update_log_id']);
                return;
            }
        }

        //Mailgunmail sent
        public function twinkle_mailgun_sent_mail($subject, $mail_body, $mail_send_to, $headers, $attachments) {
            $mailgun_from_email  = $this->admin_class->db->update_mailer_data('mailgun_from_email', null);
            $mailgun_from_name   = $this->admin_class->db->update_mailer_data('mailgun_from_name', null);
            $mailgun_api_key     = $this->admin_class->db->update_mailer_data('mailgun_api_key', null);
            $mailgun_domain_name = $this->admin_class->db->update_mailer_data('mailgun_domain_name', null);
            $mailgun_region      = $this->admin_class->db->update_mailer_data('mailgun_region', null);


            //Assing logs Data
            $this->logsData['form']        = $mailgun_from_email;
            $this->logsData['to']          = $mail_send_to;
            $this->logsData['subject']     = $subject;
            $this->logsData['message']     = $mail_body;
            $this->logsData['attachments'] = serialize($headers);
            $this->logsData['headers']     = serialize($attachments);

            $cc  = '';
            $bcc = '';

            foreach ($headers as $header) {
                if (strpos($header, 'Bcc') !== false) {
                    $header_bcc = str_replace("Bcc :", "", $header);
                    $bcc = trim($header_bcc);
                }
                if (strpos($header, 'CC') !== false) {
                    $header_cc = str_replace("CC :", "", $header);
                    $cc = trim($header_cc);
                }
            }

            if ('us' == $mailgun_region) {
                $mgClient = Mailgun::create($mailgun_api_key);
            } elseif ('eu' == $mailgun_region) {
                $mgClient = Mailgun::create($mailgun_api_key, 'https://api.eu.mailgun.net');
            }

            $domain =  $mailgun_domain_name;
            # Make the call to the client.
            try {

                $params = array(
                    'from'    => $mailgun_from_name . '<' . $mailgun_from_email  . '>',
                    'to'    => $mail_send_to,
                    'cc'      => $cc,
                    'bcc'     => $bcc,
                    'subject' => $subject,
                    'html'    => $mail_body,

                    // 'attachment' => array(
                    //         array(
                    //             'filePath' => 'test.txt',
                    //             'filename' => 'test_file.txt'
                    //       )
                    //   )
                  );

                $result = $mgClient->messages()->send($domain,$params);

                $this->logsData['status']         = 'success';
                $this->logsData['exception_code'] = '';
                $this->logsData['error_message']  = '';

               //Update log If already exists
               $update_log_id = (isset($_SESSION['update_log_id'])) ?  $_SESSION['update_log_id'] : '';

               if (!empty($update_log_id)) {
                   $update_total_resend = (isset($_SESSION['update_total_resend'])) ?  $_SESSION['update_total_resend'] : 0;

                   $this->logsData['total_resend'] = $update_total_resend + 1;

                   $this->admin_class->db->update_mail_logs($this->logsData, $update_log_id);
               } else {
                   $this->admin_class->db->insert_mail_logs($this->logsData);
               }

               // set session data
               $_SESSION["send_status"] = "success";
               // unset session data
               unset($_SESSION['update_log_id']);
               unset($_SESSION['update_total_resend']);
               return;
            } catch (MailgunException $e) {

                $statuscode   = $e->getResponseCode();
                $responseBody = $e->getResponseBody();
                $message      = $responseBody['message'];
            
                $this->logsData['status']         = 'failed';
                $this->logsData['exception_code'] = $statuscode;
                $this->logsData['error_message']  = $message;

                //Update log If already exists
                $update_log_id = (isset($_SESSION['update_log_id'])) ?  $_SESSION['update_log_id'] : '';

                if (!empty($update_log_id)) {
                    $this->admin_class->db->update_mail_logs($this->logsData, $update_log_id);
                } else {
                    $this->admin_class->db->insert_mail_logs($this->logsData);
                }

                // set session data
                $_SESSION["send_status"] = "failed";
                // unset session data
                unset($_SESSION['update_log_id']);
                return;
            }
        }
    }
}
