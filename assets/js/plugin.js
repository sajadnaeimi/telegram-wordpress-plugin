jQuery(document).ready(function () {
    /*jQuery(".tabs p:first").addClass("active").show();
    jQuery(".tabs1:not(:first)").hide();
    jQuery(".tabs1:first").show();*/
    jQuery(".tabs p").click(function () {


        jQuery(".tabs p").removeClass("active");
        jQuery(this).addClass("active");
        stringref = jQuery(this).attr("href").split("#")[1];jQuery('#ew_active_tab').attr('value',stringref);
        jQuery(".tabs1:not(#" + stringref + ")").hide();
        if (jQuery.browser.msie && jQuery.browser.version.substr(0, 3) == "6.0") {
            jQuery(".tabs1#" + stringref).show()
        } else {
            jQuery(".tabs1#" + stringref).fadeIn()
        }

        return false
    });
    jQuery(".tabs2 i:first").addClass("active").show();
    jQuery(".tab2:not(:first)").hide();
    jQuery(".tab2:first").show();
    jQuery(".tabs2 i").click(function () {
        jQuery(".tabs2 i").removeClass("active");
        jQuery(this).addClass("active");
        stringref = jQuery(this).attr("href").split("#")[1];
        jQuery(".tab2:not(#" + stringref + ")").hide();
        if (jQuery.browser.msie && jQuery.browser.version.substr(0, 3) == "6.0") {
            jQuery(".tab2#" + stringref).show()
        } else {
            jQuery(".tab2#" + stringref).fadeIn()
        }
        return false
    });
    function b() {
        if (slideThree.checked == 1) {
            $("#box1").show()
        } else {
            $("#box1").hide()
        }
    }
});
$(document).ready(function () {
    $(".conp2").click(function () {
        $(this).toggleClass("selected");
        $(this).next().slideToggle();
        return false
    })
});