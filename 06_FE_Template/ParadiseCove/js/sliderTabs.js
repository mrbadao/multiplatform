var $=jQuery;
function sliderTabsCalc() {
	var st_mainWidth = $(".top_slider_navi .inner").width();	
	var st_pageItem = $(".top_slider_navi .inner a");
	var st_pageCount = st_pageItem.size();	
	st_pageItem.css("width", st_mainWidth/st_pageCount);
}
$(window).load(function() {
		
	sliderTabsCalc();	
	$(window).resize(function() {		        
        sliderTabsCalc();
    });	
});