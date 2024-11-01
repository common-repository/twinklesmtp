
<div id="twinkle_smtp_main">

    <div id="twinkle_smtp_header">
        <div class="twinkle_smtp_header_logo">
            <h1>Twinkle SMTP</h1>
        </div>
        <div class="twinkle_smtp_header_nav">
            <ul>
                <li class="analytics twinkle_smtp_menue_active" onclick="twinkle_smtp_init_admin_dashboard('analytics')">Dashboard</li>
                <li class="settings" onclick="twinkle_smtp_init_admin_dashboard('settings')">Settings</li>
                <li class="email_log" onclick="twinkle_smtp_init_admin_dashboard('email_log');">Email Logs</li>
                <li class="email_test" onclick="twinkle_smtp_init_admin_dashboard('email_test')">Test</li>
            </ul>
        </div>
    </div>

    <div id="twinkle_smtp_container">
        <?php include TWINKLE_SMTP_PATH . "backend/templates/views/analytics.php"; ?>
        <?php include TWINKLE_SMTP_PATH . "backend/templates/views/email-test.php"; ?>
        <?php include TWINKLE_SMTP_PATH . "backend/templates/views/email-logs.php"; ?>
        <?php include TWINKLE_SMTP_PATH . "backend/templates/views/settings.php"; ?>
    </div>

</div>

<!-- Email log view  Modal -->
<div id="twinkle_smtp_log_view" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <h2>Email Log</h2>
            <div id="cls_btn_container">
                <span id="twinkle_log_cls_btn" onclick="twinkle_smtp_get_email_log_by_id()"><span class="dashicons dashicons-no-alt"></span></span>
            </div>
        </div>
        <div class="modal-body">
            <ul>
                <li>
                    <div class="single-item" id="twinkle_smtp_single_log_status">
                        <h3 class="title">Status:</h3>
                        <h3 class="content"></h3>
                    </div>
                    <div class="single-item" id="twinkle_smtp_single_log_date">
                        <h3 class="title">Date & Time:</h3>
                        <h3 class="content"></h3>
                    </div>
                </li>
                <li>
                    <div class="single-item" id="twinkle_smtp_single_log_form">
                        <h3 class="title">From:</h3>
                        <h3 class="content"></h3>
                    </div>
                    <div class="single-item" id="twinkle_smtp_single_log_to">
                        <h3 class="title">To:</h3>
                        <h3 class="content"></h3>
                    </div>
                </li>
                <li>
                    <div class="single-item" id="twinkle_smtp_single_log_subject">
                        <h3 class="title">Subject:</h3>
                        <h3 class="content"></h3>
                    </div>
                </li>
            </ul>

            <div class="twinkle_smt_message message">
                <div class="single-item" id="twinkle_smtp_single_log_message">
                    <h3 class="title">Email Body:</h3>
                    <div class="html-content"> </div>
                </div>
            </div>

            <div class="twinkle_smt_headers message">
                <div class="single-item" id="twinkle_smtp_single_log_headers">
                    <h3 class="title">Headers:</h3>
                    <div class="content"> </div>
                </div>
            </div>

            <div class="twinkle_smt_response message">
                <div class="single-item" id="twinkle_smtp_single_log_response">
                    <h3 class="title">Response:</h3>
                    <div class="content"> </div>
                </div>
            </div>


        </div>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        'use strict';

        $('.toplevel_page_twinkle-smtp .wp-menu-name').on('click', function() {
            SMTP_REMOVE_STORAGE('page_slug');
        });

        var page_slug = (SMPT_GET_STORAGE('page_slug')) ? SMPT_GET_STORAGE('page_slug') : 'analytics';
        twinkle_smtp_init_admin_dashboard(page_slug);

        //twinkle_smtp_default_mailer_init();
        twinkle_smtp_sender_settings_init();

        // Settings Sidebar active
        $('#twinkle_smtp_settings-sidebar .sidebar-wrapper  ul li').click(function() {
            $('li').removeClass("twinkle_smtp_settings_active");
            $(this).addClass("twinkle_smtp_settings_active");
        });

        //Default mail settings
        $('.twinkle_smtp_mailer_radio_input_wrapper input').on('click', function(e) {
            $(".twinkle_smtp_mailer_design_img").removeClass("twinkle_smtp_mailer_image_border");
            $(this).parents(".twinkle_smtp_mailer_design_single").find(".twinkle_smtp_mailer_design_img").addClass("twinkle_smtp_mailer_image_border");
        });

    });
</script>