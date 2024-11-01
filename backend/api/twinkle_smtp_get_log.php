<?php

/* Check if user has admin capabilities */
if (current_user_can('manage_options')) {

    /* Receive post data */
    if (isset($_REQUEST['data'])) {

        $data = $_REQUEST['data'];
        if( !empty( $data ) && isset( $data['logid'] ) && !empty( $data['logid'] ) ){

            global $wpdb;
            $table_name = $wpdb->prefix . 'twinkle_smtp_mail_logs';
            $sql        = "SELECT *  FROM $table_name WHERE id='". $data['logid'] ."'";
            $results    = $wpdb->get_row($sql);

            $timestamp     = strtotime($results->created_at);
            $date_time     = date("F j, Y, g:i a", $timestamp) ;

            $modal_data = [
                'form'           => $results->form,
                'to'             => $results->to,
                'status'         => ucfirst( $results->status ) ,
                'subject'        => $results->subject,
                'message'        => $results->message,
                'headers'        => maybe_unserialize( $results->headers),
                'exception_code' => $results->exception_code,
                'error_message'  => $results->error_message ? $results->error_message: 'Ok',
                'date_time'      => $date_time,
            ];

            if( !empty( $modal_data) ){
                $result = array("status" => 'true', 'data' => $modal_data);
            }else{
                $result = array("status" => 'false', 'data' => [] );
            }          

        }else{
            $result = array("status" => 'false', 'data' => []); 
        }

    } else {
        $result = array("status" => 'false', 'data' => []);
    }
} else {
    $result = array("status" => 'false', 'data' => []);
}


echo json_encode($result,  JSON_UNESCAPED_UNICODE);
