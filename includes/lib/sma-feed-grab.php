<?php
define('WP_USE_THEMES', false);
require('../../../../../wp-load.php');
if( get_field( 'sma_feed', $_GET["post_id"] ) ){
	sma_createSocialMedia( get_field( 'sma_feed', $_GET["post_id"] ), $_GET["layout"] );
}

?>
