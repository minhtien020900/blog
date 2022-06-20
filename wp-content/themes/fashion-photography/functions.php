<?php
/**
 * Fashion Photography functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fashion Photography
 */

include get_theme_file_path( 'vendor/wptrt/autoload/src/Fashion_Photography_Loader.php' );

$Fashion_Photography_Loader = new \WPTRT\Autoload\Fashion_Photography_Loader();

$Fashion_Photography_Loader->fashion_photography_add( 'WPTRT\\Customize\\Section', get_theme_file_path( 'vendor/wptrt/customize-section-button/src' ) );

$Fashion_Photography_Loader->fashion_photography_register();

if ( ! function_exists( 'fashion_photography_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function fashion_photography_setup() {

		add_theme_support( 'woocommerce' );
		add_theme_support( "responsive-embeds" );
		add_theme_support( "align-wide" );
		add_theme_support( "wp-block-styles" );
		
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

        add_image_size('fashion-photography-featured-header-image', 2000, 660, true);

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary','fashion-photography' ),
	        'footer'=> esc_html__( 'Footer Menu','fashion-photography' ),
        ) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'fashion_photography_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 50,
			'width'       => 50,
			'flex-width'  => true,
		) );

		add_editor_style( array( '/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'fashion_photography_setup' );

/**
 * Enqueue S Header.
 */
function fashion_photography_sticky_header() {

  $fashion_photography_sticky_header = get_theme_mod('fashion_photography_sticky_header');

  $fashion_photography_custom_style= "";

  if($fashion_photography_sticky_header != true){

    $fashion_photography_custom_style .='.stick_header{';

      $fashion_photography_custom_style .='position: static;';
      
    $fashion_photography_custom_style .='}';
  } 

  wp_add_inline_style( 'fashion-photography-style',$fashion_photography_custom_style );

}
add_action( 'wp_enqueue_scripts', 'fashion_photography_sticky_header' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fashion_photography_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fashion_photography_content_width', 1170 );
}
add_action( 'after_setup_theme', 'fashion_photography_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fashion_photography_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'fashion-photography' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'fashion-photography' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'fashion_photography_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fashion_photography_scripts() {

	wp_enqueue_style('fashion-photography-font', fashion_photography_font_url(), array());

	wp_enqueue_style( 'fashion-photography-block-editor-style', get_theme_file_uri('/assets/css/block-editor-style.css') );

	// load bootstrap css
    wp_enqueue_style( 'flatly-css', esc_url(get_template_directory_uri()) . '/assets/css/flatly.css');

	wp_enqueue_style( 'fashion-photography-style', get_stylesheet_uri() );

    wp_style_add_data('fashion-photography-style', 'rtl', 'replace');

    $fashion_photography_inline_style= "";

    $fashion_photography_post_slider = get_theme_mod('fashion_photography_post_section');
    if( $fashion_photography_post_slider != "0" ){
    	$fashion_photography_inline_style .='#content-section{';
			$fashion_photography_inline_style .='margin-top:-20em; padding-top: 18em;';
		$fashion_photography_inline_style .='} ';
    }

    wp_add_inline_style( 'fashion-photography-style',$fashion_photography_inline_style );

	// fontawesome
	wp_enqueue_style( 'fontawesome-style', esc_url(get_template_directory_uri()).'/assets/css/fontawesome/css/all.css' );

    wp_enqueue_script('fashion-photography-theme-js', esc_url(get_template_directory_uri()) . '/assets/js/theme-script.js', array('jquery'), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fashion_photography_scripts' );

/**
 * Enqueue theme color style.
 */
function fashion_photography_theme_color() {

    $theme_color_css = '';
    $fashion_photography_theme_color = get_theme_mod('fashion_photography_theme_color');
    $fashion_photography_preloader_bg_color = get_theme_mod('fashion_photography_preloader_bg_color');
    $fashion_photography_preloader_dot_1_color = get_theme_mod('fashion_photography_preloader_dot_1_color');
    $fashion_photography_preloader_dot_2_color = get_theme_mod('fashion_photography_preloader_dot_2_color');

    if(get_theme_mod('fashion_photography_preloader_bg_color') == '') {
		$fashion_photography_preloader_bg_color = '#000';
	}
	if(get_theme_mod('fashion_photography_preloader_dot_1_color') == '') {
		$fashion_photography_preloader_dot_1_color = '#fff';
	}
	if(get_theme_mod('fashion_photography_preloader_dot_2_color') == '') {
		$fashion_photography_preloader_dot_2_color = '#d66060';
	}

	$theme_color_css = '
		.sidebar h5,.main-navigation .sub-menu > li > a:hover, .main-navigation .sub-menu > li > a:focus,.main-navigation .sub-menu,#button,#colophon,.sidebar input[type="submit"], .sidebar button[type="submit"],.rightsidenav .rightclosebtn i,.serach_inner [type="submit"],.pro-button a:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.pro-button a, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce .woocommerce-ordering select,.wp-block-button__link,.comment-respond input#submit,.woocommerce-account .woocommerce-MyAccount-navigation ul li,.post-navigation .nav-previous a:hover, .post-navigation .nav-next a:hover, .posts-navigation .nav-previous a:hover, .posts-navigation .nav-next a:hover,.readmore a,.toggle-nav i{
			background: '.esc_attr($fashion_photography_theme_color).';
		}
		a,.article-box a,.sidebar ul li a:hover,.widget a:hover, .widget a:focus,.social-link i:hover{
			color: '.esc_attr($fashion_photography_theme_color).';
		}
		.wp-block-pullquote,.wp-block-quote, .wp-block-quote:not(.is-large):not(.is-style-large), .wp-block-pullquote,.post-navigation .nav-previous a:hover, .post-navigation .nav-next a:hover, .posts-navigation .nav-previous a:hover, .posts-navigation .nav-next a:hover{
			border-color: '.esc_attr($fashion_photography_theme_color).';
		}
		.loading{
			background-color: '.esc_attr($fashion_photography_preloader_bg_color).';
		 }
		 @keyframes loading {
		  0%,
		  100% {
		  	transform: translatey(-2.5rem);
		    background-color: '.esc_attr($fashion_photography_preloader_dot_1_color).';
		  }
		  50% {
		  	transform: translatey(2.5rem);
		    background-color: '.esc_attr($fashion_photography_preloader_dot_2_color).';
		  }
		}
	';
    wp_add_inline_style( 'fashion-photography-style',$theme_color_css );

}
add_action( 'wp_enqueue_scripts', 'fashion_photography_theme_color' );

function fashion_photography_font_url(){
	$font_url = '';
	$cormorant = _x('on','Cormorant Garamond:on or off','fashion-photography');
	$muli = _x('on','Muli:on or off','fashion-photography');
	
	if('off' !== $cormorant ){
		$font_family = array();
		if('off' !== $cormorant){
			$font_family[] = 'Cormorant Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700';
		}
		if('off' !== $muli){
			$font_family[] = 'Muli:100;0,200;0,300;0,400;0,500;0,600;0,800;0,900;1,100;1,200;1,400;1,500;1,600;1,700;1,800;1,900';
		}
		$query_args = array(
			'family'	=> urlencode(implode('|',$font_family)),
		);
		$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
	}
	return $font_url;
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

// /**
//  * Implement the Custom Header feature.
//  */
// require get_template_directory() . '/inc/custom-header.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/*radio button sanitization*/
function fashion_photography_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $setting->id ); 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function fashion_photography_sanitize_checkbox( $input ) {
	// Boolean check 
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function fashion_photography_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

/**
 * Get CSS
 */

function fashion_photography_getpage_css($hook) {
	if ( 'appearance_page_fashion-photography-info' != $hook ) {
		return;
	}
	wp_enqueue_style( 'fashion-photography-demo-style', get_template_directory_uri() . '/assets/css/demo.css' );
}
add_action( 'admin_enqueue_scripts', 'fashion_photography_getpage_css' );

add_action('after_switch_theme', 'fashion_photography_setup_options');

function fashion_photography_setup_options () {
	wp_redirect( admin_url() . 'themes.php?page=fashion-photography-info.php' );
}

if ( ! defined( 'FASHION_PHOTOGRAPHY_CONTACT_SUPPORT' ) ) {
define('FASHION_PHOTOGRAPHY_CONTACT_SUPPORT',__('https://wordpress.org/support/theme/fashion-photography/','fashion-photography'));
}
if ( ! defined( 'FASHION_PHOTOGRAPHY_REVIEW' ) ) {
define('FASHION_PHOTOGRAPHY_REVIEW',__('https://wordpress.org/support/theme/fashion-photography/reviews/#new-post','fashion-photography'));
}
if ( ! defined( 'FASHION_PHOTOGRAPHY_LIVE_DEMO' ) ) {
define('FASHION_PHOTOGRAPHY_LIVE_DEMO',__('https://themagnifico.net/demo/fashion-photography/','fashion-photography'));
}
if ( ! defined( 'FASHION_PHOTOGRAPHY_GET_PREMIUM_PRO' ) ) {
define('FASHION_PHOTOGRAPHY_GET_PREMIUM_PRO',__('https://www.themagnifico.net/themes/fashion-photography-wordpress-theme/','fashion-photography'));
}
if ( ! defined( 'FASHION_PHOTOGRAPHY_PRO_DOC' ) ) {
define('FASHION_PHOTOGRAPHY_PRO_DOC',__('https://www.themagnifico.net/eard/wathiqa/fashion-photography-pro-doc/','fashion-photography'));
}

add_action('admin_menu', 'fashion_photography_themepage');
function fashion_photography_themepage(){
	$theme_info = add_theme_page( __('Theme Options','fashion-photography'), __('Theme Options','fashion-photography'), 'manage_options', 'fashion-photography-info.php', 'fashion_photography_info_page' );
}

function fashion_photography_info_page() {
	$user = wp_get_current_user();
	$theme = wp_get_theme();
	?>
	<div class="wrap about-wrap fashion-photography-add-css">
		<div>
			<h1>
				<?php esc_html_e('Welcome To ','fashion-photography'); ?><?php echo esc_html( $theme ); ?>
			</h1>
			<div class="feature-section three-col">
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Contact Support", "fashion-photography"); ?></h3>
						<p><?php esc_html_e("Thank you for trying Fashion Photography , feel free to contact us for any support regarding our theme.", "fashion-photography"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( FASHION_PHOTOGRAPHY_CONTACT_SUPPORT ); ?>" class="button button-primary get">
							<?php esc_html_e("Contact Support", "fashion-photography"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Checkout Premium", "fashion-photography"); ?></h3>
						<p><?php esc_html_e("Our premium theme comes with extended features like demo content import , responsive layouts etc.", "fashion-photography"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( FASHION_PHOTOGRAPHY_GET_PREMIUM_PRO ); ?>" class="button button-primary get">
							<?php esc_html_e("Get Premium", "fashion-photography"); ?>
						</a></p>
					</div>
				</div>  
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Review", "fashion-photography"); ?></h3>
						<p><?php esc_html_e("If You love Fashion Photography theme then we would appreciate your review about our theme.", "fashion-photography"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( FASHION_PHOTOGRAPHY_REVIEW ); ?>" class="button button-primary get">
							<?php esc_html_e("Review", "fashion-photography"); ?>
						</a></p>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<h2><?php esc_html_e("Free Vs Premium","fashion-photography"); ?></h2>
		<div class="fashion-photography-button-container">
			<a target="_blank" href="<?php echo esc_url( FASHION_PHOTOGRAPHY_PRO_DOC ); ?>" class="button button-primary get">
				<?php esc_html_e("Checkout Documentation", "fashion-photography"); ?>
			</a>
			<a target="_blank" href="<?php echo esc_url( FASHION_PHOTOGRAPHY_LIVE_DEMO ); ?>" class="button button-primary get">
				<?php esc_html_e("View Theme Demo", "fashion-photography"); ?>
			</a>
		</div>
		<table class="wp-list-table widefat">
			<thead class="table-book">
				<tr>
					<th><strong><?php esc_html_e("Theme Feature", "fashion-photography"); ?></strong></th>
					<th><strong><?php esc_html_e("Basic Version", "fashion-photography"); ?></strong></th>
					<th><strong><?php esc_html_e("Premium Version", "fashion-photography"); ?></strong></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php esc_html_e("Header Background Color", "fashion-photography"); ?></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Custom Navigation Logo Or Text", "fashion-photography"); ?></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Hide Logo Text", "fashion-photography"); ?></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>

				<tr>
					<td><?php esc_html_e("Premium Support", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Fully SEO Optimized", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Recent Posts Widget", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>

				<tr>
					<td><?php esc_html_e("Easy Google Fonts", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Pagespeed Plugin", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Only Show Header Image On Front Page", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Show Header Everywhere", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Custom Text On Header Image", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Full Width (Hide Sidebar)", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Only Show Upper Widgets On Front Page", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Replace Copyright Text", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Upper Widgets Colors", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Navigation Color", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Post/Page Color", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Blog Feed Color", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Footer Color", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Sidebar Color", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Background Color", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Importable Demo Content	", "fashion-photography"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
			</tbody>
		</table>
		<div class="fashion-photography-button-container">
			<a target="_blank" href="<?php echo esc_url( FASHION_PHOTOGRAPHY_GET_PREMIUM_PRO ); ?>" class="button button-primary get">
				<?php esc_html_e("Go Premium", "fashion-photography"); ?>
			</a>
		</div>
	</div>
	<?php
}

/**
 * Change number or products per row to 3
 */
add_filter('loop_shop_columns', 'fashion_photography_loop_columns', 999);
if (!function_exists('fashion_photography_loop_columns')) {
	function fashion_photography_loop_columns() {
		return 3;
	}
}

