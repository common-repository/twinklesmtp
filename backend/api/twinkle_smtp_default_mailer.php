<?php

/* Check if user has admin capabilities */
if (current_user_can('manage_options')) {

    /* Receive post data */
    if (isset($_REQUEST['data'])) {

        $data = $_REQUEST['data'];
        $data = urldecode($data);
        $data = stripcslashes($data);
        $default_mailer_data = json_decode($data, TRUE);

        foreach( $default_mailer_data as  $key =>$value ) {
            if( 'default_smtp_password' == $key ){
                $value =  base64_encode($value);
            }

            if( 'default_bcc_email' == $key ){
                if( empty( $value )){
                    $value = '';
                }
            }
            
            $this->admin_class->db->update_mailer_data( $key, $value );
        }

        $this->admin_class->db->update_mailer_data('mailer_form_name', 'default');

        // Unset all forms
        $this->admin_class->db->unset_sendgrid_mailer_data();
        $this->admin_class->db->unset_sendinblue_mailer_data();
        $this->admin_class->db->unset_postmark_mailer_data();
        $this->admin_class->db->unset_sparkpost_mailer_data();
        $this->admin_class->db->unset_aws_mailer_data();
        $this->admin_class->db->unset_mailgun_mailer_data();



        $result = array("status" => 'true');
    } else {
        $result = array("status" => 'false');
    }
} else {
    $result = array("status" => 'false');
}


echo json_encode($result,  JSON_UNESCAPED_UNICODE);
