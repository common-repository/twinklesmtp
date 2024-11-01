<?php 
    $enable_delete_log   = $this->db->update_mailer_data("enable_delete_log", Null);
    $delete_log_duration = $this->db->update_mailer_data("delete_log_duration", Null);
    $report_duration     = $this->db->update_mailer_data("activity_report_duration", Null);
?>


<div id="twinkle_smtp_general_settings">
    <div class="twinkle_smtp_mail_settings_tab_body">
        <div id="twinkle_smtp_mailer_form">

            <div class="twinkle_smtp_general_settings_content">
                <div class="twinkle_smtp_mailer_settings_name">
                    <h2>General Settings</h2>
                </div>

                <form action="" method="post" id="twinkle_smtp_general_settings_form">

                    <div class="twinkle_smtp_general_settings_form_group">
                        <div class="twinkle_smtp_switcher_wrapper">
                            <span class="settings-label label-mr">Enable/Disable Delete Log:</span>
                            <label class="twinkle_smtp_switcher">
                                <input type="checkbox" name="twinkle_smtp_enable_delete_log" id="twinkle_smtp_enable_delete_log" <?php echo 'yes' === $enable_delete_log? 'checked' : ''; ?> >
                                <div class="slider"></div>
                            </label>
                        </div>
                    </div>

                    <div id="twinkle_smtp_general_settings_form_group_display" class="twinkle_smtp_general_settings_form_group  hide_delete_email_logs">
                        <label class="settings-label" for="twinkle_smtp_delete_email_logs"> Delete Email Logs:</label>

                        <select id='twinkle_smtp_delete_email_logs'>
                            <option value=''>-- Select Duration --</option>
                            <option value='7' <?php  echo '7' == $delete_log_duration? 'selected' : '' ?> > After 7 Days</option>
                            <option value='14' <?php  echo '14' == $delete_log_duration? 'selected' : '' ?>>After 14 Days</option>
                            <option value='30' <?php  echo '30' == $delete_log_duration? 'selected' : '' ?> > After 30 Days</option>
                            <option value='60' <?php  echo '60' == $delete_log_duration? 'selected' : '' ?>> After 60 Days</option>
                            <option value='90' <?php  echo '90' == $delete_log_duration? 'selected' : '' ?>> After 90 Days</option>
                            <option value='180' <?php  echo '180' == $delete_log_duration? 'selected' : '' ?>> After 6 Months</option>
                            <option value='365' <?php  echo '365' == $delete_log_duration? 'selected' : '' ?>> After 1 Year</option>
                            <option value='730' <?php  echo '730' == $delete_log_duration? 'selected' : '' ?>> After 2 Years</option>

                        </select>
                    </div>

                    <div class="twinkle_smtp_general_settings_form_group hide_delete_email_logs">
                        <label class="settings-label-analytics-report" for="twinkle_smtp_analytics_report"> Activity report:</label>

                        <select id='twinkle_smtp_analytics_report'>
                            <option value='7'  <?php  echo '7' == $report_duration? 'selected' : '' ?>> Last 7 Days</option>
                            <option value='14' <?php  echo '14' == $report_duration? 'selected' : '' ?>>Last 14 Days</option>
                            <option value='30' <?php  echo '30' == $report_duration? 'selected' : '' ?>> Last 30 Days</option>
                
                        </select>
                    </div>

                    <div class="twinkle_smtp_general_settings_form_group general_settings_btn_group">
                        <button class="twinkle_smtp_form_submit" type="submit" id="twinkle_smtp_general_settings_submit"><span>Save Settings</span>
                        <div class="twinkle-smtp-btn-spinner twinkle-smtp-loader-hide"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div> 
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>