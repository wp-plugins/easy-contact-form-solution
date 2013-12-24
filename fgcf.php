<?php
class Fgcfc {
    public static $table_name;
    /**
     * Stores the plugin version.
     *
     * @var string
     * @access private
     */
    public function __construct() {
        global $wpdb;
        Fgcfc::$table_name = $wpdb->prefix . "fgcfc_form_table";
    }
    /**
     * Create form
     *
     * @var string
     * @access private
     */
    static function fgcfc_show_form() {
        $close_image_path = plugins_url('/image/close.png', __FILE__);
        ?>
        <div class="fgcf_contact_form" id="fgcf_content_wraper">
            <div id="fg_close" ><img class="close_popup" src="<?php echo $close_image_path; ?>"/></div><br />
            <div class="fgcf_form_heading"><h1 class="fgcf_heading">Contact Form</h1></div>
            <div class="fgcf_form_outer_div" id="fgcf_form_outer_div">
                <form action="" method="post">
                    <div id="name_wraper" class="form_fields_wraper">
                        <span class="fgcf_form" id="form_name">
                            <div for="fgcf_form_name" id="fgcf_form_name">  Name </div></br>
                            <input type="text" name="fgcf_form_name" id="fgcf_form_name" class="fgcf_input_area" value="" />
                        </span>
                    </div>
                    <div id="email_wraper" class="form_fields_wraper">
                        <span class="fgcf_form" id="fgcf_form_email">
                            <div for="fgcf_form_email" id="fgcf_form_email"> Email</div></br>
                            <input type="text" name="fgcf_form_email" id="fgcf_form_email" class="fgcf_input_area" value="" />
                        </span>
                    </div>
                    <div id="subject_wraper" class="form_fields_wraper">
                        <span class="fgcf_form" id="fgcf_form_subject">
                            <div for="fgcf_form_subject" id="fgcf_form_subject">Subject</div></br>
                            <input type="text" name="fgcf_form_subject" id="fgcf_form_subject" class="fgcf_input_area" value="" />
                        </span>
                    </div>
                    <div id="message_wraper" class="form_fields_wraper">
                        <span class="fgcf_form" id="fgcf_form_message">
                            <div for="fgcf_form_message" id="fgcf_form_message"> Message</div></br>
                            <textarea name="fgcf_form_message" id="fgcf_form_messages" class="fgcf_text_area"  cols="35" rows="5" value="" ></textarea>
                        </span>
                        <p id="submit_wrapper">
                            <input type="button" name="send" id="submit_form" value="Send" class="submit_form"/>
                        </p>
                        <p class="clear_both"></p>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    /**
     * Stores entries in database
     *
     * @var string
     * @access private
     */
    function fgcfc_insert_data() {
        function fgcfc_text_ajax_process_request_submit() {
            global $wpdb;
             $sanitized_name = sanitize_text_field($_POST['contact_name']);
            $sanitized_email = sanitize_email($_POST['contact_email']);
            $sanitized_subject = sanitize_text_field($_POST['contact_subject']); 
            $sanitized_message = sanitize_text_field($_POST['contact_message']);
			$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				$headers .= "From: \"$sanitized_name\" <$sanitized_email>\n";
				$headers .= "Return-Path: <" . mysql_real_escape_string(trim($sanitized_email)) . ">\n";
				$headers .= "Reply-To: \"" . mysql_real_escape_string(trim($sanitized_name)) . "\" <" . mysql_real_escape_string(trim($gcf_email)) . ">\n";
			
			$admin_email = get_settings('admin_email'); 			
			@wp_mail($admin_email , $sanitized_subject, $sanitized_message, $headers ); 			
            $data = array(
                'user_name' => $sanitized_name,
                'user_email' => $sanitized_email ,
                'user_subject' => $sanitized_subject,
                'user_message' => $sanitized_message
            );
            $wpdb->insert(Fgcfc::$table_name, $data);
        }

        add_action('wp_ajax_master_response', 'fgcfc_text_ajax_process_request_submit');
        add_action('wp_ajax_nopriv_master_response', 'fgcfc_text_ajax_process_request_submit');
    }
    /**
     * Show data from table
     *
     * @var string
     * @access private
     */
    function fgcfc_show_data() {
        $path = plugins_url('/image/edit_icon.png', __FILE__);
        $img_path = plugins_url('/image/delete_icon.jpg', __FILE__);
		$image_path = plugins_url('/image/reply-image.jpg', __FILE__);
        if (isset($_GET["page_count"])) {
            $page = $_GET["page_count"];
        } else {
            $page = 1;
        }
        $start_from = ($page - 1) * 10;
        global $wpdb;
        $query = $wpdb->get_results("SELECT * FROM " . Fgcfc::$table_name . " LIMIT $start_from, 10");
		
        ?>
        <table>
            <thead>
                <tr class="display_header">
                    <th width="183px">Name</th>
                    <th width="273px">Email</th>
                    <th width="182px">Subject</th>
                    <th width="375px">Message</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
        <?php
        foreach ($query as $key) {
            ?>
                <tr class="fgcf_entries">
                    <td class="fgcf_name"><?php echo $key->user_name; ?></td> &nbsp;
                    <td class="fgcf_email"><?php echo $key->user_email; ?></td> &nbsp;
                    <td class="fgcf_subject"><?php echo $key->user_subject; ?></td> &nbsp;    
                    <td class="fgcf_message"><?php echo $key->user_message; ?></td> &nbsp;
                    <td class="fgcf_action_icon"><div class="update_entry"><a class="edit_entry" id="edit_entry" href="javascript:void(0);" entry_id="<?php echo $key->id; ?>"><img src=<?php echo $path; ?> alt="edit_icon" ></a></div></td>&nbsp; 
                    <td><a class="delete_entry" delete_id="<?php echo $key->id; ?>" ><img src=<?php echo $img_path; ?> alt="delete_icon" ></a></td> &nbsp;
                </tr>
                <?php
            }
            echo "</table>";
            $sql = $wpdb->get_results("SELECT  COUNT(id) as c FROM " . Fgcfc::$table_name);
            foreach ($sql as $row) {
                $total_records = $row->c;
            }
            $total_pages = ceil($total_records / 10);
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='admin.php?page=fgcf_page&page_count=" . $i . "'>" . $i . "</a> ";
            }
        }
        /**
         * Delete data from table
         *
         * @var string
         * @access private
         */
        function fgcfc_delete_data($id) {
            global $wpdb;
            $query = $wpdb->get_results("delete from " . Fgcfc::$table_name . " where id= $id");
            return true;
        }
        /**
         * update data in table
         *
         * @var string
         * @access private
         */
        function fgcfc_update_data($id) {
            echo "";
            global $wpdb;
            if (isset($_POST['update'])) {
                $name = $_POST['fgcf-form_name'];
                $email = $_POST['fgcf-form_email'];
                $subject = $_POST['fgcf-form_subject'];
                $message = $_POST['fgcf-form_message'];
                $wpdb->update(
                        Fgcfc::$table_name, array(
                    'user_name' => $name,
                    'user_email' => $email,
                    'user_subject' => $subject,
                    'user_message' => $message
                        ), array('ID' => $id), array(
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                        ), array('%d')
                );
            }
            return true;
        }
         /**
         * embeded code
         *
         * @var string
         * @access private
         */
        function fgcfc_embeded_code() {
            global $wpdb;
            $result = get_option('fg_embed_code');
            echo stripslashes($result);
        }
        /**
         * update form
         *
         * @var string
         * @access private
         */
        function fgcfc_update_form_entry() {
            ?>
            <div class="fgcf_dialog_form" id="fgcf_dialog_form">

                <form name="update_form" method="post">
                    <div class="form_id" id="form_id">
                        <input type="hidden" name="fgcf_form_id" id="fgcf_form_id" value="" /> 
                    </div>
                    <div id="fgcf-name_wraper" class="fgcf-name_wraper">
                        <p class="fgcf-form_name" id="fgcf-form_name">
                        <div class="fgcf-form_label"> <label for="form_name"> Name:</label></div>
                        <input type="text" name="fgcf-form_name" id="fgcf-form_name" value="" />
                        </p>
                    </div>
                    <div id="email_wraper" class="email_wraper">
                        <p class="fgcf-form_email" id="fgcf-form_email">
                        <div class="fgcf-form_label"> <label for="fgcf-form_email"> Email:</label> </div>
                        <input type="text" name="fgcf-form_email" id="fgcf-form_email" value="" />
                        </p>
                    </div>
                    <div id="subject_wraper" class="subject_wraper">
                        <p class="fgcf-form_subject" id="fgcf-form_subject">
                        <div class="fgcf-form_label">   <label for="fgcf-form_subject">Subject:</label></div>
                        <input type="text" name="fgcf-form_subject" id="fgcf-form_subject" value="" />
                        </p>
                    </div>
                    <div id="message_wraper" class="message_wraper">
                        <p class="fgcf-form_message" id="fgcf-form_message">
                        <div class="fgcf-form_label"> <label for="fgcf-form_message"> Message:</label> </div>
                        <textarea name="fgcf-form_message" id="fgcf-form_message" cols="45" rows="5" value=""></textarea>
                        </p>
                    </div>
                    <div class="submit_div">
                        <p id="submit_wrapper">
                            <input type="submit" name="update" class="form_update_entry" value="update" />
                        </p>					
                        <p class="clear_both"></p>		
                    </div>
                </form>
            </div>
        <?php
    }		
}
new Fgcfc();
?>