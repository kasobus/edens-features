<?php
if ( ! defined( 'ABSPATH' ) ) exit;
// Register the script
function js_enqueue_scripts() {
wp_register_script( 'smajs', plugin_dir_url( __FILE__ ) . 'js/sma.js', array( 'jquery' ) );
// Localize the script with new data
$translation_array = array(
	'plugin_url' => plugin_dir_url( __FILE__ ),
    'jquery',
);
wp_localize_script( 'smajs', 'sma', $translation_array );
    wp_enqueue_script( 'smajs' );
}
add_action( 'wp_enqueue_scripts', 'js_enqueue_scripts' );

function scripts() {
        wp_enqueue_script(
		'modernizr',
		plugin_dir_url( __FILE__ ) . '/GridGallery/js/modernizr.custom.js',
		array( 'jquery' )
	);
		wp_enqueue_script(
		'images_loaded',
		plugin_dir_url( __FILE__ ) . '/GridGallery/js/imagesloaded.pkgd.min.js',
		array( 'jquery' )
	);
        wp_enqueue_script(
		'gridmasonry',
		plugin_dir_url( __FILE__ ) . '/GridGallery/js/masonry.pkgd.min.js',
		array( 'jquery' )
	);
		    wp_enqueue_script(
		'classie',
		plugin_dir_url( __FILE__ ) . '/GridGallery/js/classie.js',
		array( 'jquery' )
	);
				wp_enqueue_script(
		'grid_gallery',
		plugin_dir_url( __FILE__ ) . '/GridGallery/js/cbpGridGallery.js',
		array( 'modernizr' )
	);
    
    wp_enqueue_style( 'cbdGridGallery', plugin_dir_url( __FILE__ ) . '/GridGallery/css/cbdGridGallery.css' ); //our stylesheet

}
    add_action( 'wp_enqueue_scripts', 'scripts' );

    
// SMA Shortcode Snippet for Page Templates
    // Extended subscription function with subscription type variable
function get_sma( $atts ){
     global $post;
	extract(shortcode_atts(array('id' => ''), $atts));
    // set page id to either the id attr which defaults to one.
    $page_id = $id;
    $page_data = get_page( $page_id ); 
	
			// data-layout = $layout
				if(is_single()){
							$layout = get_post_type(); //Post = Post type
				} else { 
				$layout = $post->post_name; //Page = Page slug
				}
							ob_start();
							echo '<section class="latest-buzz row retailer" data-postid="'.$post->ID.'" data-layout="'.$layout.'"></section>';
							$sma = ob_get_clean();
							return $sma;
			}
add_shortcode( 'get_sma', 'get_sma' );


