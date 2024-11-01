'use strict';
const $ = jQuery;

function SMTP_SET_STORAGE(name, value) {
    return localStorage.setItem(name, value);
}

function SMPT_GET_STORAGE(name) {
    return localStorage.getItem(name);
}

function SMTP_REMOVE_STORAGE(name) {
    return localStorage.removeItem(name);
}

function twinkle_smtp_plugin_init() {
    var page_slug = SMPT_GET_STORAGE('page_slug');
    setTimeout(function () {
        SMTP_SET_STORAGE('page_slug', page_slug);
    }, 200);

    window["twinkle_smtp_" + page_slug + "_init"]();
}

function twinkle_smtp_init_admin_dashboard(page_slug) {
    SMTP_SET_STORAGE('page_slug', page_slug);
    twinkle_smtp_plugin_init();
}

function twinkle_smtp_hide_all_views() {
    jQuery("#twinkle_smtp_analytics").hide();
    jQuery("#twinkle_smtp_settings").hide();
    jQuery("#twinkle_smtp_email_test").hide();
    jQuery("#twinkle_smtp_emails").hide();
    jQuery("#twinkle_smtp_email_logs").hide();

}


function twinkle_smtp_hide_all_settings() {
    jQuery("#twinkle_smtp_general_settings").hide();
    jQuery("#twinkle_smtp_sender_settings").hide();
    SMTP_SET_STORAGE('page_slug', 'settings');
}




