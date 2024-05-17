clickcount =0;
$(".Fr-star.userChoose").Fr_star(function(rating){
 if(clickcount==0){
    var item_id = $('#item-id').val();
    var type = $('#item-type').val();
    var token = $('meta[name="csrf-token"]').attr('content');
    $.post("/rating-respone", {"_token": token, 'rating': rating, 'item_id':item_id, 'type':type}, function(response){
      // console.log(response.status);
    });
    clickcount++;
 }
});
