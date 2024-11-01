
jQuery(document).ready(function ($) {
    'use strict';

    $(".twinkle_smtp_email_logs_wrapper .select_control #smtp_variable_select").prop('disabled', true);
    $(".twinkle_smtp_email_logs_wrapper .select_control #smtp_variable_select").css("cursor", "not-allowed");
    $('.table-head #reportrange').hide();
    $(".twinkle_smtp_email_logs_wrapper .select_control .btn_filter").addClass("btn-filter-disebled");

    // For filter by on change
    $('.twinkle_smtp_email_logs_wrapper .select_control #filter_by').on('change', function (e) {
        var selectedVal = this.value;

        $(".twinkle_smtp_email_logs_wrapper .select_control #smtp_variable_select").prop('disabled', false);
        $(".twinkle_smtp_email_logs_wrapper .select_control #smtp_variable_select").css("cursor", "pointer");
        $("#smtp_variable_select").focus();

        var statusOptions = '<option value="">Select</option>';
        statusOptions += '<option value="success">Success</option>';
        statusOptions += '<option value="failed">Failed</option>';

        if ('status_filter' === selectedVal) {
            $("#smtp_variable_select").html(statusOptions);
            $('.table-head #reportrange').hide();
            $('#smtp_variable_select').show();
            $(".twinkle_smtp_email_logs_wrapper .select_control .btn_filter").addClass("btn-filter-disebled");
            $(".twinkle_smtp_email_logs_wrapper .select_control .btn_filter").prop('disabled', true);
        } else if ('date_filter' === selectedVal) {
            $('#smtp_variable_select').hide();
            $('.table-head #reportrange').show();
            $(".twinkle_smtp_email_logs_wrapper .select_control .btn_filter").addClass("btn-filter-disebled");
            $(".twinkle_smtp_email_logs_wrapper .select_control .btn_filter").prop('disabled', true);
        } else {
            $(".twinkle_smtp_email_logs_wrapper .select_control #smtp_variable_select").css("cursor", "not-allowed");
            $(".twinkle_smtp_email_logs_wrapper .select_control #smtp_variable_select").prop('disabled', true);
            $(".twinkle_smtp_email_logs_wrapper .select_control #smtp_variable_select").show();
            $(".twinkle_smtp_email_logs_wrapper #reportrange").hide();
            $(".twinkle_smtp_email_logs_wrapper .select_control .btn_filter").addClass("btn-filter-disebled");
            $(".twinkle_smtp_email_logs_wrapper .select_control .btn_filter").prop('disabled', true);
        }
    });

    // For status
    $('.twinkle_smtp_email_logs_wrapper .select_control #smtp_variable_select').on('change', function (e) {
        $(".twinkle_smtp_email_logs_wrapper .select_control .btn_filter").removeClass("btn-filter-disebled");
        $(".twinkle_smtp_email_logs_wrapper .select_control .btn_filter").prop('disabled', false);
    });

    //For date range
    $('.twinkle_smtp_email_logs_wrapper #reportrange').on('click', function (e) {
        $(".twinkle_smtp_email_logs_wrapper .select_control .btn_filter").removeClass("btn-filter-disebled");
        $(".twinkle_smtp_email_logs_wrapper .select_control .btn_filter").prop('disabled', false);
    });

    // Bulk Checkbox
    $('.twinkle_smtp_email_logs_wrapper .twinkle_smtp_check_all_logs').on('change', function (e) {
        if (this.checked) {
            var totalChecked = 0;

            $(".twinkle_smtp_check_all_logs").prop('checked', true);
            $(".twinkle_smtp_check_single").each(function () {
                if (!this.checked) {
                    $('.twinkle_smtp_check_single').prop('checked', true);
                }
                totalChecked++;
            });

            $(".twinkle_smtp_check_single").on('change', function (e) {
                var singleTotal = 0;

                $(".twinkle_smtp_check_single").each(function () {
                    if (this.checked) {
                        singleTotal++;
                    }
                });

                if (totalChecked == singleTotal) {
                    $(".twinkle_smtp_check_all_logs").prop('checked', true);
                } else {
                    $(".twinkle_smtp_check_all_logs").prop('checked', false);
                }
            });

            check_items_control();

        } else {
            $(".twinkle_smtp_check_all_logs").prop('checked', false);
            $(".twinkle_smtp_check_single").each(function () {
                if (this.checked) {
                    $('.twinkle_smtp_check_single').prop('checked', false);
                }
            });
            check_items_control();
        }
    });

    // Delete Bulck Email Logs..
    $('.twinkle_smtp_email_logs_wrapper .delete_email_logs').on('click', function (e) {
        var delete_ids = [];
        $.each($("input[name='twinkle_smtp_check_single[]']:checked"), function () {
            delete_ids.push($(this).val());
        });
        delete_twinkle_smtp_logs(delete_ids);
    });

    $(function () {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);


        cb(start, end);

    });

});