jQuery(document).ready(function ($) {

    // $("#twinkle_smtp_sendgrid_form").reset();

    // for get session
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }


    $("#twinkle_smtp_test_email_form").validate({
        rules: {
            // simple rule, converted to {required:true}
            twinkle_smtp_test_email_from: "required",
            twinkle_smtp_test_email_send_to: "required",
            // compound rule
        },
        messages: {
            name: "Please specify your name",
            twinkle_smtp_test_email_from: {
                required: "Sender email is required.",
                email: "Your email address must be in the format of name@domain.com"
            },
            twinkle_smtp_test_email_send_to: {
                required: "Reciver email is required.",
                email: "Your email address must be in the format of name@domain.com"
            }

        },
        // start ajax submit handaler
        submitHandler: function () {
            submit_smtp_test_email();
        },

    });

    // default api
    $("#twinkle_smtp_default_mailer_form").validate({
        rules: {
            // simple rule, converted to {required:true}
            twinkle_smtp_default_mailer_from_email: "required",
            twinkle_smtp_default_mailer_from_name: "required",
            twinkle_smtp_default_mailer_smtp_host: "required",
            twinkle_smtp_default_mailer_smtp_port: "required",
            twinkle_smtp_default_mailer_smtp_username: "required",
            twinkle_smtp_default_mailer_smtp_password: "required",
            // compound rule
        },
        messages: {
            name: "Please specify your name",
            twinkle_smtp_default_mailer_from_email: {
                required: "Sender email is required.",
                email: "Your email address must be in the format of name@domain.com"
            },
            twinkle_smtp_default_mailer_from_name: {
                required: "Sender name is required.",
            },
            twinkle_smtp_default_mailer_smtp_host: {
                required: "SMTP host is required.",
            },
            twinkle_smtp_default_mailer_smtp_port: {
                required: "SMTP port is required.",
            },
            twinkle_smtp_default_mailer_smtp_username: {
                required: "SMTP username is required.",
            },
            twinkle_smtp_default_mailer_smtp_username: {
                required: "SMTP username is required.",
            },
            twinkle_smtp_default_mailer_smtp_password: {
                required: "SMTP password is required.",
            }

        },
        // start ajax submit handaler
        submitHandler: function () {
            submit_smtp_default_settings();
        },

    });

   // sendgrid api
    $("#twinkle_smtp_sendgrid_form").validate({
        rules: {
            // simple rule, converted to {required:true}
            twinkle_smtp_sendgrid_from_email: "required",
            twinkle_smtp_sendgrid_from_name: "required",
            twinkle_smtp_sendgrid_api_key: "required",
            // compound rule
        },
        messages: {
            name: "Please specify your name",
            twinkle_smtp_sendgrid_from_email: {
                required: "Sender email is required.",
                email: "Your email address must be in the format of name@domain.com"
            },
            twinkle_smtp_sendgrid_from_name: {
                required: "Sender name is required.",
            },
            twinkle_smtp_sendgrid_api_key: {
                required: "Api key is required.",
            }

        },
        // start ajax submit handaler
        submitHandler: function () {
            submit_smtp_sendgrid_settings();
        },

    });


    // sendinblue api
    $("#twinkle_smtp_sendinblue_form").validate({
        rules: {
            // simple rule, converted to {required:true}
            twinkle_smtp_sendinblue_from_email: "required",
            twinkle_smtp_sendinblue_from_name: "required",
            twinkle_smtp_sendinblue_api_key: "required",
            // compound rule
        },
        messages: {
            name: "Please specify your name",
            twinkle_smtp_sendinblue_from_email: {
                required: "Sender email is required.",
                email: "Your email address must be in the format of name@domain.com"
            },
            twinkle_smtp_sendinblue_from_name: {
                required: "Sender name is required.",
            },
            twinkle_smtp_sendinblue_api_key: {
                required: "Api key is required.",
            }

        },
        // start ajax submit handaler
        submitHandler: function () {
            submit_smtp_sendinblue_settings();
        },

    });

    
    // postmark api
    $("#twinkle_smtp_postmark_form").validate({
        rules: {
            // simple rule, converted to {required:true}
            twinkle_smtp_postmark_from_email: "required",
            twinkle_smtp_postmark_from_name: "required",
            twinkle_smtp_postmark_api_key: "required",
            // compound rule
        },
        messages: {
            name: "Please specify your name",
            twinkle_smtp_postmark_from_email: {
                required: "Sender email is required.",
                email: "Your email address must be in the format of name@domain.com"
            },
            twinkle_smtp_postmark_from_name: {
                required: "Sender name is required.",
            },
            twinkle_smtp_postmark_api_key: {
                required: "Api key is required.",
            }

        },
        // start ajax submit handaler
        submitHandler: function () {
            submit_smtp_postmark_settings();
        },

    });


    // sparkpost api
    $("#twinkle_smtp_sparkpost_form").validate({
        rules: {
            // simple rule, converted to {required:true}
            twinkle_smtp_sparkpost_from_email: "required",
            twinkle_smtp_sparkpost_from_name: "required",
            twinkle_smtp_sparkpost_api_key: "required",
            // compound rule
        },
        messages: {
            name: "Please specify your name",
            twinkle_smtp_sparkpost_from_email: {
                required: "Sender email is required.",
                email: "Your email address must be in the format of name@domain.com"
            },
            twinkle_smtp_sparkpost_from_name: {
                required: "Sender name is required.",
            },
            twinkle_smtp_sparkpost_api_key: {
                required: "Api key is required.",
            }

        },
        // start ajax submit handaler
        submitHandler: function () {
            submit_smtp_sparkpost_settings();
        },

    });


    // aws api
    $("#twinkle_smtp_aws_form").validate({
        rules: {
            // simple rule, converted to {required:true}
            twinkle_smtp_aws_from_email: "required",
            twinkle_smtp_aws_from_name: "required",
            twinkle_smtp_aws_access_key: "required",
            twinkle_smtp_aws_secret_key: "required",
            twinkle_smtp_aws_region: "required",
            // compound rule
        },
        messages: {
            name: "Please specify your name",
            twinkle_smtp_aws_from_email: {
                required: "Sender email is required.",
                email: "Your email address must be in the format of name@domain.com"
            },
            twinkle_smtp_aws_from_name: {
                required: "Sender name is required.",
            },
            twinkle_smtp_aws_access_key: {
                required: "Access key is required.",
            },
            twinkle_smtp_aws_secret_key: {
                required: "Secret key is required.",
            },
            twinkle_smtp_aws_region: {
                required: "Region is required.",
            }

        },
        // start ajax submit handaler
        submitHandler: function () {
            submit_smtp_aws_settings();
        },

    });


    // Mailgun api
    $("#twinkle_smtp_mailgun_form").validate({
        rules: {
            // simple rule, converted to {required:true}
            twinkle_smtp_mailgun_from_email: "required",
            twinkle_smtp_mailgun_from_name: "required",
            twinkle_smtp_mailgun_api_key: "required",
            twinkle_smtp_mailgun_domain_name: "required",
            twinkle_smtp_mailgun_region: "required",
            // compound rule
        },
        messages: {
            name: "Please specify your name",
            twinkle_smtp_mailgun_from_email: {
                required: "Sender email is required.",
                email: "Your email address must be in the format of name@domain.com"
            },
            twinkle_smtp_mailgun_from_name: {
                required: "Sender name is required.",
            },
            twinkle_smtp_mailgun_api_key: {
                required: "Api key is required.",
            },
            twinkle_smtp_mailgun_domain_name: {
                required: "Domain is required.",
            },
            twinkle_smtp_mailgun_region: {
                required: "Region is required.",
            }

        },
        // start ajax submit handaler
        submitHandler: function () {
            submit_smtp_mailgun_settings();
        },

    });
    

    niceSelect()

});


