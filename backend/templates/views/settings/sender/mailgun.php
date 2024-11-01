<?php
    $mailgun_from_email  = $this->db->update_mailer_data("mailgun_from_email", Null);
    $mailgun_from_name   = $this->db->update_mailer_data("mailgun_from_name", Null);
    $mailgun_api_key     = $this->db->update_mailer_data("mailgun_api_key", Null);
    $mailgun_domain_name = $this->db->update_mailer_data("mailgun_domain_name", Null);
    $mailgun_region      = $this->db->update_mailer_data("mailgun_region", Null);

?>

<div id="twinkle_smtp_mailer_mailgun_content" class="twinkle_smtp_integration_form" style="display: none;">
    <div class="twinkle_smtp_mailer_name">
        <h1>Mailgun</h1>
        <a  target="_blank" href="#">Read Documentation</a>
    </div>

    <div id="twinkle_smtp_mailer_form">
        <form action="" method="post" id="twinkle_smtp_mailgun_form">
            <div class="twinkle_smtp_mailer_sender_settings">
                <div class="twinkle_smtp_mailer_settings_name">
                    <h2>Sender Settings</h2>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_mailgun_from_email"> From Email</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_mailgun_reset" type="email" name="twinkle_smtp_mailgun_from_email" id="twinkle_smtp_mailgun_from_email" placeholder="From Email" value="<?php  echo ( $mailgun_from_email) ?  $mailgun_from_email : ''; ?>" required>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_mailgun_from_name"> From Name</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_mailgun_reset" type="text" id="twinkle_smtp_mailgun_from_name" placeholder="From Name" name="twinkle_smtp_mailgun_from_name" value="<?php  echo ( $mailgun_from_name) ?  $mailgun_from_name : ''; ?>" required>
                </div>
            </div>

            <div class="twinkle_smtp_mailer_smtp_settings">
                <div class="twinkle_smtp_mailer_settings_name">
                    <h2>Mailgun API Settings</h2>
                </div>
    
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_mailgun_api_key">API Key</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_mailgun_reset" type="password" name="twinkle_smtp_mailgun_api_key" id="twinkle_smtp_mailgun_api_key" placeholder="" value="<?php  echo (  $mailgun_api_key ) ?   $mailgun_api_key : ''; ?>" required>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_mailgun_domain_name">Domain Name</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_mailgun_reset" type="text" name="twinkle_smtp_mailgun_domain_name" id="twinkle_smtp_mailgun_domain_name" placeholder="" value="<?php  echo (  $mailgun_domain_name ) ?   $mailgun_domain_name : ''; ?>" required>
                </div>

                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_mailgun_region"> Select Region  </label>
                    <div class="twinkle_smtp_radio_wrapper">
                        <div class="twinkle_smtp_single_radio">
                            <input type="radio" class="twinkle_smtp_mailgun_region" name="twinkle_smtp_mailgun_region" value="us" <?php echo 'us' == $mailgun_region ? 'checked' : 'checked' ?>>
                            <span>US</span>
                        </div>
                        <div class="twinkle_smtp_single_radio">
                            <input type="radio" class="twinkle_smtp_mailgun_region" name="twinkle_smtp_mailgun_region" value="eu" <?php echo 'eu' == $mailgun_region ? 'checked' : '' ?>>
                            <span>EU</span>
                        </div>
                    </div>
                </div>

                <div class="twinkle_smtp_form_group">
                    <button class="twinkle_smtp_form_submit" type="submit"  id="twinkle_smtp_mailgun_mailer_submit">  <span>Save Settings</span> <div class="twinkle-smtp-btn-spinner twinkle-smtp-loader-hide"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div> </button>
                </div>
            </div>
        </form>
    </div>
</div>