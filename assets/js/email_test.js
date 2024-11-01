jQuery(document).ready(function ($) {

    $('#twinkle_smtp_enable_html').prop('checked', true);

});


function twinkle_smtp_email_test_init(){
    'use strict';

    twinkle_smtp_hide_all_views();
    jQuery("#twinkle_smtp_email_test").show();
    var foundActive = $('.twinkle_smtp_header_nav ul li').find('twinkle_smtp_menue_active');
    if(foundActive){
        $('.twinkle_smtp_header_nav ul li').removeClass("twinkle_smtp_menue_active");
        $('.email_test').addClass("twinkle_smtp_menue_active");
    }else{
        $('.email_test').addClass("twinkle_smtp_menue_active"); 
    }

    let mail_test_data = {
        'data_test': 'Hello',
    };


    let post_data = { 'action': 'twinkle_smtp_mail_test_page_init', 'data': mail_test_data };

    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        data: post_data,
        success: function (data) {
            var obj = JSON.parse(data);

            if (obj.status == "true") {
                var from_email = obj.from_email ? obj.from_email : '' ;
                var test_email_sent_to = obj.test_email_sent_to ? obj.test_email_sent_to : '' ;

                jQuery("#twinkle_smtp_test_email_from").val(from_email);
                jQuery("#twinkle_smtp_test_email_send_to").val(test_email_sent_to);
            }
        }
    });


}