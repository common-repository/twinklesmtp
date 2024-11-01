<?php

/* Check if user has admin capabilities */
if (current_user_can('manage_options')) {

    /* Receive post data */
    if (isset($_REQUEST['data'])) {

        $data = $_REQUEST['data'];

        global $wpdb;
        $table_name = $wpdb->prefix . 'twinkle_smtp_mail_logs';
        $report_duration    = $this->admin_class->db->update_mailer_data("activity_report_duration", Null);

        $canvas_data = $this->admin_class->create_canvas_labels_and_data($report_duration);

        $labels = (!empty($canvas_data) && isset($canvas_data['labels'])) ? $canvas_data['labels'] : [];
        $label_values = (!empty($canvas_data) && isset($canvas_data['label_values'])) ? $canvas_data['label_values'] : [];

        // Statistics of all sent or fail
        $status_sql    = "SELECT  status  FROM $table_name";
        $status_result = $wpdb->get_results($status_sql);
        
        $total_successed = 0;
        $total_failed    = 0;
        
        if (!empty($status_result)) {
            foreach ($status_result as $status) {
                if ('success' == $status->status) {
                    $total_successed++;
                } elseif ('failed' == $status->status) {
                    $total_failed++;
                }
            }
        }


    //  Delelete logs 
    $enable_delete_log = $this->admin_class->db->update_mailer_data("enable_delete_log", Null);
    $delete_log_duration = $this->admin_class->db->update_mailer_data("delete_log_duration", Null);
    $delete_twinkle_smtp_logs = '';

        if ('yes' ===  $enable_delete_log) {

            if ( '7' == $delete_log_duration ) {
                $delete_twinkle_smtp_logs = "After 7 Days";
            } elseif ('14' == $delete_log_duration) {
                $delete_twinkle_smtp_logs = "After 14 Days";
            } elseif ('30' == $delete_log_duration) {
                $delete_twinkle_smtp_logs = "After 30 Days";
            } elseif ('60' == $delete_log_duration) {
                $delete_twinkle_smtp_logs = "After 60 Days";
            } elseif ('90' == $delete_log_duration) {
                $delete_twinkle_smtp_logs = "After 90 Days";
            } elseif ('180' == $delete_log_duration) {
                $delete_twinkle_smtp_logs = "After 6 Months";
            } elseif ('365' == $delete_log_duration) {
                $delete_twinkle_smtp_logs = "After 1 Year";
            } elseif ('730' == $delete_log_duration) {
                $delete_twinkle_smtp_logs = "After 2 Years";
            } else {
                $delete_twinkle_smtp_logs = "Schedule  not set";
            }
        } else {
            $delete_twinkle_smtp_logs = "Schedule  not set";
        }
                               

        $result = array("status" => 'true', "labels" => $labels, "label_values" => $label_values, "total_successed" => $total_successed,"total_failed" =>$total_failed,"delete_twinkle_smtp_logs" => $delete_twinkle_smtp_logs );


    } else {
        $result = array("status" => 'false');
    }
} else {
    $result = array("status" => 'false');
}

echo json_encode($result,  JSON_UNESCAPED_UNICODE);
