$(document).ready(function(e) {
	accordion();
	triangle_position();
	$(".rating_buttons ul li").click(function(){
		//$(".rating_buttons ul li ul").slideUp();
		$(this).find("ul").slideToggle();
	});
	/*toggleObject(".mMenu_icon", "#menu");*/
});
$(window).resize(function(e) {
	triangle_position();
});
function accordion(){
	$('div.accord_head').click(function() {
		if($(this).hasClass('expand')){
			$(this).removeClass('expand');
			$(this).addClass('collapse');
		}
		else{
			$(this).removeClass('collapse');
			$(this).addClass('expand');
		}
		$(this).next().slideToggle("fast");
		
	});
}
function triangle_position(){
	var lPos = $(".form_area .label").width() + 19;
	$(".form_area .triangle").css("left", lPos+"px");
}
function toggleObject(target, obj){
	$(target).click(function(e) {
        $(obj).slideToggle("slow");
    });
}