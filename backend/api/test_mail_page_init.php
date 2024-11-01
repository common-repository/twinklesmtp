<?php

/* Check if user has admin capabilities */
if (current_user_can('manage_options')) {

    /* Receive post data */
    if (isset($_REQUEST['data'])) {

        $data       = $_REQUEST['data'];
        $from_email = '';

        $mailer_form_name   = $this->admin_class->db->update_mailer_data("mailer_form_name", Null);
        $test_email_sent_to = $this->admin_class->db->update_mailer_data("test_email_sent_to", Null);      

         if( 'default' ==  $mailer_form_name ){
            $from_email = $this->admin_class->db->update_mailer_data("default_from_email", Null);
         }elseif( 'sendgrid' ==  $mailer_form_name ){
            $from_email = $this->admin_class->db->update_mailer_data("sendgrid_from_email", Null);
         }elseif( 'sendinblue' ==  $mailer_form_name ){
            $from_email = $this->admin_class->db->update_mailer_data("sendinblue_from_email", Null);
         }elseif( 'postmark' ==  $mailer_form_name ){
            $from_email = $this->admin_class->db->update_mailer_data("postmark_from_email", Null);
         }elseif( 'sparkpost' ==  $mailer_form_name ){
            $from_email = $this->admin_class->db->update_mailer_data("sparkpost_from_email", Null);
         }elseif( 'aws' ==  $mailer_form_name ){
            $from_email = $this->admin_class->db->update_mailer_data("aws_from_email", Null);
         }elseif( 'mailgun' ==  $mailer_form_name ){
            $from_email = $this->admin_class->db->update_mailer_data("mailgun_from_email", Null);
         }
         
       
        $result = array("status" => 'true',"from_email" => $from_email,"test_email_sent_to" => $test_email_sent_to );


    } else {
        $result = array("status" => 'false');
    }
} else {
    $result = array("status" => 'false');
}


echo json_encode($result,  JSON_UNESCAPED_UNICODE);
