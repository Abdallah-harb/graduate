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
    
// to add class when we resze the sidebar
$(".hamburger").click(function(){
  $(".wrapper").toggleClass("active")
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


//confirm button delete (comme alert)
$('.da').click(function(){

	return confirm('Are You Sure.? ');

});
