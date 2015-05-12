<?php
/**
 * Plugin Name: cf7 Confirm Field
 * Description: Plugin allows to make sure that e.g. emails in two fields are the same
 * Version: 0.0.1
 * Author: Tomasz Lewiński
 * Author URI: http://mdoff.net
 * License: GPL2
 */

function wpcf7_text_confirm_field ( $result, $tag ) {
    $tag = new WPCF7_Shortcode( $tag );
    $name = $tag->name;
    if( preg_match('/_confirm$/', $name) ) {
        $name2 = preg_replace('/_confirm$/','',$name);
        if ( isset($_POST[$name2]) && $_POST[$name] !== $_POST[$name2] ) {
            $result->invalidate( $tag, wpcf7_get_message('confirm_field_is_not_valid') );
        }
    }
    return $result;
}

function wpcf7_confirm_messages( $messages ) {
    return array_merge( $messages, array('confirm_field_is_not_valid' => array(
        'description'
        => __( "Message when fields <field_name> and <field_name>_confirm are not the same.", 'cf-confirm-field' ),
        'default'
        => __( 'Fields are not the same', 'cf-confirm-field' )
    )));
}
if ( defined( 'WPCF7_PLUGIN' ) ) {
	add_filter( 'wpcf7_validate_email', 'wpcf7_text_confirm_field', 10, 2 );
	add_filter('wpcf7_messages','wpcf7_confirm_messages');
}