function twinkle_smtp_email_log_init() {
    'use strict';
    twinkle_smtp_hide_all_views();
    jQuery("#twinkle_smtp_email_logs").show();

    var foundActive = $('.twinkle_smtp_header_nav ul li').find('twinkle_smtp_menue_active');
    if (foundActive) {
        $('.twinkle_smtp_header_nav ul li').removeClass("twinkle_smtp_menue_active");
        $('.email_log').addClass("twinkle_smtp_menue_active");
    } else {
        $('.email_log').addClass("twinkle_smtp_menue_active");
    }

    email_logs_datatable_init();
}


function check_items() {
    let delete_twinkle_smtp_select = jQuery('#delete_twinkle_smtp_select').val();
    var singleChecklen = jQuery("input[name='twinkle_smtp_check_single[]']:checked").length;

    if (singleChecklen > 0 && delete_twinkle_smtp_select !== '') {
        return true;
    } else {
        return false;
    }
}

function check_items_control() {
    let $check_items = check_items();
    if ($check_items) {
        jQuery(".twinkle_smtp_email_logs_wrapper .select_control .btn-delete-twinkle-smtp").removeClass("btn-filter-disebled");
        jQuery(".twinkle_smtp_email_logs_wrapper .select_control .btn-delete-twinkle-smtp").prop('disabled', false);
    } else {
        jQuery(".twinkle_smtp_email_logs_wrapper .select_control .btn-delete-twinkle-smtp").addClass("btn-filter-disebled");
        jQuery(".twinkle_smtp_email_logs_wrapper .select_control .btn-delete-twinkle-smtp").prop('disabled', true);
    }
}

function email_logs_datatable_init() {
    // get inputs value
    if (jQuery.fn.DataTable.isDataTable('#email_logs_datatable')) {
        jQuery('#email_logs_datatable').DataTable().destroy();
    }

    var $data = {};

    $data.filter_type = jQuery('#filter_by').val();
    $data.filter_by = jQuery('#smtp_variable_select').val();
    if ($data.filter_type === 'date_filter') {
        $data.filter_by = '';
        $data.start_date = jQuery('#reportrange').data('daterangepicker').startDate.format('MM/DD/YYYY');
        $data.end_date = jQuery('#reportrange').data('daterangepicker').endDate.format('MM/DD/YYYY');
    }


    let post_data = { 'action': 'twinkle_smtp_email_logs_datatable', 'data': $data };

    var table = jQuery('#email_logs_datatable').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 20,
        searching: true,
        autoWidth: false,
        paging: true,
        ajax: {
            url: ajaxurl,
            type: "POST",
            data: post_data,
        },
        order: [0, 'desc'],
        dom: 'Bfrtip',
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ]
    });
}

