<?php
add_action('admin_menu', 'fgcfc_menu_page');
function fgcfc_menu_page() {
    add_menu_page('Fgcf', 'CF Contact Form', 'manage_options', 'fgcf_page', 'Fgcfc_setting_page', '', '99');
}
function Fgcfc_setting_page() {
    $url = plugins_url();
    ?>
    <div class="whole_div" id="whole_div">
        <ul id="tabs">
            <li class="fgcf_contact_form_content" id="fgcf_contact_form_content">Contact Form </li>
            <li class="goto_fg_advance_form" id="goto_fg_advance_form" cursor="pointer">Advance Form Builder</li>
            <li class="embed_advance_form" id="embed_advance_form" cursor="pointer">Embed Code</li>
        </ul>
        <div id="container" class="iframe_div" >
            <iframe src="http://www.formget.com/app" name="iframe" id="iframebox" width="95%" height="700px">
            </iframe>
        </div>
        <div id="embed_advance_form_div" class="embed_advance_form_div" >
            <p> <h3>Create your form and save it, after saving you will get an embed code.</br>Paste here your iframe and tabbed code by copying it, and then click on save button. </h3> </p>
                <h1>Embed Code</h1>
                <textarea rows="10" cols="125" name="embed_code" id="embed_code"> <?php echo Fgcfc::fgcfc_embeded_code() ?> </textarea></br>
                <button class="embed_code_save" id="embed_code_save"> save </button>
                <div class="embed_code_saved" id="embed_code_saved" style='display:none'>Thankyou, Enjoy your form</div>
                <div id="dvLoading" style='display:none'></div>           
        </div>
        <div class="entries_content" id="entries_content" >
            <p>
            <h2> You can also try our Advance Contact Form builder <a href="http://www.formget.com/app" target="_blank"> Try Now </a></h2>
            Just drag and drop your fields and create your custom form.
            </p></br>
            <h1>Existing Entries:</h1>           
            <?php
            Fgcfc::fgcfc_show_data();
            echo "</div>";
            echo "</div>";
            ?>
            <div id="update_div"><img id="close_popup_img" src="<?php echo plugins_url("image/close_popup.png", __FILE__); ?>" /><?php Fgcfc::fgcfc_update_form_entry(); ?></div>
            <?php		
        }
      
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