function  submit_smtp_mailgun_settings(){

    $("#twinkle_smtp_mailgun_mailer_submit span").text("Please Wait...");
    $("#twinkle_smtp_mailgun_mailer_submit .twinkle-smtp-btn-spinner").removeClass("twinkle-smtp-loader-hide");
    $("#twinkle_smtp_mailgun_mailer_submit").prop('disabled', true);
    $("#twinkle_smtp_mailgun_mailer_submit").addClass('test_mail_submit_disabled');

    let mailgun_mailer_data = {
        'mailgun_from_email': ($("#twinkle_smtp_mailgun_from_email").val()) ? $("#twinkle_smtp_mailgun_from_email").val() : '',
        'mailgun_from_name': ($("#twinkle_smtp_mailgun_from_name").val()) ? $("#twinkle_smtp_mailgun_from_name").val() : '',
        'mailgun_api_key': ($("#twinkle_smtp_mailgun_api_key").val()) ? $("#twinkle_smtp_mailgun_api_key").val() : '',
        'mailgun_domain_name': ($("#twinkle_smtp_mailgun_domain_name").val()) ? $("#twinkle_smtp_mailgun_domain_name").val() : '',
        'mailgun_region': ($("input[name='twinkle_smtp_mailgun_region']:checked").val()) ? $("input[name='twinkle_smtp_mailgun_region']:checked").val() : '',
    };

    let post_data = { 'action': 'twinkle_smtp_mailgun_mailer', 'data': JSON.stringify(mailgun_mailer_data) };

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

            $("#twinkle_smtp_mailgun_mailer_submit span").text("Save Settings");
            $("#twinkle_smtp_mailgun_mailer_submit .twinkle-smtp-btn-spinner").addClass("twinkle-smtp-loader-hide");
            $("#twinkle_smtp_mailgun_mailer_submit").prop('disabled', false);
            $("#twinkle_smtp_mailgun_mailer_submit").removeClass('test_mail_submit_disabled');
  
             // Reset all form
             $(".twinkle_smtp_default_reset").val('');
             $(".default_auth_yes").prop("checked",true);
             $(".encryption_type_ssl").prop('checked',true);
             $(".twinkle_smtp_sendgrid_reset").val('');
             $(".twinkle_smtp_sendinblue_reset").val('');
             $(".twinkle_smtp_postmark_reset").val('');
             $(".twinkle_smtp_sparkpost_reset").val('');
             $(".twinkle_smtp_aws_reset").val('');

        }
    });
}