function delete_twinkle_smtp_logs(delete_ids = [], others_data = '') {

    jQuery('.twinkleSmtp_popup').addClass('twinkleSmtp_popup_open');

    jQuery('.twinkleSmtp-btn-trigger-success').on('click', function () {

        if (jQuery.fn.DataTable.isDataTable('#email_logs_datatable')) {
            jQuery('#email_logs_datatable').DataTable().destroy();
        }

        let data = {
            'delete_ids': delete_ids,
        };

        let post_data = { 'action': 'twinkle_smtp_delete_email_logs', 'data': JSON.stringify(data) };

        var table = jQuery('#email_logs_datatable').DataTable({
            processing: true,
            serverSide: false,
            pageLength: 20,
            searching: true,
            paging: true,
            ajax: {
                url: ajaxurl,
                type: "POST",
                data: post_data,
            },
            order: [0, 'desc'],
            dom: 'Bfrtip',
            "columnDefs": [
                { "orderable": false, "targets": 0 }
            ]
        });

        $(".twinkle_smtp_check_all_logs").prop('checked', false);

        $('#delete_twinkle_smtp_select').prop('selectedIndex', 0);
        check_items_control();
        twinkle_smtp_close_popup();
    });

}

function twinkle_smtp_get_email_log_by_id($logid = '') {

      var popup = jQuery('#twinkle_smtp_log_view');
      var blur  = jQuery('#twinkle_smtp_main');

      blur.toggleClass('active');
      popup.toggleClass('active');

    if (!$logid) {
        return;
    }

    let $data = {
        'logid': $logid,
    };

    let $post_data = { 'action': 'twinkle_smtp_get_email_log', 'data': $data };

    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        data: $post_data,
        success: function (response) {
            var obj = JSON.parse(response);

            if (obj.status == "true") {
                var modal_data = obj.data;
                jQuery('#twinkle_smtp_single_log_status .content').text(modal_data.status);
                jQuery('#twinkle_smtp_single_log_date .content').text(modal_data.date_time);
                jQuery('#twinkle_smtp_single_log_form .content').text(modal_data.form);
                jQuery('#twinkle_smtp_single_log_to .content').text(modal_data.to);
                jQuery('#twinkle_smtp_single_log_subject .content').text(modal_data.subject);
                jQuery('#twinkle_smtp_single_log_message .html-content').html(modal_data.message);

                var headers =  modal_data.headers;
                var header_text = '{ <div class="header-item">';

                if (headers.length > 0) {
                    headers.map(function (item, index) {
                        header_text += '<p>' + item + '</p>';
                    });
                }

                var response_text = '';
                if( 'Ok' === modal_data.error_message){
                    response_text = '{ <div class="response-item"><p> Ok </p> </div> }';
                }else{
                    response_text = '{<div class="response-item">' + '<p> Exception code: '+  modal_data.exception_code +'</p>'+ '<p> Errors: '+  modal_data.error_message +'</p>' + '</div>}';
                }

                 jQuery('#twinkle_smtp_single_log_headers .content').html(header_text + '</div> }');

                 jQuery('#twinkle_smtp_single_log_response .content').html(response_text);

            }
        }
    });

}


function failed_email_retry( $this,  $logid = '' ) {

    if (!$logid) {
        return;
    }

    let $data = {
        'logid': $logid,
    };

    if (jQuery.fn.DataTable.isDataTable('#email_logs_datatable')) {
        jQuery('#email_logs_datatable').DataTable().destroy();
    }


    let post_data = { 'action': 'twinkle_smtp_mail_retry', 'data': $data };

    var table = jQuery('#email_logs_datatable').DataTable({
        processing: true,
        serverSide: false,
        pageLength: 20,
        searching: true,
        paging: true,
        ajax: {
            url: ajaxurl,
            type: "POST",
            data: post_data,
        },
        "initComplete":function( settings, response ){
            var $status = response.status;
            if( $status == 'success' ){
                Command: toastr["success"]("Mail Sent Successfully.");
            }else{
                Command: toastr["error"]("Mail Sending Failed!");
            }
        },
        order: [0, 'desc'],
        dom: 'Bfrtip',
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ]
    });

}

function twinkle_smtp_close_popup() {
    jQuery('.twinkleSmtp_popup').removeClass('twinkleSmtp_popup_open');
}
