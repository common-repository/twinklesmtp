<?php

/* Check if user has admin capabilities */
if (current_user_can('manage_options')) {

    /* Receive post data */
    if (isset($_REQUEST['data'])) {

        $data = $_REQUEST['data'];
        $data = urldecode($data);
        $data = stripcslashes($data);
        $general_settings_data = json_decode($data, TRUE);


        foreach( $general_settings_data as  $key =>$value ) {      
            $this->admin_class->db->update_mailer_data( $key, $value );
        }

        $result = array("status" => 'true');
    } else {
        $result = array("status" => 'false');
    }
} else {
    $result = array("status" => 'false');
}


echo json_encode($result,  JSON_UNESCAPED_UNICODE);
