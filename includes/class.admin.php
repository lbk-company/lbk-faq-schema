<?php

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) ) exit;

if ( !class_exists( 'lbkFAQs_Admin' ) ) {
    /**
     * Class lbkFAQs_Admin
     */
    final class lbkFAQs_Admin {
        /**
         * Setup plugin for admin use
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function __construct() {
            $this->hooks();
        }

        /**
         * Add the core admin hooks.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        private function hooks() {
            add_action( 'add_meta_boxes', array( $this, 'lbk_custom_faqs') );
            add_action( 'save_post', array( $this, 'lbk_custom_faq_save') );
        }

        /**
         * Add meta box custom faqs.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function lbk_custom_faqs() {
            add_meta_box(
                '_lbk-custom-faq',
                'Custom FAQs',
                array( $this, 'lbk_custom_faq_inner'),
                'post',
                'normal',
                'default'
            );
        }

        /**
         * Callback of add_meta_box in lbk_custom_faqs.
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function lbk_custom_faq_inner() {
            $post_id = get_the_ID();
        
            $custom_faqs = get_post_meta( $post_id, '_lbk_custom_faqs', true );
            if (!$custom_faqs) $custom_faqs = array();
        
            wp_nonce_field( 'lbk_custom_faqs_nonce'.$post_id, 'lbk_custom_faqs_nonce' );
            ?>
        
            <a href="#" class="button" id="add_new_faq_button">Add New</a>
            <table id="lbk_list_faqs" style="width:100%">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                <?php $c=0; ?>
                <?php if ($custom_faqs > 0) : ?>
                    <?php foreach($custom_faqs as $faq) : ?>
                        <tr id="faq-<?php echo $c ?>">
                            <td class="faqData">
                                <input name="lbk_faq_custom[<?php echo $c; ?>][question]" value="<?php echo $faq['question']; ?>" style="width:100%">
                            </td>
                            <td class="faqData">
                                <input name="lbk_faq_custom[<?php echo $c; ?>][answer]" value="<?php echo $faq['answer']; ?>" style="width:100%">
                            </td>
                            <td style="text-align:center;">
                                <a href="#" class="button" id="lbk_delete_faq" data-id="<?php echo $c; ?>">Delete</a>
                            </td>
                        </tr>
                        <?php $c++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
            
            <script type='text/javascript' src='<?php echo LBK_FAQ_URL.'js/admin.js' ?>' data-count='<?php echo $c; ?>' id='lbk-custom-faq-script'></script>
            <?php
        }

        /**
         * Add post meta after save post
         * 
         * @access private
         * @since 1.0
         * @static
         */
        public function lbk_custom_faq_save($post_id) {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
            
            if (!isset($_POST['lbk_custom_faqs_nonce']) || !wp_verify_nonce($_POST['lbk_custom_faqs_nonce'], 'lbk_custom_faqs_nonce'.$post_id)) {
                return;
            }
            
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        
            if (isset($_POST['lbk_faq_custom'])) {
                update_post_meta($post_id, '_lbk_custom_faqs', $_POST['lbk_faq_custom']);
            } else {
                delete_post_meta($post_id, '_lbk_custom_faqs');
            }
        }
    }

    new lbkFAQs_Admin();
}