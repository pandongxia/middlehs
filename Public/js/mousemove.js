$(document).ready(function(){
	$(".sitenav li").mouseover(function(){
		$(this).find('.subnav').show();
	})
     
	$(".sitenav li").mouseout(function(){
		$(this).find('.subnav').hide();
	})
});