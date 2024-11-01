<?php

/* Check if user has admin capabilities */
if (current_user_can('manage_options')) {
    $result = array();
    /* Receive post data */
    if (isset($_REQUEST['data'])) {
        
        $data = $_REQUEST['data']; 

        global $wpdb;
        $table_name = $wpdb->prefix . 'twinkle_smtp_mail_logs';
        
        $whereCluse = "";
        if( !empty( $data ) && is_array( $data ) ){
            if( isset( $data['filter_type'] ) && !empty( $data['filter_type'] ) && ( $data['filter_type'] === 'status_filter' ) ){
                if( isset( $data['filter_by'] ) && !empty( $data['filter_by'] ) ){
                    $whereCluse = " WHERE status = '".$data['filter_by']."' ";
                }
            }else if( isset( $data['filter_type'] ) && !empty( $data['filter_type'] ) && ( $data['filter_type'] === 'date_filter' ) ){
                if( ( isset( $data['start_date'] ) && !empty( $data['start_date'] ) ) && ( isset( $data['end_date'] ) && !empty( $data['end_date'] ) ) ){
                    $start_date = date('Y-m-d 00:00:00', strtotime($data['start_date']) );
                    $end_date   = date('Y-m-d 23:59:59', strtotime($data['end_date']) );
                    $whereCluse = " WHERE created_at BETWEEN '". $start_date ."' AND '". $end_date ."' ";
                }
            }else{
                // something is here
            }
        }

        // start query here
        $email_log_sql = "SELECT * FROM $table_name ".$whereCluse." ";
        $email_logs    = $wpdb->get_results( $email_log_sql );

        // init dataTable here
        $tableData = [];
        $emailBody = [];

        foreach(  $email_logs as $email_log ){
            $to_email      = $email_log->to;
            $from_email    = $email_log->form;
            $email_subject = $email_log->subject;
            $status        = ucfirst($email_log->status);
            $timestamp     = strtotime($email_log->created_at);
            $date_time     = date("F j, Y, g:i a", $timestamp) ;
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
    } else {
        $result['draw'] = 0;
        $result['recordsTotal'] = 0;
        $result['recordsFiltered'] = 0;
        $result['data'] = [];
    }

} else {
    $result['draw'] = 0;
    $result['recordsTotal'] = 0;
    $result['recordsFiltered'] = 0;
    $result['data'] = [];
}

echo json_encode($result,  JSON_UNESCAPED_UNICODE);