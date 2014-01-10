$(function(){
	$("ul.dropdown li").hover(function(){
		$(this).addClass("hover");
		//$('ul:first',this).css('display', 'block');
		$('ul:first',this).slideDown(100);
	}, function(){
		$(this).removeClass("hover");
		//$('ul:first',this).css('display', 'none');
		$('ul:first',this).slideUp(100);
	});
	$("ul.dropdown li ul li:has(ul)").find("a:first").append(" &raquo; ");
});