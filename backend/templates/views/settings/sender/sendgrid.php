
<?php
    $sendgrid_from_email  = $this->db->update_mailer_data("sendgrid_from_email", Null);
    $sendgrid_from_name   = $this->db->update_mailer_data("sendgrid_from_name", Null);
    $sendgrid_api_key     = $this->db->update_mailer_data("sendgrid_api_key", Null);
   
?>

<div id="twinkle_smtp_mailer_sendgrid_content" class="twinkle_smtp_integration_form" style="display: none;">
    <div class="twinkle_smtp_mailer_name">
        <h1>SendGrid</h1>
        <a  target="_blank" href="#">Read Documentation</a>
    </div>

    <div id="twinkle_smtp_mailer_form">
        <form action="" method="post" id="twinkle_smtp_sendgrid_form">
            <div class="twinkle_smtp_mailer_sender_settings">
                <div class="twinkle_smtp_mailer_settings_name">
                    <h2>Sender Settings</h2>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_sendgrid_from_email"> From Email</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_sendgrid_reset" type="email" name="twinkle_smtp_sendgrid_from_email" id="twinkle_smtp_sendgrid_from_email" placeholder="From Email" value="<?php  echo ($sendgrid_from_email) ? $sendgrid_from_email : ''; ?>" required>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_sendgrid_from_name"> From Name</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_sendgrid_reset" type="text" id="twinkle_smtp_sendgrid_from_name" placeholder="From Name" name="twinkle_smtp_sendgrid_from_name" value="<?php echo ( $sendgrid_from_name ) ?  $sendgrid_from_name : ''; ?>" required>
                </div>
            </div>

            <div class="twinkle_smtp_mailer_smtp_settings">
                <div class="twinkle_smtp_mailer_settings_name">
                    <h2>SendGrid API Settings</h2>
                </div>
    
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_sendgrid_api_key">API Key</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_sendgrid_reset" type="password" name="twinkle_smtp_sendgrid_api_key" id="twinkle_smtp_sendgrid_api_key" placeholder="" value="<?php echo ( $sendgrid_api_key ) ?  $sendgrid_api_key  : ''; ?>" required>
                </div>

                <div class="twinkle_smtp_form_group">
                    <button class="twinkle_smtp_form_submit" type="submit"  id="twinkle_smtp_sendgrid_mailer_submit">  <span>Save Settings</span> <div class="twinkle-smtp-btn-spinner twinkle-smtp-loader-hide"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div> </button>
                </div>
            </div>
        </form>
    </div>
</div>