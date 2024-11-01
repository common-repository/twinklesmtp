<div id="twinkle_smtp_mailer_default_content" class="twinkle_smtp_integration_form" style="display: none;">
    <div class="twinkle_smtp_mailer_name">
        <h1>Default</h1>
        <a  target="_blank" href="#">Read Documentation</a>
    </div>

    <?php
    $default_from_email       = $this->db->update_mailer_data("default_from_email", Null);
    $default_from_name        = $this->db->update_mailer_data("default_from_name", Null);
    $default_bcc_email        = $this->db->update_mailer_data("default_bcc_email", Null);
    $default_smtp_host        = $this->db->update_mailer_data("default_smtp_host", Null);
    $default_smtp_port        = $this->db->update_mailer_data("default_smtp_port", Null);
    $default_auth_type        = $this->db->update_mailer_data("default_auth_type", Null);
    $default_smtp_username    = $this->db->update_mailer_data("default_smtp_username", Null);
    $default_typof_encryption = $this->db->update_mailer_data("default_type_of_encryption", Null);
    $default_smtp_password    = $this->db->update_mailer_data("default_smtp_password", Null);

    ?>

    <div id="twinkle_smtp_mailer_form">
        <form action="" method="post" id="twinkle_smtp_default_mailer_form">
            <div class="twinkle_smtp_mailer_sender_settings">
                <div class="twinkle_smtp_mailer_settings_name">
                    <h2>Sender Settings</h2>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_default_mailer_from_email"> From Email</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_default_reset" type="email" name="twinkle_smtp_default_mailer_from_email" id="twinkle_smtp_default_mailer_from_email" placeholder="From Email" value="<?php echo ($default_from_email) ? $default_from_email : ''; ?>" required>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_default_mailer_from_name"> From Name</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_default_reset" type="text" id="twinkle_smtp_default_mailer_from_name" placeholder="From Name" name="twinkle_smtp_default_mailer_from_name" value="<?php echo $default_from_name ? $default_from_name  : ''; ?>" required>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_default_mailer_bcc_email_address"> BCC Email Address</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_default_reset" type="email" name="twinkle_smtp_default_mailer_bcc_email_address" id="twinkle_smtp_default_mailer_bcc_email_address" placeholder="BCC Email Address" value="<?php echo  $default_bcc_email ?  $default_bcc_email  : ''; ?>">
                </div>
            </div>

            <div class="twinkle_smtp_mailer_smtp_settings">
                <div class="twinkle_smtp_mailer_settings_name">
                    <h2>SMTP Settings</h2>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_default_mailer_smtp_host"> SMTP Host</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_default_reset" type="text" name="twinkle_smtp_default_mailer_smtp_host" id="twinkle_smtp_default_mailer_smtp_host" placeholder="" value="<?php echo   $default_smtp_host ?   $default_smtp_host  : ''; ?>" required>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_default_mailer_smtp_port"> SMTP Port</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_default_reset" type="text" name="twinkle_smtp_default_mailer_smtp_port" id="twinkle_smtp_default_mailer_smtp_port" placeholder="" value="<?php echo  $default_smtp_port ?  $default_smtp_port  : ''; ?>" required>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_default_mailer_encryption"> Type of Encryption (Select ssl on port 465, or tls on port 25 or 587) </label>
                    <div class="twinkle_smtp_radio_wrapper">
                        <div class="twinkle_smtp_single_radio">
                            <input type="radio" class="twinkle_smtp_encryption_type" name="twinkle_smtp_encryption_type" value="none" <?php echo  'none' == $default_typof_encryption ? 'checked' : ''; ?>>
                            <span>None</span>
                        </div>
                        <div class="twinkle_smtp_single_radio">
                            <input type="radio" class="twinkle_smtp_encryption_type  encryption_type_ssl" name="twinkle_smtp_encryption_type" value="ssl" <?php echo  'ssl' == $default_typof_encryption ? 'checked' : 'checked'; ?>>
                            <span>SSL</span>
                        </div>
                        <div class="twinkle_smtp_single_radio">
                            <input type="radio" class="twinkle_smtp_encryption_type" name="twinkle_smtp_encryption_type" value="tls" <?php echo  'tls' == $default_typof_encryption ? 'checked' : ''; ?>>
                            <span>TLS</span>
                        </div>
                    </div>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_default_mailer_authentication_type"> SMTP Authentication </label>
                    <div class="twinkle_smtp_radio_wrapper">
                        <div class="twinkle_smtp_single_radio">
                            <input type="radio" class="twinkle_smtp_default_mailer_authentication_type default_auth_yes" name="twinkle_smtp_default_mailer_authentication_type" value="true" <?php echo 'true' == $default_auth_type ? 'checked' : 'checked' ?>>
                            <span>Yes</span>
                        </div>
                        <div class="twinkle_smtp_single_radio">
                            <input type="radio" class="twinkle_smtp_default_mailer_authentication_type" name="twinkle_smtp_default_mailer_authentication_type" value="false" <?php echo 'false' == $default_auth_type ? 'checked' : '' ?>>
                            <span>No</span>
                        </div>
                    </div>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_default_mailer_smtp_username">SMTP Username</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_default_reset" type="text" name="twinkle_smtp_default_mailer_smtp_username" id="twinkle_smtp_default_mailer_smtp_username" placeholder="" value="<?php echo  $default_smtp_username ?  $default_smtp_username : ''; ?>" required>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_default_mailer_smtp_password">SMTP Password</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_default_reset" type="password" name="twinkle_smtp_default_mailer_smtp_password" id="twinkle_smtp_default_mailer_smtp_password" placeholder="" value="<?php echo $default_smtp_password ? base64_decode($default_smtp_password) : ''; ?>" required>
                </div>

                <div class="twinkle_smtp_form_group">
                    <button class="twinkle_smtp_form_submit" type="submit"  id="twinkle_smtp_default_mailer_submit">  <span>Save Settings</span> <div class="twinkle-smtp-btn-spinner twinkle-smtp-loader-hide"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div> </button>
                </div>

            </div>
        </form>
    </div>
</div>