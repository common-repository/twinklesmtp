<?php
$aws_from_email = $this->db->update_mailer_data("aws_from_email", Null);
$aws_from_name  = $this->db->update_mailer_data("aws_from_name", Null);
$aws_access_key = $this->db->update_mailer_data("aws_access_key", Null);
$aws_secret_key = $this->db->update_mailer_data("aws_secret_key", Null);
$aws_region     = $this->db->update_mailer_data("aws_region", Null);

?>

<div id="twinkle_smtp_mailer_aws_content" class="twinkle_smtp_integration_form" style="display: none;">
    <div class="twinkle_smtp_mailer_name">
        <h1> Amazon SES</h1>
        <a target="_blank" href="#">Read Documentation</a>
    </div>

    <div id="twinkle_smtp_mailer_form">
        <form action="" method="post" id="twinkle_smtp_aws_form">
            <div class="twinkle_smtp_mailer_sender_settings">
                <div class="twinkle_smtp_mailer_settings_name">
                    <h2>Sender Settings</h2>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_aws_from_email"> From Email</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_aws_reset" type="email" name="twinkle_smtp_aws_from_email" id="twinkle_smtp_aws_from_email" placeholder="From Email" value="<?php echo ($aws_from_email) ? $aws_from_email : ''; ?>" required>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_aws_from_name"> From Name</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_aws_reset" type="text" id="twinkle_smtp_aws_from_name" placeholder="From Name" name="twinkle_smtp_aws_from_name" value="<?php echo ($aws_from_name) ?  $aws_from_name : ''; ?>" required>
                </div>
            </div>

            <div class="twinkle_smtp_mailer_smtp_settings">
                <div class="twinkle_smtp_mailer_settings_name">
                    <h2> Amazon SES API Settings</h2>
                </div>

                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_aws_access_key">Access Key</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_aws_reset" type="password" name="twinkle_smtp_aws_access_key" id="twinkle_smtp_aws_access_key" placeholder="" value="<?php echo ($aws_access_key) ? $aws_access_key : ''; ?>" required>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_aws_secret_key">Secret Key</label>
                    <input class="twinkle_smtp_form_control twinkle_smtp_aws_reset" type="password" name="twinkle_smtp_aws_secret_key" id="twinkle_smtp_aws_secret_key" placeholder="" value="<?php echo ($aws_secret_key) ?   $aws_secret_key : ''; ?>" required>
                </div>
                <div class="twinkle_smtp_form_group">
                    <label for="twinkle_smtp_aws_secret_key">Region</label>
                    <select id='twinkle_smtp_aws_region' name="twinkle_smtp_aws_region" class="twinkle_smtp_aws_reset">
                       <option value=''>-- Select Region --</option>
                        <option value='us-east-1'  <?php  echo 'us-east-1' == $aws_region? 'selected' : '' ?> > US East (N. Virginia)</option>
                        <option value='us-east-2' <?php  echo 'us-east-2' == $aws_region? 'selected' : '' ?>> US East (Ohio)</option>
                        <option value='us-west-1' <?php  echo 'us-west-1' == $aws_region? 'selected' : '' ?>> US West (N. California)</option>
                        <option value='us-west-2' <?php  echo 'us-west-2' == $aws_region? 'selected' : '' ?>> US West (Oregon)</option>
                        <option value='af-south-1' <?php  echo 'af-south-1' == $aws_region? 'selected' : '' ?>> Africa (Cape Town)</option>
                        <option value='ap-east-1' <?php  echo 'ap-east-1' == $aws_region? 'selected' : '' ?>> Asia Pacific (Hong Kong)</option>
                        <option value='ap-southeast-3' <?php  echo 'ap-southeast-3' == $aws_region? 'selected' : '' ?>> Asia Pacific (Jakarta)</option>
                        <option value='ap-south-1' <?php  echo 'ap-south-1' == $aws_region? 'selected' : '' ?>> Asia Pacific (Mumbai)</option>
                        <option value='ap-northeast-3' <?php  echo 'ap-northeast-3' == $aws_region? 'selected' : '' ?>> Asia Pacific (Osaka)</option>
                        <option value='ap-northeast-2' <?php  echo 'ap-northeast-2' == $aws_region? 'selected' : '' ?>>Asia Pacific (Seoul) </option>
                        <option value='ap-southeast-1' <?php  echo 'ap-southeast-1' == $aws_region? 'selected' : '' ?>> Asia Pacific (Singapore) </option>
                        <option value='ap-southeast-2' <?php  echo 'ap-southeast-2' == $aws_region? 'selected' : '' ?>> Asia Pacific (Sydney) </option>
                        <option value='ap-northeast-1' <?php  echo 'ap-northeast-1' == $aws_region? 'selected' : '' ?>>Asia Pacific (Tokyo) </option>
                        <option value='ca-central-1' <?php  echo 'ca-central-1' == $aws_region? 'selected' : '' ?>> Canada (Central) </option>
                        <option value='eu-central-1' <?php  echo 'eu-central-1' == $aws_region? 'selected' : '' ?>>Europe (Frankfurt) </option>
                        <option value='eu-west-1' <?php  echo 'eu-west-1' == $aws_region? 'selected' : '' ?>> Europe (Ireland) </option>
                        <option value='eu-west-2' <?php  echo 'eu-west-2' == $aws_region? 'selected' : '' ?>> Europe (London) </option>
                        <option value='eu-south-1' <?php  echo 'eu-south-1' == $aws_region? 'selected' : '' ?>> Europe (Milan) </option>
                        <option value='eu-west-3' <?php  echo 'eu-west-3' == $aws_region? 'selected' : '' ?>> Europe (Paris) </option>
                        <option value='eu-north-1' <?php  echo 'eu-north-1' == $aws_region? 'selected' : '' ?>> Europe (Stockholm) </option>          
                        <option value='me-south-1' <?php  echo 'me-south-1' == $aws_region? 'selected' : '' ?>> Middle East (Bahrain) </option>
                        <option value='sa-east-1' <?php  echo 'sa-east-1' == $aws_region? 'selected' : '' ?>> South America (São Paulo) </option>
                    </select>
                </div>

                <div class="twinkle_smtp_form_group twinkle_smtp_form_group_extra_margin">
                    <button class="twinkle_smtp_form_submit" type="submit" id="twinkle_smtp_aws_mailer_submit"> <span>Save Settings</span>
                        <div class="twinkle-smtp-btn-spinner twinkle-smtp-loader-hide">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>







   