function submit_smtp_aws_settings(){

    $("#twinkle_smtp_aws_mailer_submit span").text("Please Wait...");
    $("#twinkle_smtp_aws_mailer_submit .twinkle-smtp-btn-spinner").removeClass("twinkle-smtp-loader-hide");
    $("#twinkle_smtp_aws_mailer_submit").prop('disabled', true);
    $("#twinkle_smtp_aws_mailer_submit").addClass('test_mail_submit_disabled');

    let aws_mailer_data = {
        'aws_from_email': ($("#twinkle_smtp_aws_from_email").val()) ? $("#twinkle_smtp_aws_from_email").val() : '',
        'aws_from_name': ($("#twinkle_smtp_aws_from_name").val()) ? $("#twinkle_smtp_aws_from_name").val() : '',
        'aws_access_key': ($("#twinkle_smtp_aws_access_key").val()) ? $("#twinkle_smtp_aws_access_key").val() : '',
        'aws_secret_key': ($("#twinkle_smtp_aws_secret_key").val()) ? $("#twinkle_smtp_aws_secret_key").val() : '',
        'aws_region': ($("#twinkle_smtp_aws_region").val()) ? $("#twinkle_smtp_aws_region").val() : '',
    };

    let post_data = { 'action': 'twinkle_smtp_aws_mailer', 'data': JSON.stringify(aws_mailer_data) };

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

            $("#twinkle_smtp_aws_mailer_submit span").text("Save Settings");
            $("#twinkle_smtp_aws_mailer_submit .twinkle-smtp-btn-spinner").addClass("twinkle-smtp-loader-hide");
            $("#twinkle_smtp_aws_mailer_submit").prop('disabled', false);
            $("#twinkle_smtp_aws_mailer_submit").removeClass('test_mail_submit_disabled');
  
             // Reset all form
             $(".twinkle_smtp_default_reset").val('');
             $(".default_auth_yes").prop("checked",true);
             $(".encryption_type_ssl").prop('checked',true);
             $(".twinkle_smtp_sendgrid_reset").val('');
             $(".twinkle_smtp_sendinblue_reset").val('');
             $(".twinkle_smtp_postmark_reset").val('');
             $(".twinkle_smtp_sparkpost_reset").val('');
             $(".twinkle_smtp_mailgun_reset").val('');
             $(".twinkle_smtp_mailgun_region").prop('checked',false);

        }
    });
}

function submit_smtp_sparkpost_settings(){

    $("#twinkle_smtp_sparkpost_mailer_submit span").text("Please Wait...");
    $("#twinkle_smtp_sparkpost_mailer_submit .twinkle-smtp-btn-spinner").removeClass("twinkle-smtp-loader-hide");
    $("#twinkle_smtp_sparkpost_mailer_submit").prop('disabled', true);
    $("#twinkle_smtp_sparkpost_mailer_submit").addClass('test_mail_submit_disabled');

    let sparkpost_mailer_data = {
        'sparkpost_from_email': ($("#twinkle_smtp_sparkpost_from_email").val()) ? $("#twinkle_smtp_sparkpost_from_email").val() : '',
        'sparkpost_from_name': ($("#twinkle_smtp_sparkpost_from_name").val()) ? $("#twinkle_smtp_sparkpost_from_name").val() : '',
        'sparkpost_api_key': ($("#twinkle_smtp_sparkpost_api_key").val()) ? $("#twinkle_smtp_sparkpost_api_key").val() : '',
    };

    let post_data = { 'action': 'twinkle_smtp_sparkpost_mailer', 'data': JSON.stringify(sparkpost_mailer_data) };

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

            $("#twinkle_smtp_sparkpost_mailer_submit span").text("Save Settings");
            $("#twinkle_smtp_sparkpost_mailer_submit .twinkle-smtp-btn-spinner").addClass("twinkle-smtp-loader-hide");
            $("#twinkle_smtp_sparkpost_mailer_submit").prop('disabled', false);
            $("#twinkle_smtp_sparkpost_mailer_submit").removeClass('test_mail_submit_disabled');
  
             // Reset all form
             $(".twinkle_smtp_default_reset").val('');
             $(".default_auth_yes").prop("checked",true);
             $(".encryption_type_ssl").prop('checked',true);
             $(".twinkle_smtp_sendgrid_reset").val('');
             $(".twinkle_smtp_sendinblue_reset").val('');
             $(".twinkle_smtp_postmark_reset").val('');
             $(".twinkle_smtp_aws_reset").val('');
             $(".twinkle_smtp_mailgun_reset").val('');
             $(".twinkle_smtp_mailgun_region").prop('checked',false);

        }
    });
}

