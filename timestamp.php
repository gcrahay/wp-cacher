<?php

function wpc_update_timestamp() {
        update_option( '_wpc_manifest_timestamp', current_time( 'mysql' ) );
}

function wpc_timestamp_run() {
	// Attachments
	add_action( 'add_attachment', 'wpc_update_timestamp' );
	add_action( 'edit_attachment', 'wpc_update_timestamp' );
	add_action( 'delete_attachment', 'wpc_update_timestamp' );
	// Options
	add_action( 'added_option', 'wpc_update_timestamp' );
	add_action( 'deleted_option', 'wpc_update_timestamp' );
	// Plugins
	add_action( 'activated_plugin', 'wpc_update_timestamp' );
	add_action( 'deactivated_plugin', 'wpc_update_timestamp' );
	// Posts and pages
	add_action( 'save_post', 'wpc_update_timestamp' );
	add_action( 'deleted_post', 'wpc_update_timestamp' );
	add_action( 'trashed_post', 'wpc_update_timestamp' );
	// Themes
	add_action( 'after_switch_theme', 'wpc_update_timestamp' );
}
?>