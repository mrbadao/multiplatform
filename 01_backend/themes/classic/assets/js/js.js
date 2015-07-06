/**
 * Created by hieun_000 on 7/4/2015.
 */
$(document).ready(function(){
    if($("#main").height() + 10 > $("nav.sidebar").height()) $("nav.sidebar").height($("#main").height() + 10);
});
