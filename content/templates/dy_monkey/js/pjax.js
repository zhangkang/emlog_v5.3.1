$(document).pjax('a[target!=_blank]', '#monkey_pjax', {fragment: '#monkey_pjax',timeout: 8000}); 
	$(document).on('pjax:send', function() {
    $(".loading").css("display", "block");
});

$(document).on('pjax:complete', function() {
	$("img[src$=jpg],img[src$=jpeg],img[src$=png],img[src$=gif]").parent("a[class!=noview]").addClass("swipebox");
	if( $('pre').length ){ prettyPrint(); }
    $(".loading").css("display", "none");
    search(); comment();
    jQuery(function($) { $(".swipebox").swipebox(); });
});