function submit_smtp_postmark_settings(){

    $("#twinkle_smtp_postmark_mailer_submit span").text("Please Wait...");
    $("#twinkle_smtp_postmark_mailer_submit .twinkle-smtp-btn-spinner").removeClass("twinkle-smtp-loader-hide");
    $("#twinkle_smtp_postmark_mailer_submit").prop('disabled', true);
    $("#twinkle_smtp_postmark_mailer_submit").addClass('test_mail_submit_disabled');

    let postmark_mailer_data = {
        'postmark_from_email': ($("#twinkle_smtp_postmark_from_email").val()) ? $("#twinkle_smtp_postmark_from_email").val() : '',
        'postmark_from_name': ($("#twinkle_smtp_postmark_from_name").val()) ? $("#twinkle_smtp_postmark_from_name").val() : '',
        'postmark_api_key': ($("#twinkle_smtp_postmark_api_key").val()) ? $("#twinkle_smtp_postmark_api_key").val() : '',
    };

    let post_data = { 'action': 'twinkle_smtp_postmark_mailer', 'data': JSON.stringify(postmark_mailer_data) };

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

            $("#twinkle_smtp_postmark_mailer_submit span").text("Save Settings");
            $("#twinkle_smtp_postmark_mailer_submit .twinkle-smtp-btn-spinner").addClass("twinkle-smtp-loader-hide");
            $("#twinkle_smtp_postmark_mailer_submit").prop('disabled', false);
            $("#twinkle_smtp_postmark_mailer_submit").removeClass('test_mail_submit_disabled');
  
             // Reset all form
             $(".twinkle_smtp_default_reset").val('');
             $(".default_auth_yes").prop("checked",true);
             $(".encryption_type_ssl").prop('checked',true);
             $(".twinkle_smtp_sendgrid_reset").val('');
             $(".twinkle_smtp_sendinblue_reset").val('');
             $(".twinkle_smtp_sparkpost_reset").val('');
             $(".twinkle_smtp_aws_reset").val('');

        }
    });
}

function submit_smtp_sendinblue_settings() {

    $("#twinkle_smtp_sendinblue_mailer_submit span").text("Please Wait...");
    $("#twinkle_smtp_sendinblue_mailer_submit .twinkle-smtp-btn-spinner").removeClass("twinkle-smtp-loader-hide");
    $("#twinkle_smtp_sendinblue_mailer_submit").prop('disabled', true);
    $("#twinkle_smtp_sendinblue_mailer_submit").addClass('test_mail_submit_disabled');

    let sendinblue_mailer_data = {
        'sendinblue_from_email': ($("#twinkle_smtp_sendinblue_from_email").val()) ? $("#twinkle_smtp_sendinblue_from_email").val() : '',
        'sendinblue_from_name': ($("#twinkle_smtp_sendinblue_from_name").val()) ? $("#twinkle_smtp_sendinblue_from_name").val() : '',
        'sendinblue_api_key': ($("#twinkle_smtp_sendinblue_api_key").val()) ? $("#twinkle_smtp_sendinblue_api_key").val() : '',
    };

    let post_data = { 'action': 'twinkle_smtp_sendinblue_mailer', 'data': JSON.stringify(sendinblue_mailer_data) };

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

            $("#twinkle_smtp_sendinblue_mailer_submit span").text("Save Settings");
            $("#twinkle_smtp_sendinblue_mailer_submit .twinkle-smtp-btn-spinner").addClass("twinkle-smtp-loader-hide");
            $("#twinkle_smtp_sendinblue_mailer_submit").prop('disabled', false);
            $("#twinkle_smtp_sendinblue_mailer_submit").removeClass('test_mail_submit_disabled');
  
             // Reset all form
             $(".twinkle_smtp_default_reset").val('');
             $(".default_auth_yes").prop("checked",true);
             $(".encryption_type_ssl").prop('checked',true);
             $(".twinkle_smtp_sendgrid_reset").val('');
             $(".twinkle_smtp_postmark_reset").val('');
             $(".twinkle_smtp_sparkpost_reset").val('');
             $(".twinkle_smtp_aws_reset").val('');

        }
    });
}

