timeout = 0;
function purchase(caller, id, name, quantity, options_data){

    quantity = quantity > 0 ? quantity : 1;

    if($('#quantity'+id).val() > 0 ) quantity = $('#quantity'+id).val();

    $.getJSON('/shop/cart/add'+'/id/'+id+'/quantity/'+quantity+'/options_data/'+options_data, function(data)
    {
        $('#itemsCount').html(data.itemsCount);
        $('#cost').html(data.cost);
        $('#prd_name').html(name);
        $('#prd_name').attr('href', $(caller).attr('href'));

        clearTimeout(timeout);
        $("#cart_dialog").center();
        $("#cart_dialog").fadeIn();
        timeout = setTimeout(function(){$("#cart_dialog").fadeOut();}, 2200);
    });

    return false;
}

function updateWidget(){
    $.getJSON('/shop/cart/getData', function(data)
    {
        $('#itemsCount').html(data.itemsCount);
        $('#cost').html(data.cost);
    });
}

function demand_vote(id){
    $.post('/shop/item/demandVote/id/'+id, function(data)
    {
        $('#vote_block_'+id).html('Ваш голос принят.');
        $.cookie('item_demand', $.cookie('item_demand')+'~'+id);
        //$.cookie('item_demand', '');
    });
}

function rating_vote(caller, id){
    //$('.star-rating-applied').rating('select',1)
    $.getJSON('/shop/item/ratingVote/id/'+id+'/rate/'+$(caller).val(), function(data)
    {
        //alert(data.rating)
        $('#rating'+id+' > input').rating('disable');
        $('#rating_vote_cnt'+id).html(data.rating_cnt);
        $('#rating_vote_msg'+id).fadeIn();
        setTimeout(function(){$('#rating_vote_msg'+id).fadeOut();}, 2200)
        $.cookie('item_rating', $.cookie('item_rating')+'~'+id);
        ////$.cookie('item_rating', '');
    });
}

function options_apply(){
    var data = '';
    var add_price = 0;
    $('.option').each( function(){
        val = $(this).val().split(';');
        data += $(this).val()+'^';
        add_price += parseInt($(this).val().split(';')[1]);
    } )
    $('.price_val').text( parseInt($('.price_val').attr('id')) + add_price );
    return data;
}
