<?php
function wawunahisp_create_menu() {
    add_menu_page('Limit Devices', 'Limit Devices', 'administrator', __FILE__, 'wawunahisp_settings_page' , plugins_url('/images/icon.png', __FILE__) );

    add_submenu_page(__FILE__, 'Limit Devices form', 'Limit Devices form', 'administrator', 'Limit Devices form', 'wawunahisp_pnl_form_settings_page');
    add_action( 'admin_init', 'register_pnl_form_wawunahisp_settings' );
}