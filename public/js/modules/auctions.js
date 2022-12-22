

$(document).ready(function (){
    $(document).on('click', '.remove_from_customer_auction', function (){
        var thisAuction = $(this);
        var id = thisAuction.data('id');
        var domain = thisAuction.data('domain');
        console.log('click -> remove_from_customer_auction -> ', id);
        if(thisAuction.attr('closed')){
            $('#delete_customer_auction_modal').find('.delete-customer-auction-confirm').attr('data-id',id);
            $('#delete_customer_auction_modal').find('.delete-customer-auction-confirm').attr('data-domain',domain);
            $('#delete_customer_auction_modal').find('.wish-list-domain').html(domain);
            $('#delete_customer_auction_modal').modal('show');
        }else{
            remove_watchlist(id, domain);
        }

    });

    $(document).on('click', '.delete-customer-auction-confirm', function (){
        var thisAuction = $(this);
        var id = thisAuction.attr('data-id');
        var domain = thisAuction.attr('data-domain');
        console.log('confirm -> delete-customer-auction-confirm -> ', id);
        remove_watchlist(id, domain);
        $('#delete_customer_auction_modal').modal('hide');
    });
    $(document).on('click', '.bid_manager', function (){
        console.log('OPen Bid Manager');
        var thisB = $(this);
        var id = thisB.data('id');
        console.log('id => ', id);
        if(!user_id){
            window.location = customer_login;
        }
        var new_url = url+'/customer/auction/bid/'+id;
        $.ajax({
            type: "post",
            url: new_url,
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            dataType: 'json',
            /*data:{
                'id':id
            },*/
            success: (response) => {
                var proceed = response.proceed;
                if(proceed == true){
                    window.location = new_url;
                }else{
                    console.log(response)
                    var auction_modal = $('#bid_auction_modal');
                    auction_modal.find('.title').text(response.title)
                    auction_modal.find('.message').text(response.message)
                    auction_modal.find('.close-button').text(response.button)
                    auction_modal.modal('show');
                }
            },
            error: (error) => {

            },
        });
    });
});

function remove_watchlist(id, domain){
    console.log('Removed from watchlist');
    $.ajax({
        type: "delete",
        url: url+'/customer/auction/'+ id,
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
        success: (response) => {
            /*table.draw();*/
            table.ajax.reload(null, false );
            var message = 'Die Auktion für die Domain '+domain+' wurde erfolgreich aus Ihrer Watchlist entfernt.';
            console.log('type', type)
            if(type == 'favourite'){
                message = 'Die Auktion für die Domain '+domain+' wurde erfolgreich aus Ihrer Favoriten entfernt.';
            }
            $('.alert-block').append('<div class="alert alert-success alert-dismissible fade show" role="alert">'+message+' </div>');

            setTimeout(function(){
                $('.alert-block').find('div').slideUp(500);
            }, 3500);
        },
        error: (error) => {

        },
    });
}

function add_watchlist(id, thisR){
    console.log('Add to watchlist');
    console.log('user_id => ', user_id);
    if(!user_id){
        window.location = customer_login;
    }
    var domain = thisR.data('domain');
    $.ajax({
        type: "get",
        url: url+'/customer/auction/watchlist/add',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
        data:{
            'id':id
        },
        success: (response) => {
            /*table.draw();*/
            table.ajax.reload(null, false );
            $('.alert-block').append('<div class="alert alert-success alert-dismissible fade show" role="alert">Die Auktion für die Domain '+domain+' wurde erfolgreich aus Ihrer Watchlist entfernt. </div>');

            setTimeout(function(){
                $('.alert-block').find('div').slideUp(500);
            }, 4500);
        },
        error: (error) => {

        },
    });
}
function add_favourite(id, thisR){
    console.log('Add to watchlist');
    console.log('user_id => ', user_id);
    if(!user_id){
        window.location = customer_login;
    }
    var domain = thisR.data('domain');
    $.ajax({
        type: "get",
        url: url+'/customer/auction/favourite/add',
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
        data:{
            'id':id
        },
        success: (response) => {
            /*table.draw();*/
            table.ajax.reload(null, false );
            $('.alert-block').append('<div class="alert alert-success alert-dismissible fade show" role="alert">Die Auktion für die Domain '+domain+' wurde erfolgreich aus Ihrer Watchlist entfernt. </div>');

            setTimeout(function(){
                $('.alert-block').find('div').slideUp(500);
            }, 4500);
        },
        error: (error) => {

        },
    });
}



