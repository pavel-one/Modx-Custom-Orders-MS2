
var target = $('.customOrders .customOrders_wrapper .item');
target.click(function(event) {
	var id = $(this).data('id');
	var modal = $('#order_detail');
	$.ajax({
    url: 'assets/components/MyCustomOrders/action/getOrder.php',
    type: 'POST',
    dataType: 'json',
    data: {
        id: id,
    },
    success: function(response) {
    	console.log(response);
    	modal.find('#num').text(response.order[0].num);
    	modal.find('#name').text(response.order[0].receiver);
        modal.find('#payment_name').text(response.order[0].paymentName);
    	modal.find('#cart_price').text(response.order[0].cart_cost);
    	modal.find('#date').text(response.order[0].createdon);
    	modal.find('#delivery_name').text(response.order[0].deliveryName);
    	modal.find('#delivery_price').text(response.order[0].delivery_cost);
    	modal.find('#status_name').text(response.order[0].statusName);
    	modal.find('#delivery_adress').text(response.order[0].index + ', ' + response.order[0].region + ', ' + response.order[0].city + ', ' + response.order[0].street + ', д.' + response.order[0].building + ', кв.' + response.order[0].room);
    	modal.find('#track').text(response.order[0].track);
    	modal.find('#weight').text(response.order[0].weight);
    	//не забыть
    	modal.find('#status_delivery').text('');

    	modal.find('.product_body table tbody').html('');
    	response.products.forEach(function(item, i) {
    		modal.find('.product_body table tbody').append('<tr>' + '<td>' + (i+1) + '</td>' + '<td>' + item.name + '</td>' + '<td>' + item.count + '</td>' + '<td>' + item.price + '</td>' + '</tr>');
    	})
		$.fancybox.open({
			src  : '#order_detail',
			type : 'inline',
			opts : {
				afterShow : function( instance, current ) {
					console.info( 'done!' );
				}
			}
		});

    }
});
	return false;
});