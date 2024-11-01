<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!class_exists('TwinkleSMTPDB')) {
    class TwinkleSMTPDB
    {

        public $admin_class;
        public $wpdb;

        function __construct($admin_obj)
        {

            $this->admin_class = $admin_obj;

            global $wpdb;
            $this->wpdb = $wpdb;

            $twinkle_smtp_settings = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}twinkle_smtp_settings` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `settings_key` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ,
            `settings_value` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            ";

            $twinkle_smtp_mail_logs = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}twinkle_smtp_mail_logs` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `form` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `to` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `subject` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `message` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `headers` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `attachments` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `status` enum('success','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `exception_code` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `error_message` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            `total_resend` int(4) NOT NULL DEFAULT 0,
            `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
            ";

            include_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($twinkle_smtp_settings);
            dbDelta($twinkle_smtp_mail_logs);
        }


       public function update_mailer_data_old($key, $value = Null) {
            $table_name = $this->wpdb->prefix . 'twinkle_smtp_settings';
            $is_exits   = $this->wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE `settings_key` = '$key'");

            if ($value != Null) {
                if ($is_exits > 0) {
                    $data = ['settings_value' => $value];
                    $this->wpdb->update($table_name, $data, ['settings_key' => $key]);
                } else {
                    $data = [
                        'settings_key' => $key,
                        'settings_value' => $value
                    ];
                    $this->wpdb->insert($table_name, $data, ['%s', '%s']);
                }
            } else {
                if ($is_exits > 0) {
                    return $this->wpdb->get_var("SELECT settings_value FROM $table_name WHERE `settings_key` = '$key'");
                }
            }
            return Null;
        }
       
        /**
         * Define update mailer data
         * 
         * @param $key - string
         * @param $value - string
         * @param $action - string
         * 
         * @return void
         * 
         * Author : WPCommerz
         * Develop on : 03-02-2022
         * Update on : 03-03-2022
         * Version : 1.0.1
         * 
         * Develop By : Fsarkar
         * Updated By : Sm. Sazzad 
         */
        public function update_mailer_data($key, $value = Null, $action = Null) {
            $table_name = $this->wpdb->prefix . 'twinkle_smtp_settings';
            $is_exits   = $this->wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE `settings_key` = '$key'");

            if ($value != Null) {
                if ($is_exits > 0) {
                    $data = ['settings_value' => $value];
                    $this->wpdb->update($table_name, $data, ['settings_key' => $key]);
                } else {
                    $data = [
                        'settings_key' => $key,
                        'settings_value' => $value
                    ];
                    $this->wpdb->insert($table_name, $data, ['%s', '%s']);
                }
            } else {
                if( !empty( $action ) && $action == 'setnull' ){
                    $data = ['settings_value' => ''];
                    $this->wpdb->update($table_name, $data, ['settings_key' => $key]);
                    return true;
                }else{
                    if ($is_exits > 0) {
                        return $this->wpdb->get_var("SELECT settings_value FROM $table_name WHERE `settings_key` = '$key'");
                    }
                }
            }
            return Null;
        }

        function insert_mail_logs($data) {
            $table_name =  $this->wpdb->prefix . 'twinkle_smtp_mail_logs';

             $this->wpdb->insert($table_name, $data, ['%s', '%s', '%s', '%s','%s','%s','%s','%s','%s','%s','%s']);

            if ( $this->wpdb->insert_id ) {
                return true;
            }

            return false;
        }


       public function get_default_mailer_data() {
            $table_name = $this->wpdb->prefix . 'twinkle_smtp_setting';
            $result = $this->wpdb->get_results("SELECT * FROM $table_name WHERE 1=1", ARRAY_A);
            return $result;
        }

        public function update_mail_logs( $data, $update_id ){

            $table_name =  $this->wpdb->prefix . 'twinkle_smtp_mail_logs';

            $result = $this->wpdb->update($table_name,$data,['id'=>$update_id],['%s', '%s', '%s', '%s','%s','%s','%s','%s','%s','%s','%s']);

            if ( false === $result ) {
                return true;
            } else {
                return false;
            }
        }

        //Unset default mailer data
        public function unset_default_mailer_data(){
            $this->update_mailer_data( 'default_from_email', '', 'setnull' );
            $this->update_mailer_data( 'default_from_name', '','setnull' );
            $this->update_mailer_data( 'default_smtp_host', '','setnull' );
            $this->update_mailer_data( 'default_smtp_port', '','setnull' );
            $this->update_mailer_data( 'default_type_of_encryption', '','setnull' );
            $this->update_mailer_data( 'default_auth_type', '','setnull' );
            $this->update_mailer_data( 'default_smtp_username', '','setnull' );
            $this->update_mailer_data( 'default_smtp_password', '','setnull' );
            $this->update_mailer_data( 'default_bcc_email', '','setnull' );
        }

        //Unset sendgrid mailer data
        public function unset_sendgrid_mailer_data(){
            $this->update_mailer_data( 'sendgrid_from_email', '', 'setnull' );
            $this->update_mailer_data( 'sendgrid_from_name', '', 'setnull' );
            $this->update_mailer_data( 'sendgrid_api_key', '', 'setnull' );
            
        }

        //Unset sendinblue mailer data
        public function unset_sendinblue_mailer_data(){
            $this->update_mailer_data( 'sendinblue_from_email', '', 'setnull' );
            $this->update_mailer_data( 'sendinblue_from_name', '', 'setnull' );
            $this->update_mailer_data( 'sendinblue_api_key', '', 'setnull' );
            
        }


        //Unset postmark mailer data
        public function unset_postmark_mailer_data(){
            $this->update_mailer_data( 'postmark_from_email', '', 'setnull' );
            $this->update_mailer_data( 'postmark_from_name', '', 'setnull' );
            $this->update_mailer_data( 'postmark_api_key', '', 'setnull' );
            
        }

        //Unset sparkpost mailer data
        public function unset_sparkpost_mailer_data(){
            $this->update_mailer_data( 'sparkpost_from_email', '', 'setnull' );
            $this->update_mailer_data( 'sparkpost_from_name', '', 'setnull' );
            $this->update_mailer_data( 'sparkpost_api_key', '', 'setnull' );
            
        }

        //Unset aws mailer data
        public function unset_aws_mailer_data(){
            $this->update_mailer_data( 'aws_from_email', '', 'setnull' );
            $this->update_mailer_data( 'aws_from_name', '', 'setnull' );
            $this->update_mailer_data( 'aws_access_key', '', 'setnull' );
            $this->update_mailer_data( 'aws_secret_key', '', 'setnull' );
            $this->update_mailer_data( 'aws_region', '', 'setnull' );     
        }

        //Unset aws mailer data
        public function unset_mailgun_mailer_data(){
            $this->update_mailer_data( 'mailgun_from_email', '', 'setnull' );
            $this->update_mailer_data( 'mailgun_from_name', '', 'setnull' );
            $this->update_mailer_data( 'mailgun_api_key', '', 'setnull' );
            $this->update_mailer_data( 'mailgun_domain_name', '', 'setnull' );
            $this->update_mailer_data( 'mailgun_region', '', 'setnull' );     
        }

    }
}
