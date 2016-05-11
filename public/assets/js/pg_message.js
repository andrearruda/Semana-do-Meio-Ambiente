$(document).ready(function() {
    $('.bt_show').click(function(){

        var bt = $(this);
        var id = $(this).attr('data-key');

        $.ajax({
            type: 'POST',
            url: '/message/show/' + id,
            dataType: 'text',
            success: function(data){
                console.log('success');
                console.log(data)
/*                $('#load_modal').html(data);
                $('#load_modal #myModal').modal();*/
            },
            beforeSend: function(){
                console.log('beforeSend');
            },
/*            complete: function(){
                console.log('complete');
                bt.find('i').removeClass();
                bt.find('i').addClass('glyphicon glyphicon-zoom-in');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('error');
                console.log('   jqXHR: ' + jqXHR);
                console.log('   textStatus: ' + textStatus);
                console.log('   errorThrown: ' + errorThrown);
            }*/
        });

    });
});