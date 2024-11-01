<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!class_exists('TwinkleSMTPAdminAjax')) {
    class TwinkleSMTPAdminAjax {
        public $admin_class;

        public function __construct($admin_obj) {
            $this->admin_class = $admin_obj;

            add_action( 'wp_ajax_twinkle_smtp_default_mailer', array($this, 'twinkle_smtp_default_mailer') );
            add_action( 'wp_ajax_twinkle_smtp_test_email', array($this, 'twinkle_smtp_test_email') );
            add_action( 'wp_ajax_twinkle_smtp_email_logs_datatable', array($this, 'twinkle_smtp_email_logs_datatable') );
            add_action( 'wp_ajax_twinkle_smtp_delete_email_logs', array($this, 'twinkle_smtp_delete_email_logs') );
            add_action( 'wp_ajax_twinkle_smtp_ general_settings', array($this, 'twinkle_smtp_general_settings') );
            add_action( 'wp_ajax_twinkle_smtp_analytics', array($this, 'twinkle_smtp_analytics') );
            add_action( 'wp_ajax_twinkle_smtp_mail_test_page_init', array($this, 'twinkle_smtp_mail_test_page_init') );
            add_action( 'wp_ajax_twinkle_smtp_mail_retry', array($this, 'twinkle_smtp_mail_retry') );
            add_action( 'wp_ajax_twinkle_smtp_sendgrid_mailer', array($this, 'twinkle_smtp_sendgrid_mailer') );
            add_action( 'wp_ajax_twinkle_smtp_sendinblue_mailer', array($this, 'twinkle_smtp_sendinblue_mailer') );
            add_action( 'wp_ajax_twinkle_smtp_pepipost_mailer', array($this, 'twinkle_smtp_pepipost_mailer') );
            add_action( 'wp_ajax_twinkle_smtp_postmark_mailer', array($this, 'twinkle_smtp_postmark_mailer') );
            add_action( 'wp_ajax_twinkle_smtp_sparkpost_mailer', array($this, 'twinkle_smtp_sparkpost_mailer') );
            add_action( 'wp_ajax_twinkle_smtp_aws_mailer', array($this, 'twinkle_smtp_aws_mailer') );
            add_action( 'wp_ajax_twinkle_smtp_mailgun_mailer', array($this, 'twinkle_smtp_mailgun_mailer') );

            // for manage log
            add_action( 'wp_ajax_twinkle_smtp_get_email_log', array($this, 'twinkle_smtp_get_email_log') );
        }


        public function twinkle_smtp_mailgun_mailer(){
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_mailgun_mailer.php";
            wp_die(); 
        }
        public function twinkle_smtp_aws_mailer(){
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_aws_mailer.php";
            wp_die(); 
        }

        public function twinkle_smtp_sparkpost_mailer(){
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_sparkpost_mailer.php";
            wp_die(); 
        }

        public function twinkle_smtp_postmark_mailer(){
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_postmark_mailer.php";
            wp_die(); 
        }

        public function twinkle_smtp_pepipost_mailer(){
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_pepipost_mailer.php";
            wp_die(); 
        }

        public function twinkle_smtp_get_email_log()
        {
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_get_log.php";
            wp_die();
        }

       public function twinkle_smtp_default_mailer() {
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_default_mailer.php";
            wp_die();
        }

       public function twinkle_smtp_sendgrid_mailer() {
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_sendgrid_mailer.php";
            wp_die();
        }

       public function twinkle_smtp_sendinblue_mailer() {
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_sendinblue_mailer.php";
            wp_die();
        }

        public function twinkle_smtp_test_email(){
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_test_email.php";
            wp_die();
        }

        public function twinkle_smtp_email_logs_datatable()
        {
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_email_logs_datatable.php";
            wp_die();
        }

        public function twinkle_smtp_delete_email_logs()
        {
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_delete_email_logs.php";
            wp_die();
        }

        public function twinkle_smtp_general_settings() {
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_general_settings.php";
            wp_die();
        }

        public function twinkle_smtp_analytics(){
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_analytics.php";
            wp_die();
        }

        public function twinkle_smtp_mail_test_page_init() {
            include_once TWINKLE_SMTP_PATH . "backend/api/test_mail_page_init.php";
            wp_die();
        }

        public function twinkle_smtp_mail_retry() {
            include_once TWINKLE_SMTP_PATH . "backend/api/twinkle_smtp_mail_retry.php";
            wp_die();
        }
       

    }
}
