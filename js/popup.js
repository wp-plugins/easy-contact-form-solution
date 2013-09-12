jQuery(document).ready(function() {
     jQuery('div#fgcf-box-popup').css({"display":"none"})
    jQuery("div.update_entry").click(function() {
        var height = jQuery(document).height();
        var mid_height =window.screen.height / 2-200;
        var width = jQuery(document).width();
        var mid_width = width / 2 - 150;
        jQuery("div#update_div").css({
            "display": "block",
            "border": "3px solid #002a80",
            "width": "350px",
            "margin-top": mid_height,
            "margin-left": mid_width,
            "top": "0",
            "position": "fixed"
        });
        var post_id = jQuery(this).find('a.edit_entry').attr("entry_id");
        var value = jQuery(this).html();
        var name = jQuery(this).parent().parent().children('td.fgcf_name').html();
        var email = jQuery(this).parent().parent().children('td.fgcf_email').html();
        var subject = jQuery(this).parent().parent().children('td.fgcf_subject').html();
        var message = jQuery(this).parent().parent().children('td.fgcf_message').html();
        jQuery('input#fgcf_form_id').val(post_id);
        jQuery('input#fgcf-form_name').val(name);
        jQuery('input#fgcf-form_email').val(email);
        jQuery('input#fgcf-form_subject').val(subject);
        jQuery('textarea#fgcf-form_message').val(message);
    });
    jQuery('img#close_popup_img').click(function() {
        jQuery("div#update_div").css({"display": "none"});
    });
    var canvasheight = jQuery(document).height();
    var canvaswidth = jQuery(window).width();
    var form_position = jQuery(window).height();
    var mid_value = window.screen.height / 2-100;
	//alert(mid_value);
    var midd_value_width = canvaswidth / 2 - 250;
    jQuery('div.contac_us_img').css({
        "display": "block",
        "top": "0",
        "margin-top": mid_value,
        "margin-left": canvaswidth - 40
    });
    jQuery('div.contac_us_img').click(function() {
        jQuery('div#fgcf-box-popup').css({
            "height": canvasheight,
            "width": canvaswidth,
            "opacity": "1.95",
            "display": "block",
            "color": "white",
            "z-index": "2000",
            "position": "absolute",
            "top": "0"
        });
        jQuery('div#fg_form_show').css({
            "top": "0",
            "width": "400px",
            "margin-left": midd_value_width,
            "opacity": "1",
            "margin-top": 11 * form_position / 100,
            "position": "fixed",
            "display":"block"
        });
    });
     jQuery('.close_popup').css({
        "top": "0px",
        "margin-top": "-1px"
    });  jQuery('div#fg_close').click(function() {
        jQuery('input#fgcf_form_name').css({"border": "solid 1px #09C"});
         jQuery('input#fgcf_form_email').css({"border": "solid 1px #09C"});
          jQuery('input#fgcf_form_subject').css({"border": "solid 1px #09C"});
           jQuery('#fgcf_form_messages').css({"border": "solid 1px #09C"});
           jQuery('input#fgcf_form_name').val('');
         jQuery('input#fgcf_form_email').val('');
          jQuery('input#fgcf_form_subject').val('');
           jQuery('#fgcf_form_messages').val('');
         jQuery('div#fgcf-box-popup').css({
            "display": "none"
        });
    });
});