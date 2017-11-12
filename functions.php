<?php

add_theme_support('menus');
add_theme_support( 'post-thumbnails' );

function register_theme_menus() {
  register_nav_menus(
    array(
      'primary-menu' => __( 'Primary WSCS Menu' ),
     )
   );
 }

//tell Wordpress to run this function upon initialization
add_action('init', 'register_theme_menus');

function wscs_theme_styles() {
	//wscs namespacing (to prevent conflicting names with future plugins etc)
	//this function allows us to link to style sheets
	//get_template_directory_uri() gets the path to the folder containing this file (functions.php)
	//the period concatenates the above ^^ to css/materialize.css etc
	wp_enqueue_style('materialize_css', get_template_directory_uri() . '/css/materialize.min.css');
	wp_enqueue_style('main_css', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('googlefont_css', 'https://fonts.googleapis.com/icon?family=Material+Icons');
	//array() and false are default values; needed to fill last parameter with media query
	wp_enqueue_style('small_css', get_template_directory_uri() . '/css/small.css', array(), false, '(max-width:992px)');
	wp_enqueue_style('large_css', get_template_directory_uri() . '/css/large.css', array(), false, '(min-width:993px)');
}

//needed to tell wordpress when to enqueue the styles
//wp_enqueue_scripts is a hook that tells Wordpress which CSS and JS files to load for a given page
add_action('wp_enqueue_scripts', 'wscs_theme_styles');

function wscs_theme_js() {
	//order here determines order of load on site
	//wp_enqueue_script takes additional arguments of [array of dependents], fourth is [version (if want to set)]
	//and [boolean: appear in footer]
	wp_enqueue_script('materialize_js', get_template_directory_uri() . '/js/materialize.min.js', array('jquery'),'',true);
	wp_enqueue_script('main_js', get_template_directory_uri() . '/js/app.js', array('jquery', 'materialize_js'), '', true);
}

add_action('wp_enqueue_scripts', 'wscs_theme_js');

//Customizing menu output. See: http://www.kriesi.at/archives/improve-your-wordpress-navigation-menu-output
//Also see: https://developer.wordpress.org/reference/classes/walker_category/ (very helpful)
//TODO: right now, we're assuming every parent has a child submenu (in Desktop, all parents have the triangle to their left
//and in responsive every parent is structured assuming it has children)
class wscs_materializecss_large_walker extends Walker_Nav_Menu
{
	// modified to add id corresponding to parent (child-of-CURRENTID) in every child ul,
	// in every parent set data-activates to corresponding child submenu id

	//we use a shared variable to keep track of who the parent was
	private $wscsCurItem;

  //Note: The start level refers to the start of a sub-level. Meaning that the output does not effect the initial wrapping around the whole navigation, but only the list of childerns children (https://developer.wordpress.org/reference/classes/walker/start_lvl/)
	function start_lvl(&$output, $depth)
	{
	   $indent = str_repeat("\t", $depth);

	   //add id corresponding to parent...this is ouputted in the ul tag that contains a submenu
	   $parentID = $this->wscsCurItem;
	   $output .= "\n" . $indent . '<ul ' . $id . ' class="dropdown-content" id="child-of-' . $parentID .'">' . "\n";
	}


  	function start_el(&$output, $item, $depth, $args)
  	{
  	   // update who the parent is...
  	   $currentId = $this->wscsCurItem = $item->ID;

       global $wp_query;
       $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

       $class_names = $value = '';

       $classes = empty( $item->classes ) ? array() : (array) $item->classes;

       $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
       $class_names = ' class="'. esc_attr( $class_names ) . '"';

       $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

       $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
       $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
       $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
       $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
       // if depth is 0 (aka parent), then has id that corresponds with its child submenu
       if ($depth == 0) $attributes .= ' class="wscs-dropdown" data-activates="child-of-'. $currentId .'"';


       $prepend = '<strong>';
       $append = '</strong><i class="material-icons right">arrow_drop_down</i>';
       $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

       if($depth != 0)
       {
                 $description = $append = $prepend = "";
       }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
        $item_output .= $description.$args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
   	}
}

class wscs_materializecss_small_walker extends Walker_Nav_Menu
{
  //Note: The start level refers to the start of a sub-level. Meaning that the output does not effect the initial wrapping around the whole navigation, but only the list of childerns children (https://developer.wordpress.org/reference/classes/walker/start_lvl/)
  function start_lvl(&$output, $depth)
  {
     $indent = str_repeat("\t", $depth);
     //collapsible body tag added
     $output .= "\n" . $indent . '<div class="collapsible-body"><ul>';
  }

  function end_lvl( &$output, $depth = 0, $args = array() )
  {
    $indent = str_repeat("\t", $depth);
    // These close the tags that were added
    $output .= "$indent</ul></div></ul></li>\n";
  }


    function start_el(&$output, $item, $depth, $args)
    {
       global $wp_query;
       $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

       $class_names = $value = '';

       $classes = empty( $item->classes ) ? array() : (array) $item->classes;

       $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
       $class_names = ' class="'. esc_attr( $class_names ) . '"';

       // These two lines add the necessary stuff for collapsible (materialize)
       $output .= $indent . '<li class="no-padding"> <ul class="collapsible collapsible-accordion">';
       $output .= '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

       $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
       $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
       $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
       $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';


       $prepend = '<strong>';
       $append = '</strong>';
       $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

       if($depth != 0)
       {
                 $description = $append = $prepend = "";
       }

        $item_output = $args->before;
        // collapsible header tag added
        $item_output .= '<a class="collapsible-header"' . $attributes .'>';
        $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
        $item_output .= $description.$args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

function envira_gallery_image_titles( $output, $id, $item, $data, $i ) {

  // IDs of galleries to display titles on
  $galleriesToShowTitles = array(
    79
  );

  // Check if we need to display titles on this gallery
  if ( !in_array( $data['id'], $galleriesToShowTitles ) ) {
    return $output;
  }

  if ( isset( $item['title'] )) {
    $output .= '<h3 style="padding-top: 0.25rem; text-align: center; display: block; letter-spacing: 0.5px; font-size: 1.25rem;">' . $item['title'] . '</h3>';
  }

  return $output;

}
add_action( 'envira_gallery_output_after_link', 'envira_gallery_image_titles', 10, 5 );?>

?>

function modify_read_more_link() {
    return '<a class="button" href="' . get_permalink() . '">Read Full Story</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

?>
