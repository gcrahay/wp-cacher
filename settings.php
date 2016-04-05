<?php

require_once plugin_dir_path( __FILE__ ) . 'walker.php';

function wpc_add_admin_menu(  ) {
        add_options_page( 'Wordpress Cacher', 'Wordpress Cacher', 'manage_options', 'wp_cacher', 'wpc_options_page' );
}


function wpc_settings_init(  ) {
        register_setting( 'pluginPage', 'wpc_cached_categories' );
        add_settings_section(
                'wpc_pluginPage_section',
                __( 'What to cache?', 'wp-cacher' ),
                'wpc_settings_section_callback',
                'pluginPage'
        );

        add_settings_field(
                'wpc_cached_categories',
                __( 'Categories to cache', 'wp-cacher' ),
                'wpc_cached_categories_render',
                'pluginPage',
                'wpc_pluginPage_section'
        );
}

function wpc_settings_run() {
	add_action( 'admin_menu', 'wpc_add_admin_menu' );
	add_action( 'admin_init', 'wpc_settings_init' );
}


function wpc_cached_categories_render(  ) {
        $walker = new Walker_Cached_Category;
        wp_category_checklist(0, 0, get_option('wpc_cached_categories'), false, $walker);
}


function wpc_settings_section_callback(  ) {

        echo __( 'You can define here the items to cache.', 'wordpress' );

}


function wpc_options_page(  ) {
        ?>
        <form action='options.php' method='post'>

                <h2>Wordpress Cacher</h2>

                <?php
                settings_fields( 'pluginPage' );
                do_settings_sections( 'pluginPage' );
                submit_button();
                ?>

        </form>
        <?php
}


?>