function submit_smtp_sendgrid_settings() {

    $("#twinkle_smtp_sendgrid_mailer_submit span").text("Please Wait...");
    $("#twinkle_smtp_sendgrid_mailer_submit .twinkle-smtp-btn-spinner").removeClass("twinkle-smtp-loader-hide");
    $("#twinkle_smtp_sendgrid_mailer_submit").prop('disabled', true);
    $("#twinkle_smtp_sendgrid_mailer_submit").addClass('test_mail_submit_disabled');

    let sendgrid_mailer_data = {
        'sendgrid_from_email': ($("#twinkle_smtp_sendgrid_from_email").val()) ? $("#twinkle_smtp_sendgrid_from_email").val() : '',
        'sendgrid_from_name': ($("#twinkle_smtp_sendgrid_from_name").val()) ? $("#twinkle_smtp_sendgrid_from_name").val() : '',
        'sendgrid_api_key': ($("#twinkle_smtp_sendgrid_api_key").val()) ? $("#twinkle_smtp_sendgrid_api_key").val() : '',
    };

    let post_data = { 'action': 'twinkle_smtp_sendgrid_mailer', 'data': JSON.stringify(sendgrid_mailer_data) };

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

            $("#twinkle_smtp_sendgrid_mailer_submit span").text("Save Settings");
            $("#twinkle_smtp_sendgrid_mailer_submit .twinkle-smtp-btn-spinner").addClass("twinkle-smtp-loader-hide");
            $("#twinkle_smtp_sendgrid_mailer_submit").prop('disabled', false);
            $("#twinkle_smtp_sendgrid_mailer_submit").removeClass('test_mail_submit_disabled');
  
             // Reset all form
             $(".twinkle_smtp_default_reset").val('');
             $(".default_auth_yes").prop("checked",true);
             $(".encryption_type_ssl").prop('checked',true);
             $(".twinkle_smtp_sendinblue_reset").val('');
             $(".twinkle_smtp_postmark_reset").val('');
             $(".twinkle_smtp_sparkpost_reset").val('');
             $(".twinkle_smtp_aws_reset").val('');

        }
    });
}

