
<?php
if ( ! defined( 'ABSPATH' ) ) exit;
//Add SVG Upload capability
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
//Add SVG thumbnails
function fix_svg_thumb_display() {
  echo '<style>td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {width: 100% !important; height: auto !important;}table.media .column-title .media-icon img{width:100%;}</style>';
}
add_action('admin_head', 'fix_svg_thumb_display');
//Add options Page
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page('Center Options');
	
}

//Add custom footer widget
/**
 * Adds custom widget.
 */
class Footer_Widget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      'Footer_Widget', // Base ID
      __('Footer Content', 'text_domain'), // Name
      array( 'description' => __( 'All footer content.', 'text_domain' ), ) // Args
    );
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
    echo '<footer class="page-footer, white">';
		echo '<div class="container">';
    echo '<div class="row">';
	 echo '<div class="col s12 m5 push-m7">';
		echo get_field('edens_website ', 'widget_' . $args['widget_id']);
		echo '&nbsp;/&nbsp;';
		echo get_field('privacy_policy', 'widget_' . $args['widget_id']);
		echo '</div>';
		echo '<div class="col s12 m7 pull-m5">';
		echo get_field('copyright_title', 'widget_' . $args['widget_id']);
		echo '</br>';
		$address = get_field('address', 'widget_' . $args['widget_id']);
		echo $address['address'];
		echo '</div>';
	  echo '</div>';
	 echo '</div>';
    echo '</footer>';
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form( $instance ) {
    if ( isset($instance['title']) ) {
      $title = $instance['title'];
    }
    else {
      $title = __( 'New title', 'text_domain' );
    }
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <?php
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

    return $instance;
  }

} // class Footer_Widget

// register Footer_Widget widget
add_action( 'widgets_init', function(){
  register_widget( 'Footer_Widget' );
});