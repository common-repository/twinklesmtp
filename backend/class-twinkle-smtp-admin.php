<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!class_exists('TwinkleSMTPAdmin')) {
    class TwinkleSMTPAdmin
    {
        public $utils;
        public $db;
        public $FromName  = '';
        public $logsData = [];
        public $is_default = true;

        public function __construct()
        {
            $this->utils = new TwinkleSMTPUtils($this);

            add_action("admin_menu", array($this, 'twinkle_smtp_admin_menu'));
            add_action('admin_enqueue_scripts', array($this, 'twinkle_smtp_admin_enqueue'));
            add_action('plugin_action_links_' . TWINKLE_SMTP_BASE_PATH, array($this, 'twinkle_smtp_action_links'));
            add_action('phpmailer_init', array($this, 'twinkle_smtp_default_mailer_settings'));
            add_filter('wp_mail_succeeded', array($this, 'twinkle_smtp_mail_succeeded'));
            add_action('wp_mail_failed', array($this, 'twinkle_smtp_mail_failed'));
            add_filter('wp_mail', [$this, 'twinkle_smtp_mail_information']);
            add_action('wp_dashboard_setup', [$this, 'twinkle_smtp_dashboard_widgets'], 10);

            $this->db = new TwinkleSMTPDB($this);
            new TwinkleSMTPAdminAjax($this);

            $delete_log   = $this->db->update_mailer_data("enable_delete_log", Null);

            if ('yes' === $delete_log) {
                add_filter('cron_schedules', [$this,  'delete_log_schedules']);
                add_action('admin_init', [$this, 'delete_log_schedule_event']);
                add_action('deletelog_cron_hook', [$this, 'twinkle_smtp_delete_log']);
            }
        }

       public function twinkle_smtp_mail_information($args) {

            $this->logsData['form']        = $this->db->update_mailer_data("default_from_email", Null);
            $this->logsData['to']          = $args['to'];
            $this->logsData['subject']     = $args['subject'];
            $this->logsData['message']     = $args['message'];
            $this->logsData['headers']     =  serialize($args['headers']);
            $this->logsData['attachments'] =  serialize($args['attachments']);

            $mailer_form_name  = $this->db->update_mailer_data('mailer_form_name',null);

            if( 'sendgrid' == $mailer_form_name ){
                $this->is_default = false;
                $this->utils->twinkle_smtp_sendgrid_sent_mail($args['subject'], $args['message'],$args['to'],$args['headers'],$args['attachments'] );
            }elseif( 'sendinblue' == $mailer_form_name ){
               $this->is_default = false;
               $this->utils->twinkle_smtp_sendinblue_sent_mail($args['subject'], $args['message'],$args['to'],$args['headers'],$args['attachments']);       
            }elseif( 'postmark' == $mailer_form_name ){
                $this->is_default = false;
                $this->utils->twinkle_smtp_postmark_sent_mail($args['subject'], $args['message'],$args['to'],$args['headers'],$args['attachments']);       
            }elseif( 'sparkpost' == $mailer_form_name ){
                $this->is_default = false;
                $this->utils->twinkle_smtp_sparkpost_sent_mail($args['subject'], $args['message'],$args['to'],$args['headers'],$args['attachments']);                    
            }elseif( 'aws' == $mailer_form_name ){
                $this->is_default = false;
                $this->utils->twinkle_aws_sent_mail($args['subject'], $args['message'],$args['to'],$args['headers'],$args['attachments']);       
            }elseif( 'mailgun' == $mailer_form_name ){
                $this->is_default = false;
                $this->utils->twinkle_mailgun_sent_mail($args['subject'], $args['message'],$args['to'],$args['headers'],$args['attachments']);       
                
            }

            
        }

        function twinkle_smtp_action_links($links)
        {
            $settings_url = add_query_arg('page', 'twinkle-smtp', get_admin_url() . 'admin.php');
            $setting_arr = array('<a href="' . esc_url($settings_url) . '">Dashboard</a>');
            $links = array_merge($setting_arr, $links);
            return $links;
        }

        function twinkle_smtp_admin_menu()
        {
            $icon_url = TWINKLE_SMTP_IMG_DIR . "twinkle_smtp_icon.svg";
            add_menu_page("TwinkleSMTP", "TwinkleSMTP", 'manage_options', "twinkle-smtp", array($this, 'twinkle_smtp_admin_dashboard'), $icon_url, 6);
        }

        function twinkle_smtp_admin_enqueue($page)
        {
            if ($page == "toplevel_page_twinkle-smtp") {
                $this->utils->enqueue_style('data-tables', 'twinkle-smtp-data-tables.css');
                $this->utils->enqueue_style('daterangepicke', 'daterangepicker.css');
                $this->utils->enqueue_style('toastr', 'toastr.min.css');
                $this->utils->enqueue_style('nice-select', 'nice-select.css');
                $this->utils->enqueue_style('admin', 'admin.css');
                $this->utils->enqueue_style('responsive', 'responsive.css');
                $this->utils->enqueue_style('tooltip', 'css-tooltip.css');
                $this->utils->enqueue_script('analytics', 'analytics.js', array('jquery'));
                $this->utils->enqueue_script('settings', 'settings.js', array('jquery'));
                $this->utils->enqueue_script('test-email', 'email_test.js', array('jquery'));
                $this->utils->enqueue_script('emails', 'emails.js', array('jquery'));
                $this->utils->enqueue_script('chart', 'twinkle_smtp_chart.js', array('jquery'));
                $this->utils->enqueue_script('data-tables', 'twinkle-smtp-data-tables.js', array('jquery'));
                $this->utils->enqueue_script('moment', 'moment.min.js', array('jquery'));
                $this->utils->enqueue_script('date-range-picker', 'daterangepicker.min.js', array('jquery'));
                $this->utils->enqueue_script('form-validate', 'jquery.validate.js', array('jquery'));
                $this->utils->enqueue_script('toastr', 'toastr.min.js', array('jquery'));
                $this->utils->enqueue_script('email-log', 'email_log.js', array('jquery'));
                $this->utils->enqueue_script('select', 'select.min.js', array('jquery'));
                $this->utils->enqueue_script('admin', 'admin.js', array('jquery'));
            }
        }

        function twinkle_smtp_admin_dashboard()
        {
            include_once TWINKLE_SMTP_PATH . "backend/templates/dashboard.php";
        }

        function twinkle_smtp_default_mailer_settings($phpmailer) {
          
            if( ! $this->is_default  ){
                return;
            }

          
            $default_from_email       = $this->db->update_mailer_data("default_from_email", Null);
            $default_from_name        = $this->db->update_mailer_data("default_from_name", Null);
            $default_bcc_email        = $this->db->update_mailer_data("default_bcc_email", Null);
            $default_smtp_host        = $this->db->update_mailer_data("default_smtp_host", Null);
            $default_smtp_port        = $this->db->update_mailer_data("default_smtp_port", Null);
            $default_auth_type        = $this->db->update_mailer_data("default_auth_type", Null);
            $default_smtp_username    = $this->db->update_mailer_data("default_smtp_username", Null);
            $default_typof_encryption = $this->db->update_mailer_data("default_type_of_encryption", Null);
            $default_smtp_password    = $this->db->update_mailer_data("default_smtp_password", Null);

            $phpmailer->isSMTP();
            $phpmailer->Host       = $default_smtp_host;
            $phpmailer->SMTPAuth   = $default_auth_type;
            $phpmailer->Port       = $default_smtp_port;
            $phpmailer->Username   = $default_smtp_username;
            $phpmailer->Password   = base64_decode($default_smtp_password);
            $phpmailer->SMTPSecure = $default_typof_encryption;
            $phpmailer->From       = $default_from_email;
            $phpmailer->FromName   = $default_from_name;
        }

        function twinkle_smtp_mail_succeeded($mail_succeeded)
        {
            if(  !  $this->is_default  ){
                return;
            }

            $this->logsData['status'] = 'success';
            $this->logsData['exception_code'] = '';
            $this->logsData['error_message']  = '';

            //Update log If already exists
            $update_log_id = ( isset( $_SESSION['update_log_id']) ) ?  $_SESSION['update_log_id'] : '';
        
            if( !empty( $update_log_id )){
                
                $update_total_resend = ( isset( $_SESSION['update_total_resend']) ) ?  $_SESSION['update_total_resend'] : 0;

                $this->logsData['total_resend'] = $update_total_resend + 1;     
               
                $this->db->update_mail_logs($this->logsData, $update_log_id);             
            }else{
                //$this->logsData['total_resend'] = '0';
                $this->db->insert_mail_logs($this->logsData);     
            }

            // set session data
            $_SESSION["send_status"] = "success";
            // unset session data
            unset($_SESSION['update_log_id']);
            unset($_SESSION['update_total_resend']);

        }

        function twinkle_smtp_mail_failed($mail_error)
        {

            if(  !  $this->is_default  ){
                return;
            }

            $this->logsData['status'] = 'failed';
            $this->logsData['exception_code'] = $mail_error->error_data['wp_mail_failed']['phpmailer_exception_code'];
            $this->logsData['error_message'] = $mail_error->errors['wp_mail_failed'][0];
            $this->logsData['total_resend'] = '';

            //Update log If already exists
            $update_log_id = ( isset( $_SESSION['update_log_id']) ) ?  $_SESSION['update_log_id'] : '';


            if( !empty( $update_log_id )){
                $this->db->update_mail_logs($this->logsData, $update_log_id);
            }else{
                $this->db->insert_mail_logs($this->logsData);
            }

            // set session data
            $_SESSION["send_status"] = "failed";
            // unset session data
            unset($_SESSION['update_log_id']);
        }

        public function delete_log_schedules()
        {

            $schedules = array();
            $delete_log_duration = $this->db->update_mailer_data("delete_log_duration", Null);

            if (!empty($delete_log_duration) && $delete_log_duration > 0) {
                $interval = 60 * 60 * 24 * $delete_log_duration;  
                $display  = rand(10, 100);

                $schedules['delete_log_schedule'] = array(
                    'interval' =>  $interval,
                    'display'  =>  $display,
                );
            }

            return $schedules;
        }


        public function twinkle_smtp_delete_log()
        {

            $enable_delete_log   = $this->db->update_mailer_data("enable_delete_log", Null);
            $delete_log_duration = $this->db->update_mailer_data("delete_log_duration", Null);

            if ('yes' ===  $enable_delete_log) {
                global $wpdb;
                $table_name = $wpdb->prefix . 'twinkle_smtp_mail_logs';

                $sql = "DELETE  FROM $table_name WHERE created_at BETWEEN NOW() - INTERVAL $delete_log_duration DAY AND NOW()";

                $wpdb->query($sql);
            }
        }

        public function delete_log_schedule_event()
        {
            $res = $this->delete_log_schedules();
            // Schedule the event if it is not scheduled.
            if (!empty($res) && !wp_next_scheduled('deletelog_cron_hook')) {
                wp_schedule_event(time(), 'delete_log_schedule', 'deletelog_cron_hook');
            }
        }

        public function create_canvas_labels_and_data($duration = '')
        {
            $results        = array();
            $label_values   = array();
            $labels       = array();

            if (empty($duration)) {
                return $results;
            }

            for ($i = $duration; $i >= 0; --$i) {
                $create_date = date('j M', strtotime("-$i days"));
                $labels[] = $create_date;
                $label_values[] =  $this->get_analytics_data($create_date);
            }

            return $results = array('labels' => $labels, 'label_values' => $label_values);
        }

        public function get_analytics_data($given_date = '')
        {
            $total = 0;
            if (empty($given_date)) {
                return $total;
            }

            global $wpdb;
            $table_name = $wpdb->prefix . 'twinkle_smtp_mail_logs';

            // create date range by given date
            $to_date = date('Y-m-d 00:00:00', strtotime($given_date));
            $from_date = date('Y-m-d 23:59:59', strtotime($given_date));

            $sqlQuery = "SELECT                    
                 date(created_at), 
                 DATE_FORMAT(created_at, '%d %b') as label_data, status,
                 count(id) as total
                 FROM $table_name 
                 WHERE  status='success' AND created_at BETWEEN '" . $to_date . "' AND '" . $from_date . "'
                 GROUP BY  date(created_at)
                ";

            $query_result =  $wpdb->get_row($sqlQuery);
            if (!empty($query_result)) {
                $total = $query_result->total;
            }

            return $total;
        }


        public function twinkle_smtp_dashboard_widgets()
        {
            wp_add_dashboard_widget('twinkle_smtp_analytics', esc_html__('Twinkle SMTP', 'darklup'), [
                $this,
                'twinkle_smtp_analytics_dashboard_widget'
            ]);

            // Globalize the metaboxes array, this holds all the widgets for wp-admin.
            global $wp_meta_boxes;

            // Get the regular dashboard widgets array
            // (which already has our new widget but appended at the end).
            $default_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

            // Backup and delete our new dashboard widget from the end of the array.
            $twinkle_smtp_widget_backup = array('twinkle_smtp_analytics' => $default_dashboard['twinkle_smtp_analytics']);
            unset($default_dashboard['twinkle_smtp_analytics']);

            // Merge the two arrays together so our widget is at the beginning.
            $sorted_dashboard = array_merge($twinkle_smtp_widget_backup, $default_dashboard);

            // Save the sorted array back into the original metaboxes.
            $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
        }

        public function twinkle_smtp_analytics_dashboard_widget()
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'twinkle_smtp_mail_logs';
            
            $start_date = date('Y-m-d 00:00:00',strtotime("-14 days"));
            $end_date   = date( 'Y-m-d 23:59:59' );

            $sql = "SELECT * 
                        FROM $table_name
                        WHERE created_at BETWEEN '". $start_date ."' AND '". $end_date ."' ";
            $results   = $wpdb->get_results( $sql );

            

            // start data calculation here..
            $today_date        = date("Y-m-d");
            $last_seven_day    = date('Y-m-d',strtotime("-7 days"));

            // define calculate variables
            $total_success_today        = 0;
            $total_failed_today         = 0;

            $total_success_sevendays    = 0;
            $total_failed_sevendays     = 0;

            $total_success_fourteendays = 0;
            $total_failed_fourteendays  = 0;

            if( !empty( $results ) ){
                foreach( $results as $row ){
                    // get create date
                    $created_at = date("Y-m-d",strtotime($row->created_at));

                    // get fourteen days data
                    if( $row->status == 'success' ){
                        $total_success_fourteendays += 1;
                    }
                    if( $row->status == 'failed' ){
                        $total_failed_fourteendays += 1;
                    }

                    // get today data
                    if( $today_date ==  $created_at ){
                        if( $row->status == 'success' ){
                            $total_success_today += 1;
                        }
                        if( $row->status == 'failed' ){
                            $total_failed_today += 1;
                        } 
                    }

                    // get fourteen days data
                    if( ( $last_seven_day <= $today_date ) && ( $created_at >= $last_seven_day ) ){
                        if( $row->status == 'success' ){
                            $total_success_sevendays += 1;
                        }
                        if( $row->status == 'failed' ){
                            $total_failed_sevendays += 1;
                        }
                    }
    
                }
            }
   
            $twinkle_smtp_url =  get_admin_url() .'admin.php?page=twinkle-smtp';
        ?>
            <div class="twinkle-smtp-chart-wrapper">
                <table class="twinkle_smtp_dash_table wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Sent</th>
                            <th>Failed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Today</td>
                            <td><?php echo $total_success_today; ?></td>
                            <td  <?php echo '0'!= $total_failed_today? 'style="color:red;font-weight:bold;"' : '' ?> ><?php echo  $total_failed_today; ?></td>
                        </tr>
                        <tr>
                            <td>Last 7 days</td>
                            <td><?php echo $total_success_sevendays; ?></td>
                            <td  <?php echo '0'!= $total_failed_sevendays? 'style="color:red;font-weight:bold;"' : '' ?>><?php echo $total_failed_sevendays; ?></td>
                        </tr>
                        <tr>
                            <td>Last 14 days</td>
                            <td><?php echo $total_success_fourteendays; ?></td>
                            <td <?php echo '0'!= $total_failed_fourteendays? 'style="color:red;font-weight:bold;"' : '' ?>><?php echo $total_failed_fourteendays; ?></td>
                        </tr>
                    </tbody>
                </table>

                <a style="text-decoration: none; padding-top: 10px; display: block" href="<?php echo $twinkle_smtp_url ?>" class="">View All</a>

               



            </div>

<?php
        }
    }
}


new TwinkleSMTPAdmin();
