
jQuery(document).ready(function ($) {
    'use strict';

    // Enable/Disable Delete Log
    $('#twinkle_smtp_enable_delete_log').click(function () {
        if ($(this).prop("checked") == true) {
            $("#twinkle_smtp_general_settings_form_group_display").removeClass("hide_delete_email_logs");
        }
        else if ($(this).prop("checked") == false) {
            $("#twinkle_smtp_general_settings_form_group_display").addClass("hide_delete_email_logs");
        }
    });

    $(function () {
       var enable_delete_log =  $('#twinkle_smtp_enable_delete_log').prop("checked");
       if(  enable_delete_log === true  ){
         $("#twinkle_smtp_general_settings_form_group_display").removeClass("hide_delete_email_logs");
       }
    });

    // General Settings ApI
    $( "#twinkle_smtp_general_settings_submit" ).on( "click", function(e) {
        e.preventDefault();
       
        $("#twinkle_smtp_general_settings_submit span").text("Please Wait...");
        $("#twinkle_smtp_general_settings_submit .twinkle-smtp-btn-spinner").removeClass("twinkle-smtp-loader-hide");
        $("#twinkle_smtp_general_settings_submit").prop('disabled', true);
        $("#twinkle_smtp_general_settings_submit").addClass('test_mail_submit_disabled');

        var delete_log_duration = '';
        var switcherVal = '';

        if ( $("#twinkle_smtp_enable_delete_log").prop("checked") == true ) {       
             delete_log_duration = $('#twinkle_smtp_delete_email_logs').val();
             switcherVal = 'yes';
        }else{
            switcherVal = 'no';
        }          
        
        let general_settings_data = {
            'enable_delete_log': switcherVal,
            'delete_log_duration': delete_log_duration,   
            'activity_report_duration': $('#twinkle_smtp_analytics_report').val(),   
        };
    
        let post_data = { 'action': 'twinkle_smtp_ general_settings', 'data': JSON.stringify(general_settings_data) };
    
        jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            data: post_data,
            success: function (data) {
    
                var obj = JSON.parse(data);

                if (obj.status == "true") {                 
                    Command: toastr["success"]("Settings Saved Successfully.");
                } else {
                    Command: toastr["error"]("Credential Verification Failed. Please check your inputs !");
                }
    
                $("#twinkle_smtp_general_settings_submit span").text("Save Settings");
                $("#twinkle_smtp_general_settings_submit .twinkle-smtp-btn-spinner").addClass("twinkle-smtp-loader-hide");
                $("#twinkle_smtp_general_settings_submit").prop('disabled', false);
                $("#twinkle_smtp_general_settings_submit").removeClass('test_mail_submit_disabled');

            }
        });


     });

     // start mailer manage option
     var $mailers = $('.twinkle_smtp_mailer_radio');
     $('.twinkle_smtp_integration_form').hide();

     if( $mailers.length > 0 ){

         $mailers.each(function($index, $item){
            if( $($item).is(':checked') ){
                let $mailer_name_checked = $($item).attr('data-mailer');
                $("#twinkle_smtp_mailer_"+ $mailer_name_checked +"_content").show();
            }

            $($item).on('click', function(){
                $('.twinkle_smtp_integration_form').hide();
                let $mailer_name = $($item).attr('data-mailer');
                $("#twinkle_smtp_mailer_"+ $mailer_name +"_content").show();
            });
            
         });

     }else{
        console.log( 'Opps : element not foun, please try again!');
     }
    
});


function twinkle_smtp_settings_init() {
    'use strict';
    twinkle_smtp_hide_all_views();
    jQuery("#twinkle_smtp_settings").show();

    var foundActive = $('.twinkle_smtp_header_nav ul li').find('twinkle_smtp_menue_active');
    if(foundActive){
        $('.twinkle_smtp_header_nav ul li').removeClass("twinkle_smtp_menue_active");
        $('.settings').addClass("twinkle_smtp_menue_active");
    }else{
        $('.settings').addClass("twinkle_smtp_menue_active");
    }

}

function twinkle_smtp_general_settings_init() {
    'use strict';
    twinkle_smtp_hide_all_settings();
    jQuery("#twinkle_smtp_general_settings").show();
}

function twinkle_smtp_sender_settings_init() {
    'use strict';
    twinkle_smtp_hide_all_settings();
    jQuery("#twinkle_smtp_sender_settings").show();
}


function twinkle_smtp_default_mailer_init() {
    'use strict';
    twinkle_smtp_hide_all_sender_settings();
    jQuery("#twinkle_smtp_mailer_default_content").show();
}

 
function twinkle_smtp_sendgrid_mailer_init() {
    'use strict';
    twinkle_smtp_hide_all_sender_settings();
    jQuery("#twinkle_smtp_mailer_sendgrid_content").show();
}