function submit_smtp_default_settings() {

    $("#twinkle_smtp_default_mailer_submit span").text("Please Wait...");
    $("#twinkle_smtp_default_mailer_submit .twinkle-smtp-btn-spinner").removeClass("twinkle-smtp-loader-hide");
    $("#twinkle_smtp_default_mailer_submit").prop('disabled', true);
    $("#twinkle_smtp_default_mailer_submit").addClass('test_mail_submit_disabled');

    let default_mailer_data = {
        'default_from_email': ($("#twinkle_smtp_default_mailer_from_email").val()) ? $("#twinkle_smtp_default_mailer_from_email").val() : '',

        'default_from_name': ($("#twinkle_smtp_default_mailer_from_name").val()) ? $("#twinkle_smtp_default_mailer_from_name").val() : '',

        'default_bcc_email': ($("#twinkle_smtp_default_mailer_bcc_email_address").val()) ? $("#twinkle_smtp_default_mailer_bcc_email_address").val() : ' ',

        'default_smtp_host': ($("#twinkle_smtp_default_mailer_smtp_host").val()) ? $("#twinkle_smtp_default_mailer_smtp_host").val() : '',

        'default_smtp_port': ($("#twinkle_smtp_default_mailer_smtp_port").val()) ? $("#twinkle_smtp_default_mailer_smtp_port").val() : '',

        'default_type_of_encryption': ($("input[name='twinkle_smtp_encryption_type']:checked").val()) ? $("input[name='twinkle_smtp_encryption_type']:checked").val() : '',

        'default_auth_type': ($("input[name='twinkle_smtp_default_mailer_authentication_type']:checked").val()) ? $("input[name='twinkle_smtp_default_mailer_authentication_type']:checked").val() : '',

        'default_smtp_username': ($("#twinkle_smtp_default_mailer_smtp_username").val()) ? $("#twinkle_smtp_default_mailer_smtp_username").val() : '',

        'default_smtp_password': ($("#twinkle_smtp_default_mailer_smtp_password").val()) ? $("#twinkle_smtp_default_mailer_smtp_password").val() : '',

    };

    let post_data = { 'action': 'twinkle_smtp_default_mailer', 'data': JSON.stringify(default_mailer_data) };

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

            $("#twinkle_smtp_default_mailer_submit span").text("Save Settings");
            $("#twinkle_smtp_default_mailer_submit .twinkle-smtp-btn-spinner").addClass("twinkle-smtp-loader-hide");
            $("#twinkle_smtp_default_mailer_submit").prop('disabled', false);
            $("#twinkle_smtp_default_mailer_submit").removeClass('test_mail_submit_disabled');

            // Reset all form
            $(".twinkle_smtp_sendgrid_reset").val('');
            $(".twinkle_smtp_sendinblue_reset").val('');
            $(".twinkle_smtp_postmark_reset").val('');
            $(".twinkle_smtp_sparkpost_reset").val('');


        }
    });
}

function submit_smtp_test_email() {

    $("#twinkle_smtp_test_email_submit span").text("Please Wait...");
    $("#twinkle_smtp_test_email_submit .twinkle-smtp-btn-spinner").removeClass("twinkle-smtp-loader-hide");
    $("#twinkle_smtp_test_email_submit").prop('disabled', true);
    $("#twinkle_smtp_test_email_submit").addClass('test_mail_submit_disabled');

    var html_status = '';

    if ($("#twinkle_smtp_enable_html").prop("checked") == true) {
        html_status = "yes";
    }else{
        html_status = "no";
    }
    

    let test_email_data = {
        'test_email_from': ($("#twinkle_smtp_test_email_from").val()) ? $("#twinkle_smtp_test_email_from").val() : '',
        'test_email_to': ($("#twinkle_smtp_test_email_send_to").val()) ? $("#twinkle_smtp_test_email_send_to").val() : '',
        'html_status':  html_status,
    };

    let post_data = { 'action': 'twinkle_smtp_test_email', 'data': JSON.stringify(test_email_data) };

    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        data: post_data,
        success: function (data) {
            
            var obj = JSON.parse(data);
            if ( "success" === obj.send_status) {
                Command: toastr["success"]("Mail Sent Successfully.");
            } else {
                Command: toastr["error"]("Mail Sending Failed!");
            }

            $("#twinkle_smtp_test_email_submit span").text("Send Test Email");
            $(".twinkle-smtp-btn-spinner").addClass("twinkle-smtp-loader-hide");
            $("#twinkle_smtp_test_email_submit").prop('disabled', false);
            $("#twinkle_smtp_test_email_submit").removeClass('test_mail_submit_disabled');

        }
    })
}

function niceSelect() {
    $('#twinkle_smtp_delete_email_logs').niceSelect();
    $('#twinkle_smtp_analytics_report').niceSelect();
    $('#twinkle_smtp_aws_region').niceSelect();
}




