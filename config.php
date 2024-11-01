<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'WBLS_VERSION', '1.2.1' );
define( 'WBLS_PREFIX', 'wbls' );
define( 'WBLS_PRO', FALSE );
define( 'WBLS_DIR', dirname( __FILE__ ) );
define( 'WBLS_URL', plugins_url( plugin_basename( dirname( __FILE__ ) ) ) );
$wp_upload_dir = wp_upload_dir();
define( 'WBLS_UPLOAD_DIR', $wp_upload_dir[ 'basedir' ] . '/wbls-system/images' );
define( 'WBLS_UPLOAD_URL', $wp_upload_dir[ 'baseurl' ] . '/wbls-system/images' );
define( 'WBLS_DEACTIVATION_REST', 'https://whistleblowing-form.de/wp-json/custom/v1/receive-data/' );
