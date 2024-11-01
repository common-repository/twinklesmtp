
function twinkle_smtp_analytics_init() {
    'use strict';

    twinkle_smtp_hide_all_views();
    jQuery("#twinkle_smtp_analytics").show();

    var foundActive = $('.twinkle_smtp_header_nav ul li').find('twinkle_smtp_menue_active');
    if(foundActive){
        $('.twinkle_smtp_header_nav ul li').removeClass("twinkle_smtp_menue_active");
        $('.analytics').addClass("twinkle_smtp_menue_active");
    }else{
        $('.analytics').addClass("twinkle_smtp_menue_active");
    }
    
    let analytics_data = {
        'data_test': 'Hello',
    };


    let post_data = { 'action': 'twinkle_smtp_analytics', 'data': analytics_data };

    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        data: post_data,
        success: function (data) {
            var obj = JSON.parse(data);

            if (obj.status == "true") {
                const labels_name = obj.labels;
                const label_values = obj.label_values;
                const total_successed = obj.total_successed;
                const total_failed = obj.total_failed;
                const delete_twinkle_smtp_logs = obj.delete_twinkle_smtp_logs;

                twinkle_smtp_chart(labels_name, label_values);
                twinkle_smtp_statistics(total_successed,total_failed,delete_twinkle_smtp_logs);
            }
        }
    });

}

var twinkle_smtp_analytycs_chart = null;

function twinkle_smtp_chart(labels_name, label_values) {

    if (twinkle_smtp_analytycs_chart != null) {
        twinkle_smtp_analytycs_chart.destroy();
    }

    var ctx = document.getElementById('twinkle_smtp_chart');

    var data = {
        labels: labels_name,
        datasets: [{
            type: 'bar',
            label: 'Bar Chart- Mail Sent',
            data: label_values,
            borderColor: 'rgb(54, 162, 235)',
            backgroundColor: '#3155ffa6',
            borderRadius: 100,
            borderSkipped: 'top',
            barPercentage: 0.65

        }, {
            type: 'line',
            label: 'Line Chart- Mail Sent',
            data: label_values,
            fill: false,
            borderColor: 'rgb(54, 162, 235)'
        }]
    };

    twinkle_smtp_analytycs_chart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },

            elements: {
                line: {
                    tension: 0.4
                }
            }
        }
    });

}


function twinkle_smtp_statistics( total_successed, total_failed, delete_twinkle_smtp_logs ){

    jQuery(".twinkle_smtp_total_mail_sent").text( total_successed );
    jQuery(".twinkle_smtp_total_mail_faild").text( total_failed );
    jQuery(".twinkle_smtp_delete_logs").text( delete_twinkle_smtp_logs );



}

