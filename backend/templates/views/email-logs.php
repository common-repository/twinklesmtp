<div id="twinkle_smtp_email_logs">
    <div class="twinkle_smtp_email_logs_wrapper">
        <div class="table-head">
            <div class="select_control">
                <select name="filter_by" class="twinkle_smtp_filter_by" id="filter_by">
                    <option value="">Filter By</option>
                    <option value="status_filter">Status</option>
                    <option value="date_filter">Date</option>
                </select>
            </div>
            <div class="select_control" class="twinkle_smtp_select_container" id="smtp_select_container">
                <select name="select_val" id="smtp_variable_select" class="smtp_variable_select">
                    <option value="">Select</option>
                </select>
            </div>

            <div class="select_control" id="reportrange">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </div>

            <div class="select_control">
                <button onclick="email_logs_datatable_init();" type="button" class="btn_filter btn-filter-disebled" disabled="true">Filter</button>
            </div>

            <div class="select_control">
                <select onchange="check_items_control()" name="delete_logs" id="delete_twinkle_smtp_select">
                    <option value="">Select</option>
                    <option value="delete_all">Delete Selected</option>
                </select>
            </div>

            <div class="select_control">
                <button type="button" class="delete_email_logs btn-delete-twinkle-smtp btn-filter-disebled" disabled="true">Apply</button>
            </div>

        </div>
        <div class="table-content">
            <table id="email_logs_datatable" class="widefat fixed striped table-view-list posts nowrap" style="width:100%;border-radius: 8px;">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="twinkle_smtp_check_all_logs" name="twinkle_smtp_check_all_logs" value="1"></th>
                        <th>To</th>
                        <th>From </th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date & Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th><input type="checkbox" class="twinkle_smtp_check_all_logs" name="twinkle_smtp_check_all_logs" value="1"></th>
                        <th>To</th>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date & Time</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- twinkleSmtp_popup_open -->
<div class="twinkleSmtp_popup d_flex">
    <div class="twinkleSmtp_popup_inar">
        <div class="successes_message">
            <p class="twinkleSmtp-popup-content"> Do you want to delete?? </p>
            <div class="twinkleSmtp-btn-wrapper">
                <button type="button" class="twinkleSmtp-btn-danger twinkleSmtp-btn-trigger-danger" onclick="twinkle_smtp_close_popup();">No</button>
                <button type="button" class="twinkleSmtp-btn-success twinkleSmtp-btn-trigger-success">Yes</button>
            </div>
            <span class="dashicons dashicons-dismiss twinkleSmtp_close_popup" onclick="twinkle_smtp_close_popup();"></span>
        </div>
    </div>
</div>
