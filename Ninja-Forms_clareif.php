<?php
/**
 * Plugin Name: Ninja Forms - Clareif
 * Plugin URI: https://github.com/RGunning/ninja-forms_clareif
 * Description: Clareif opt-in/out.
 * Version: 1.0.0
 * Author: Richard Gunning, rjg70
 * Author URI: http://mcr.clare.cam.ac.uk/author/rjg70
 * License: GPL2
 */

 /*  Copyright 2015  Richard Gunning  (email : rjg70@cam.ac.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

global $clareif_version;
$clareif_version = '1.0.0';

function clareif_install () {
	global $wpdb;
	global $clareif_version;
	$installed_ver = get_option( "clareif_version" );
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	add_option( 'clareif_version', $clareif_version );
}
register_activation_hook( __FILE__, 'clareif_install' );

function clareif_updateform(){
 	//Declare $ninja_forms_processing as a global variable.
  	global $ninja_forms_processing;

  	//Get the user submitted value for the field with an ID of 3.
  	$user_id = $ninja_forms_processing->get_user_id();
 		
	//Get the form ID of the form being processed.
  	$form_id = $ninja_forms_processing->get_form_ID();
  	
  	//Is the submitted form a clareif form?
	if ($form_id==5) {
		//Has user already submitted? If so delete old submission
		$args = array(
			'form_id'   => $form_id,
			'user_ID'   => $user_id
			);
		$subs = Ninja_Forms()->subs()->get( $args );
		foreach ( $subs as $sub ) {
			$sub->delete();
		}
	}
}

add_action('ninja_forms_pre_process', 'clareif_updateform');
?>
