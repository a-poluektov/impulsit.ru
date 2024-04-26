$(document).ready(function(){
    console.log('custom.js included');

    $('#ip_send').click(function(){
        let ip = $(this).parents('form').find('#inputIP').val();

        if(ip){
            $.ajax({
                url: '/ajax/geoip.php',
                type: 'POST',
                dataType: "json",
                data: {
                    ip: ip
                },
                success: function(response){
                    console.log(response);
                    if(response.status === 'ok'){
                        let res_html = JSON.stringify(response.data, undefined, 4);
                        $('#geoip_result').html(res_html);
                        $('#data_from').text(response.message);
                        $('#geoip_result').removeClass('error');
                        $('#geoip_result').show();
                        $('#data_from').show();
                    }else{
                        $('#geoip_result').text(response.message);
                        $('#geoip_result').addClass('error');
                        $('#geoip_result').show();
                        $('#data_from').text('ERROR!');
                        $('#data_from').show();
                    }
                },
            });
        }else{
            alert('IP is empty! Please type IP adress and try again.');
        }
        
    });
});


