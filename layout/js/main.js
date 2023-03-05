$(function(){
//button to scroll top
$(window).scroll(function(){ 
        if ($(this).scrollTop() > 100) { 
            $('#scroll').fadeIn(); 
        } else { 
            $('#scroll').fadeOut(); 
        } 
}); 
$('#scroll').click(function(){ 
    $("html, body").animate({ scrollTop: 0 }, 600); 
    return false; 
}); 

//to focus and Blur the input
$('input').on('focus',function(){
    $attribute = $(this).attr("placeholder");
    $(this).attr("placeholder","");
}).on('blur',function(){
    $(this).attr("placeholder",$attribute);
});


//show password on hover
$('.show-pass').hover(function(){
    $('.password').attr('type','text');

 },function(){
    $('.password').attr('type','password');
    });

//evaluation
    
    $('.rateyo').rateYo().on('rateyo.change',function(e,data){
        var rating = data.rating;
        $(this).parent().find('.score').text('score :'+ $(this).attr('data-rateyo-score'));
        $(this).parent().find('.result').text('rating :'+ rating);
        $(this).parent().find('input[name=rating]').val(rating);
    });
     


})