// create social media feed
function sma_grabJson($sma_query){
	// Grab Endpoint via CURL
	$sma_decoded_query = htmlspecialchars_decode($sma_query); // Wordpress outputs text with & as html encoded, this reverses that for good URLs.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $sma_decoded_query);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: charset=utf-8'));
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	$jsonData = curl_exec($ch);
	if (false === $jsonData) {
	  throw new Exception("Error: _makeCall() - cURL error: " . curl_error($ch));
	}
	curl_close($ch);
		return json_decode($jsonData, true);
}
/* SOCIAL MEDIA AGGREGATOR */
function sma_createSocialMedia($endpoint, $sma_page_type){
	$returned_json = sma_grabJson( $endpoint );
	if( !empty( $returned_json ) && $returned_json != null ){
    $color = get_option('sma_color_picker');?>
	<style>
		.grid li:hover .overlay {
			background: <?php echo $color;
			?>;
		}
		
		.latest-buzz figure:hover .overlay,
		.event-gallery figure:hover .overlay {
			background: <?php echo $color;
			?>;
			opacity: 1;
		}
		
		.latest-buzz .grid-gallery>.grid-wrap figure {
			background-color: <?php echo $color;
			?>;
		}
	</style>
	<?php 
		$total_media_posts = 3; //Start count at 0. Ex. 0,1,2,3
	 // Override how many social posts.
		$id = $_GET["post_id"];
	 if(get_field('social_media_posts',$id)) {
		$total_media_posts = get_field('social_media_posts', $id) - 1;
	 }
	 	echo '<div id="grid-gallery" class="grid-gallery">'.
		'<section class="grid-wrap">'.
		'<ul class="grid">'.
		'<li class="grid-sizer"></li>';
		foreach($returned_json as $key => $smp){
			if( $key > $total_media_posts ) break;
			$image_exists = ($smp["img"] == "" ? "text" : ($smp["message"] == "" ? "image" : "image-text"));
			$image_style = ($smp["img"] == "" ? "" : "background-image: url('" . $smp["img"] . "')");
			$screen_name = ( $smp["service"] == "twitter" ? "@" . $smp["screen_name"] : ( $smp["service"] == "instagram" ? "@" . $smp["screen_name"] : $smp["screen_name"] ) );
			
			$smp["message"] = iconv("UTF-8","ISO-8859-1",$smp["message"]);
			echo '<li data-timestamp="' . $smp["timestamp"] . '" class="' . $smp["service"] . ' ' . $image_exists . '">'.
						'<figure class="' . $image_exists . '" style="' .  $image_style . '">';			// Gallery is off, give link to social media
		if (!get_option('sma_grid-gallery-checkbox')) {
            echo '<a href="'.$smp["user_url"].'" style="position:absolute;top:0;bottom:0;left:0;right:0;z-index: 100;"></a>';
                                                      }
								echo '<span class="overlay wrap-center-vertical">' .
									'<span class="center-vertical">';
			if( $smp["message"] ){
									$msgLength = strlen( $smp["message"] );
									$clippedMsg = substr( $smp["message"], 0, 80 );
									if( $msgLength > 80 ) { 
										$lastSpace = strrpos( $clippedMsg, ' ' );
										$clippedMsg = substr( $smp["message"], 0, $lastSpace );
									}

									$clippedMsgArray = explode(" ", $clippedMsg);
									$clippedSpaceMsg = "";

									// Things like URLS can be long, if a word is too long it will essentially break the positioning of all text within the output box. This breaks it so it can be displayed neatly.
									foreach( $clippedMsgArray as $msgWord){
										if ( strlen($msgWord) > 18 ){
											//$msgWord = substr_replace($msgWord, " ", 18, 0);
											$msgWord = '<span class="break-word">' . $msgWord . '</span>';
										}
										$clippedSpaceMsg .= $msgWord . " ";
									}
									$clippedSpaceMsg = substr( $clippedSpaceMsg, 0, -1 );
									echo $clippedSpaceMsg;
									if( $msgLength > 80 ) echo ' &hellip;';
								}
								echo '</span>' .
							'</span>' .
									'<img src="'.plugin_dir_url( __FILE__ ).'/GridGallery/img/social-feed/container.png">' .
						'<figcaption>';
						echo '<i class="fa fa-'.$smp["service"] . ' fa-2x"></i>' .
						'<strong>' . $screen_name . '</strong><br/>' .
						'<time>' . $smp["timestamp"] . '</time>' .
					'</figcaption>' .
				'</figure>' .
			'</li>';
		}
		echo '</ul>' .
		'</section>';

		if (get_option('sma_grid-gallery-checkbox')) {
            
		// SLIDE SHOW DETAILS
		echo '<section class="slideshow">'.
		'<ul>';
		foreach($returned_json as $key => $smp){
			if( $key > $total_media_posts ) break;
			$image_exists = ($smp["img"] == "" ? "text" : ($smp["message"] == "" ? "image" : "image-text"));
			$image_style = ($smp["img"] == "" ? "" : "background-image: url('" . $smp["img"] . "')");
			$screen_name = ( $smp["service"] == "twitter" ? "@" . $smp["screen_name"] : ( $smp["service"] == "instagram" ? "@" . $smp["screen_name"] : $smp["screen_name"] ) );
			
			$smp["message"] = iconv("UTF-8","ISO-8859-1",$smp["message"]);
			echo '<li data-timestamp="' . $smp["timestamp"] . '" class="' . $smp["service"] . '">' .
						'<figure>' .
				'<figcaption>';
                echo '<a href="'.$smp["user_url"].'"><h1><i class="fa fa-'.$smp["service"].'"></i>'.$screen_name.'</h1></a>';
            if( $smp["message"] ){
									$msgLength = strlen( $smp["message"] );
									$clippedMsg = substr( $smp["message"], 0, 500 );
									if( $msgLength > 500 ) { 
										$lastSpace = strrpos( $clippedMsg, ' ' );
										$clippedMsg = substr( $smp["message"], 0, $lastSpace );
									}

									$clippedMsgArray = explode(" ", $clippedMsg);
									$clippedSpaceMsg = "";

									// Things like URLS can be long, if a word is too long it will essentially break the positioning of all text within the output box. This breaks it so it can be displayed neatly.
									foreach( $clippedMsgArray as $msgWord){
										if ( strlen($msgWord) > 18 ){
											//$msgWord = substr_replace($msgWord, " ", 18, 0);
											$msgWord = '<span class="break-word">' . $msgWord . '</span>';
										}
										$clippedSpaceMsg .= $msgWord . " ";
									}
									$clippedSpaceMsg = substr( $clippedSpaceMsg, 0, -1 );
									echo $clippedSpaceMsg;
									if( $msgLength > 500 ) echo ' &hellip;';
								}
						echo '</figcaption>';
								if ( $smp["img"] ){
								echo '<img src="' .$smp["img"].'" style="' . $image_style . '">';
								}
								echo '</figure>' .
			'</li>';
		}
	
				echo '<nav class="transparent">' .
						'<span class="icon nav-prev"></span>' .
						'<span class="icon nav-next"></span>' .
						'<span class="icon nav-close"></span>' .
					'</nav>' .
					'<div class="info-keys icon">Navigate with arrow keys</div>' .
                    '</ul>'; }
					echo '</section>' .
					'</div>';
					if (get_option('sma_grid-gallery-checkbox')) {
                        echo '<script>new CBPGridGallery( document.getElementById( "grid-gallery" ) );</script>';
                    }

	}
	
}