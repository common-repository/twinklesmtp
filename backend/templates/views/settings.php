<div id="twinkle_smtp_settings">
    <div id="twinkle_smtp_settings-sidebar">
        <div class="sidebar-wrapper">
            <h4>Settings</h4>
            <ul>
                <li class="twinkle_smtp_settings_active" onclick="twinkle_smtp_sender_settings_init()">Sender Settings</li>
                <li onclick="twinkle_smtp_general_settings_init()">General Settings</li>
            </ul>
        </div>

    </div>
    <div id="twinkle_smtp_settings-content" class="twinkle_smtp_ml_30 twinkle_smtp_col_8">
        <?php include TWINKLE_SMTP_PATH . "backend/templates/views/settings/sender-settings.php"; ?>
        <?php include TWINKLE_SMTP_PATH . "backend/templates/views/settings/general-settings.php"; ?>

    </div>
</div>

