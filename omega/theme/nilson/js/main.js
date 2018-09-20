/**
 * Created by sylvain on 25.04.2016.
 */
$(function(){
    $(document).keydown(function(e) {
        if (e.keyCode === 37) {
            // Previous
            $(".carousel-control.left").click();
            return false;
        }
        if (e.keyCode === 39) {
            // Next
            $(".carousel-control.right").click();
            return false;
        }
    });
});