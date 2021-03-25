<?php

function sanitize_faqs_field( $meta_value ) {
    foreach ( (array) $meta_value as $key => $value ) {
        if ( is_array($value) ) {
            $meta_value[$key] = sanitize_faqs_field( $value );
        }
        else {
            $meta_value[$key] = sanitize_text_field( $value );
        }
    }
  
    return $meta_value;
}