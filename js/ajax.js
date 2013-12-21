jQuery(document).ready(function() {
    jQuery('.embed_code_save').click(function() {
        jQuery('#dvLoading').css({"display": "block"});
        jQuery('#dvLoading').fadeOut(2000);
        var text_value = jQuery(this).parent().children('textarea#embed_code').val();
        var data = {
            action: 'master_response',
            value: text_value
        };
        jQuery.post(script_call.ajaxurl, data, function(response) {
            if (response) {
                jQuery('.embed_code_save').css({"display": "none"});
                jQuery('.embed_code_saved').css({"display": "block"});
            }
            else {
                alert('error');
            }
        });
    });
    jQuery('.submit_form').click(function(){
        var count = 0;
        var name = jQuery(this).parent().parent().parent().children('div#name_wraper').children().children('input#fgcf_form_name').val();
       var email = jQuery(this).parent().parent().parent().children('div#email_wraper').children().children('input#fgcf_form_email').val();
        var subject = jQuery(this).parent().parent().parent().children('div#subject_wraper').children().children('input#fgcf_form_subject').val();
        var message= jQuery(this).parent().parent().children().children('#fgcf_form_messages').val();
		 		
    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  var validate_email= regex.test(email);
  if(validate_email == false){ 
      count++;
   jQuery('input#fgcf_form_email').css({"border": "2px solid red"});
  }
  else{
jQuery('input#fgcf_form_email').css({"border": "solid 1px #09C"});
        }
  if(message == false){
      count++;
   jQuery('#fgcf_form_messages').css({"border": "2px solid red"});  
  }
  else{
   jQuery('#fgcf_form_messages').css({"border": "solid 1px #09C"});
        }
  if(name == false){
      count++;
    jQuery('input#fgcf_form_name').css({"border": "2px solid red"});  
  }
  else{
       jQuery('input#fgcf_form_name').css({"border": "solid 1px #09C"}); 
  }
    if(subject == false){
        count++;
    jQuery('input#fgcf_form_subject').css({"border": "2px solid red"});  
  }
    else{  
    jQuery('input#fgcf_form_subject').css({"border": "solid 1px #09C"});  
  }
  if(count == 0){
    document.getElementById("fgcf_form_outer_div").innerHTML = "<div id='display_message'><p> <b><h3>Your Message has been successfully sent</h3></b> </p> </div>";
  jQuery('#display_message').css({
      "height": "500px",
      "color": "black",
      "margin-left": "10px"
  });
     var submit_value = {
            action: 'master_response',
            contact_name: name,
            contact_email: email,
            contact_subject: subject,
            contact_message: message 
        }
	// alert(submit_value);
        jQuery.post(script_called.ajaxurl, submit_value, function(response){
            if(response){
             //alert(response); 
            }
            else{
                alert('error');
            }
        });
  }
  });
});