<?php
   $mailer_form_name = $this->db->update_mailer_data("mailer_form_name", Null);
?>

<div id="twinkle_smtp_sender_settings">
    <div class="twinkle_smtp_sender_settings_tab_body">
        <div class="twinkle_smtp_sender_settings_tab_title">
            <h2>Mailer</h2>
        </div>
        <div class="twinkle_smtp_mailer_wrapper">
            <label class="twinkle_smtp_mailer_design_single">
                <div class="twinkle_smtp_mailer_design_img twinkle_smtp_mailer_image_border">
                    <img src="<?php echo TWINKLE_SMTP_IMG_DIR . 'php.png'; ?>">
                </div>
                <div class="twinkle_smtp_mailer_radio_input_wrapper">
                    <input class="twinkle_smtp_mailer_radio" type="radio" name="twinkle_smtp_mailer_radio" id="twinkle_smtp_default_radio" value="1" data-mailer="default" <?php echo 'default' == $mailer_form_name? 'checked' : ''  ?>>
                    <span class="label-text">Default</span>
                </div>
            </label>
            <label class="twinkle_smtp_mailer_design_single">
                <div class="twinkle_smtp_mailer_design_img twinkle_smtp_mailer_image_border">
                    <img src="<?php echo TWINKLE_SMTP_IMG_DIR . 'sendgrid.png'; ?>">
                </div>
                <div class="twinkle_smtp_mailer_radio_input_wrapper">
                    <input class="twinkle_smtp_mailer_radio" type="radio" name="twinkle_smtp_mailer_radio" id="twinkle_smtp_sendgrid_radio" value="1" data-mailer="sendgrid" <?php echo 'sendgrid' == $mailer_form_name? 'checked' : ''  ?>>
                    <span class="label-text">SendGrid</span>
                </div>
            </label>
            <label class="twinkle_smtp_mailer_design_single">
                <div class="twinkle_smtp_mailer_design_img twinkle_smtp_mailer_image_border">
                    <img src="<?php echo TWINKLE_SMTP_IMG_DIR . 'sendinblue.png'; ?>">
                </div>
                <div class="twinkle_smtp_mailer_radio_input_wrapper">
                    <input class="twinkle_smtp_mailer_radio" type="radio" name="twinkle_smtp_mailer_radio" id="twinkle_smtp_sendinblue_radio" value="1" data-mailer="sendinblue" <?php echo 'sendinblue' == $mailer_form_name? 'checked' : ''  ?>>
                    <span class="label-text">Sendinblue</span>
                </div>
            </label>
            
            <label class="twinkle_smtp_mailer_design_single">
                <div class="twinkle_smtp_mailer_design_img twinkle_smtp_mailer_image_border">
                    <img src="<?php echo TWINKLE_SMTP_IMG_DIR . 'postmark.png'; ?>">
                </div>
                <div class="twinkle_smtp_mailer_radio_input_wrapper">
                    <input class="twinkle_smtp_mailer_radio" type="radio" name="twinkle_smtp_mailer_radio" id="twinkle_smtp_postmark_radio" value="1" data-mailer="postmark" <?php echo 'postmark' == $mailer_form_name? 'checked' : ''  ?>>
                    <span class="label-text">Postmark</span>
                </div>
            </label>
            <label class="twinkle_smtp_mailer_design_single">
                <div class="twinkle_smtp_mailer_design_img twinkle_smtp_mailer_image_border">
                    <img src="<?php echo TWINKLE_SMTP_IMG_DIR . 'sparkpost.png'; ?>">
                </div>
                <div class="twinkle_smtp_mailer_radio_input_wrapper">
                    <input class="twinkle_smtp_mailer_radio" type="radio" name="twinkle_smtp_mailer_radio" id="twinkle_smtp_sparkpost_radio" value="1" data-mailer="sparkpost" <?php echo 'sparkpost' == $mailer_form_name? 'checked' : ''  ?>>
                    <span class="label-text">Sparkpost</span>
                </div>
            </label>
            <label class="twinkle_smtp_mailer_design_single">
                <div class="twinkle_smtp_mailer_design_img twinkle_smtp_mailer_image_border">
                    <img src="<?php echo TWINKLE_SMTP_IMG_DIR . 'aws.png'; ?>">
                </div>
                <div class="twinkle_smtp_mailer_radio_input_wrapper">
                    <input class="twinkle_smtp_mailer_radio" type="radio" name="twinkle_smtp_mailer_radio" id="twinkle_smtp_aws_radio" value="1" data-mailer="aws" <?php echo 'aws' == $mailer_form_name? 'checked' : ''  ?>>
                    <span class="label-text">Amazon SES</span>
                </div>
            </label>
            <label class="twinkle_smtp_mailer_design_single">
                <div class="twinkle_smtp_mailer_design_img twinkle_smtp_mailer_image_border">
                    <img src="<?php echo TWINKLE_SMTP_IMG_DIR . 'mailgun.png'; ?>">
                </div>
                <div class="twinkle_smtp_mailer_radio_input_wrapper">
                    <input class="twinkle_smtp_mailer_radio" type="radio" name="twinkle_smtp_mailer_radio" id="twinkle_smtp_mailgun_radio" value="1" data-mailer="mailgun" <?php echo 'mailgun' == $mailer_form_name? 'checked' : ''  ?>>
                    <span class="label-text">Mailgun</span>
                </div>
            </label>
        </div>
        <div id="twinkle_smtp_mailer_content_wrapper">
            <?php include TWINKLE_SMTP_PATH . "backend/templates/views/settings/sender/default.php"; ?>
            <?php include TWINKLE_SMTP_PATH . "backend/templates/views/settings/sender/sendgrid.php"; ?>
            <?php include TWINKLE_SMTP_PATH . "backend/templates/views/settings/sender/sendinblue.php"; ?>
            <?php include TWINKLE_SMTP_PATH . "backend/templates/views/settings/sender/postmark.php"; ?>
            <?php include TWINKLE_SMTP_PATH . "backend/templates/views/settings/sender/sparkpost.php"; ?>
            <?php include TWINKLE_SMTP_PATH . "backend/templates/views/settings/sender/aws.php"; ?>
            <?php include TWINKLE_SMTP_PATH . "backend/templates/views/settings/sender/mailgun.php"; ?>
        </div>
    </div>
</div>