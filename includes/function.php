<?php

if ( !function_exists('lbk_sanitize_faqs_field') ) {
    function lbk_sanitize_faqs_field( $meta_value ) {
        foreach ( (array) $meta_value as $key => $value ) {
            if ( is_array($value) ) {
                $meta_value[$key] = lbk_sanitize_faqs_field( $value );
            }
            else {
                if ( $key == 'answer' ) $meta_value[$key] = sanitize_textarea_field( $value );
                $meta_value[$key] = sanitize_text_field( $value );
            }
        }
      
        return $meta_value;
    }
}