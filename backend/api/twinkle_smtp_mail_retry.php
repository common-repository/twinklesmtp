<?php

/* Check if user has admin capabilities */
if (current_user_can('manage_options')) {
    /* Receive post data */
    if (isset($_REQUEST['data'])) {
        $data = $_REQUEST['data'];

        if( !empty( $data ) && isset( $data['logid'] ) && !empty( $data['logid'] ) ){

             // set session data
            $_SESSION["update_log_id"] = $data['logid'];

            global $wpdb;
            $table_name = $wpdb->prefix . 'twinkle_smtp_mail_logs';
            $sql        = "SELECT *  FROM $table_name WHERE id='". $data['logid'] ."'";
            $results    = $wpdb->get_row($sql);

            $subject    = $results->subject;
            $rety_email = $results->to;
            $mail_body  = $results->message;
            $headers    = maybe_unserialize( $results->headers);
            $attachments = $results->attachments? maybe_unserialize( $results->attachments) : '';

            if( 'success' == $results->status ){
                $_SESSION["update_total_resend"] = $results->total_resend;   
            }

            $mailer_form_name = $this->admin_class->db->update_mailer_data('mailer_form_name',null);


            if( 'default' ==  $mailer_form_name ){
                wp_mail($rety_email, $subject, $mail_body, $headers );
             }elseif( 'sendgrid' ==  $mailer_form_name ){
               
                $this->admin_class->utils->twinkle_smtp_sendgrid_sent_mail($subject,$mail_body, $rety_email, $headers, $attachments);
                
             }elseif( 'sendinblue' ==  $mailer_form_name ){
                $this->admin_class->utils->twinkle_smtp_sendinblue_sent_mail($subject,$mail_body, $rety_email, $headers, $attachments);
               
             }elseif( 'postmark' ==  $mailer_form_name ){
                $this->admin_class->utils->twinkle_smtp_postmark_sent_mail($subject,$mail_body, $rety_email, $headers, $attachments);
               
             }elseif( 'sparkpost' ==  $mailer_form_name ){
                $this->admin_class->utils->twinkle_smtp_sparkpost_sent_mail($subject,$mail_body, $rety_email, $headers, $attachments);
               
             }elseif( 'aws' ==  $mailer_form_name ){
                $this->admin_class->utils->twinkle_aws_sent_mail($subject,$mail_body, $rety_email, $headers, $attachments);          
             }elseif( 'mailgun' ==  $mailer_form_name ){
                $this->admin_class->utils->twinkle_mailgun_sent_mail($subject,$mail_body, $rety_email, $headers, $attachments);
             }
    
             
            $send_status = ( isset( $_SESSION['send_status']) ) ?  $_SESSION['send_status'] : '';

            // Start query here
            $email_log_sql = "SELECT * FROM $table_name";
            $email_logs    = $wpdb->get_results($email_log_sql);

            // init dataTable here
            $tableData = [];

            foreach ($email_logs as $email_log) {
                $to_email      = $email_log->to;
                $from_email    = $email_log->form;
                $email_subject = $email_log->subject;
                $status        = $email_log->status;
                $timestamp     = strtotime($email_log->created_at);
                $date_time     = date("d-M-Y", $timestamp);
                $status_label  = '';
                $status_class  = '';
                $total_resend  = '';

                if( 'success' === $email_log->status ){
                    if( !empty( $email_log->total_resend ) && $email_log->total_resend != '0' ){
                        $total_resend = $email_log->total_resend;
                        $status_label = 'Resend ' . '('. $total_resend . ')';
                    }else{
                        $status_label = 'Resend ';
                    } 
                    $status_class = "twinkle_smtp_resend";
                }else{
                    $status_label = 'Retry';
                }

                $action = "<a onclick='failed_email_retry(this,$email_log->id)' class='twinkle_smtp_btn_retry  $status_class' href='javascript:void(0)'><span class='dashicons dashicons-update-alt'></span>$status_label</a>";

                $action .= "<a onclick='twinkle_smtp_get_email_log_by_id($email_log->id);' class='twinkle_smtp_btn_view' href='javascript:void(0)'><span class='dashicons dashicons-visibility'></span></a>";

                $action .= " <a href='#' class='twinkle_smtp_btn_delete' onclick='delete_twinkle_smtp_logs(  $email_log->id );'> <span class='dashicons dashicons-trash'></span></a>";
                
                $single_check = "<input type='checkbox' onchange='check_items_control();'  name='twinkle_smtp_check_single[]' class='twinkle_smtp_check_single' value='$email_log->id'> ";

                $tableData[] = array(
                    // columns dynamic valus
                    $single_check,
                    $to_email,
                    $from_email,
                    $email_subject,
                    $status,
                    $date_time,
                    $action,
                    // table columns
                    '',
                    'to_email',
                    'from_email',
                    'email_subject',
                    'status',
                    'date',
                    'action'
                );
            }

            $result['draw'] = 1;
            $result['recordsTotal'] = 1;
            $result['recordsFiltered'] = 1;
            $result['data'] = $tableData;
            $result['status'] = $send_status;
            
        }else{
            $result['draw'] = 0;
            $result['recordsTotal'] = 0;
            $result['recordsFiltered'] = 0;
            $result['data'] = [];
            $result['status'] = 'failed';
        }


    } else {
        $result['draw'] = 0;
        $result['recordsTotal'] = 0;
        $result['recordsFiltered'] = 0;
        $result['data'] = [];
        $result['status'] = 'failed';
    }
} else {
    $result['draw'] = 0;
    $result['recordsTotal'] = 0;
    $result['recordsFiltered'] = 0;
    $result['data'] = [];
    $result['status'] = 'failed';
}

unset($_SESSION['send_status']);
echo json_encode($result,  JSON_UNESCAPED_UNICODE);
exit;
