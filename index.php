<?php
/*
  Plugin Name: Easy Contact Form Solution
  Plugin URI: http://www.formget.com
  Description: Extremely simple Contact Form
  Version: 1.0
  Author: FormGet
  Author URI: http://www.formget.com
 */
include_once('fgcf.php');
include_once('response.php');
//include style sheet
function fgcfc_add_style() {
    wp_enqueue_style('form_style', plugins_url('css/form_style.css', __FILE__));
    wp_enqueue_style('form_style_sheet', plugins_url('css/style.css', __FILE__));
}
add_action("init", "fgcfc_add_style");
//include script
function fgcfc_scripts() {
    wp_enqueue_script('script_popup', plugins_url('js/popup.js', __FILE__), array('jquery-ui-dialog'));
    wp_enqueue_script('tab_select_script', plugins_url('js/tab_select.js', __FILE__), array('jquery'));
}
add_action('init', 'fgcfc_scripts');
//ajax
function fg_scripts() {
    wp_enqueue_script('embeded_script', plugins_url('js/ajax.js', __FILE__), array('jquery'));
    wp_localize_script('embeded_script', 'script_call', array('ajaxurl' => admin_url('admin-ajax.php')));
    wp_localize_script('embeded_script', 'script_called', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('init', 'fg_scripts');
register_activation_hook(__FILE__, 'Fgcfc::fgcfc_table_install');
if (!is_admin()) {
    function fgcfc_show_footer_strip() {
        global $wpdb;
        $fg_iframe_form = get_option('fg_embed_code');
        if (!$fg_iframe_form == null) {
                 $string = " window.onload";
    $pos = strpos($fg_iframe_form, $string);
    if ($pos == false) {
         $close_image_path = plugins_url('/image/close.png', __FILE__);
        ?>
        <div class="contac_us_img" style="display:none"><img src="<?php echo plugins_url('/image/contact-button.png', __FILE__); ?>" > </div>
            <div id="fgcf-box-popup" style="display:none">
                <div id="fg_form_show"> <div class="formget_form"><div id="fg_close" ><img class="close_popup" src="<?php echo $close_image_path; ?>"/></div><?php echo stripslashes($fg_iframe_form); ?></div><p>Powered by <a herf="formget.com">FormGet</a> </p></div>
            </div>
            <?php
    } else {
       function tabbed_embeded_code() {
            global $wpdb;
            $result = get_option('fg_embed_code');
            echo stripslashes($result);
        }
        add_action('wp_head', tabbed_embeded_code);
    }           
        } else {
            ?>
				<div class="contac_us_img" style="display:none"><img src="<?php echo plugins_url('/image/contact-button.png', __FILE__); ?>" > </div>
            <div id="fgcf-box-popup"  style="display:none">
                <div id="fg_form_show"><div class="fgcf_form"> <?php echo Fgcfc::fgcfc_show_form(); ?></div><p id="link_to_formget">Powered by  <a href="http://www.formget.com/" target="_blank"> FormGet </a></p></div>
            </div>
            <?php
        }
    }
    add_action('wp_enqueue_scripts', 'fgcfc_show_footer_strip');
}
?>