<?php
add_action('admin_menu', 'fgcfc_menu_page');
function fgcfc_menu_page() {
    add_menu_page('Fgcf', 'CF Contact Form', 'manage_options', 'fgcf_page', 'Fgcfc_setting_page', '', '99');
}
function Fgcfc_setting_page() {
    $url = plugins_url();
    ?>
	<div class="fgcf_notice_division">
         Collect leads and payment with our advance contact form builder <a class="try_formget" href="http://www.formget.com/app" target="_blank"> Build Your Form Now! </a>    
    </div>
    <div class="whole_div" id="whole_div">
        <ul id="tabs">
            <li class="fgcf_contact_form_content menutab" id="fgcf_contact_form_content">Contact Form </li>
            <li class="goto_fg_advance_form  menutab" id="goto_fg_advance_form" cursor="pointer">Advance Form Builder</li>
            <li class="embed_advance_form  menutab" id="embed_advance_form" cursor="pointer">Embed Code</li>
			<li class="example_advance_form  menutab" id="example_advance_form" cursor="pointer">Form Examples</li>
        </ul>
        <div id="container" class="iframe_div" >
            <iframe src="http://www.formget.com/app" name="iframe" id="iframebox" width="99%" height="700px">
            </iframe>
        </div>
		<div id="example_container" class="example_iframe_div" >
            <iframe src="http://www.formget.com/form-examples/" name="iframe" id="example_iframe" width="99%" height="700px">
            </iframe>
        </div>
        <div id="embed_advance_form_div" class="embed_advance_form_div" >
            <div class="embed_section"><p> <h3>Create your form and save it, after saving you will get an embed code.</br>Paste here your iframe and tabbed code by copying it, and then click on save button. </h3> </p>
                <h1>Embed Code</h1>
                <textarea rows="10" cols="125" name="embed_code" id="embed_code"> <?php echo Fgcfc::fgcfc_embeded_code() ?> </textarea></br>
                <button class="embed_code_save" id="embed_code_save"> save </button>
                <div class="embed_code_saved" id="embed_code_saved" style='display:none'>Thankyou, Enjoy your form</div>
                <div id="dvLoading" style='display:none'></div> </div> 
               <div class="support_feedback"><h3> Support and Review </h3>
			   <span class="fg_support">You can find support on formget.com <br> <a href="http://www.formget.com/contact-us/" target="__blank">Need Help?</a></span><br><br>
       			  <span class="fg_feedback"> Your feedback and review both are important, take a moment and share your thoughts. <br><a href="http://wordpress.org/support/view/plugin-reviews/easy-contact-form-solution" target="_-blank">rate this plugin.</a></span>
			   <br><br>
			   </div>			
        </div>
        <div class="entries_content" id="entries_content" >
            <h1 style="margin-left: 10px;">Existing Entries:</h1>           
            <?php
            Fgcfc::fgcfc_show_data();
            echo "</div>";  ?>
            </div>		
            <div id="update_div"><img id="close_popup_img" src="<?php echo plugins_url("image/close_popup.png", __FILE__); ?>" /><?php Fgcfc::fgcfc_update_form_entry(); ?></div>
            <?php		
        }
		 Fgcfc::fgcfc_insert_data();
      
// Delete record from the Database
        if (isset($_GET['fgcf_del'])) {
            $id = $_GET['fgcf_del'];
            Fgcfc::fgcfc_delete_data($id);
			 
        }
        // update record from the Database
        if (isset($_POST['fgcf_form_id'])) {
            $id = $_POST['fgcf_form_id'];
            $result = Fgcfc::fgcfc_update_data($id);
            if ($result == true) {
				 flush(); // Flush the buffer
                  ob_flush();
                $site_url = $_SERVER['REQUEST_URI'];  
				echo'<script> window.location="' . $site_url .'" </script> ';
                // header('Location:$site_url ');
                //exist;			
            }
        }
        function fgcfc_text_ajax_process_request() {
            $text_value = $_POST['value'];
            update_option('fg_embed_code', $text_value);
        }
        add_action('wp_ajax_master_response', 'fgcfc_text_ajax_process_request');
        add_action('wp_ajax_nopriv_master_response', 'fgcfc_text_ajax_process_request');
?>