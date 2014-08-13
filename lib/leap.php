<?php

// Thumbnail sizes
add_image_size( 'thumb-600', 600, 150, true );
add_image_size( 'thumb-300', 300, 100, true );

add_image_size( 'bg-slider-pmobile', 640, false );
add_image_size( 'bg-slider-lmobile', 960, false );
add_image_size( 'bg-slider-ptab', 768, false );
add_image_size( 'bg-slider-ltab', 1024, false );
add_image_size( 'bg-slider-desk', 1400, false );

add_image_size( 'bg-content-pmobile', 320, false );
add_image_size( 'bg-content-lmobile', 480, false );
add_image_size( 'bg-content-ptab', 800, false );
add_image_size( 'bg-content-ltab', 800, false );
add_image_size( 'bg-content-desk', 445, false );

add_image_size( 'product-mobile', 480, 156, true );
add_image_size( 'product-desk', 301, 278, true );

add_image_size( 'full-content-width', 1800, false );
add_image_size( 'big-view', 1024, false );
add_image_size( 'thumb-188-179', 176, 176, true );

function get_responsive_sizes(){
  $sizes = array(
    'default' => '',
    'pmobile' => '(max-width:321px)',
    'lmobile' => '(max-width:767px)',
    'ptab' => '(max-width:768px)',
    'ltab' => '(max-width:1024px)',
    'desk' => '(min-width:1025px)'
  );
  $sizes = array_reverse($sizes);
  return $sizes;
}

function leap_picture_fill($image_id, $mappings){
  $output = '<picture><!--[if IE 9]><video style="display: none;"><![endif]-->'."\n";
  foreach($mappings as $query => $thumbSize){
    $imageSrc = wp_get_attachment_image_src($image_id, $thumbSize);
    $output .='<source srcset="'.$imageSrc[0].'" media="'.$query.'">'."\n";
  }
  
  $imageSrc = wp_get_attachment_image_src($image_id);
  $output .= '<!--[if IE 9]></video><![endif]-->'."\n";
  $sizes = get_responsive_sizes();
  $default = wp_get_attachment_image_src($image_id, array_search($sizes['default'], $mappings));
  $output .= '<img srcset="'.$default[0].'" src="" alt="image"></picture>'."\n";
  
  return $output;
}

function leap_wrap_last_word($sentence, $seperator = ' '){
  $words = explode($seperator, $sentence);
  if (!empty($words)) {
      $lastWord = array_pop($words);
      $words[] = '<span>'.$lastWord.'</span>';
      $sentence = implode($seperator, $words);
  }
  return $sentence;
}

function leap_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/img/leap-logo.svg);
            background-size:150px 150px;
            width: 150px;
            height: 150px;
        }
    </style>
<?php }

add_action( 'login_enqueue_scripts', 'leap_login_logo' );
function leap_login_url() {  return home_url(); }
add_filter( 'login_headerurl', 'leap_login_url' );
function leap_login_title() { return get_option( 'blogname' ); }
add_filter( 'login_headertitle', 'leap_login_title' );

/*-----------------------------------------------------------
    Custom Walker Function that only shows an active class 
	and unique ID for each menu item, stripping out all the
	unnecessary classes and ID's. Nice!
-----------------------------------------------------------*/
 
class Mobile_Nav_Walker extends Walker_Nav_Menu
{
	function start_el(&$output,$item,$depth,$args)
	{
		
			
		global $wp_query;
		$class_names = $value = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;



	
        $current_indicators = array('current-menu-item','current-menu-parent','current_page_item','current_page_parent', 'header');
		$newClasses = array();
		foreach($classes as $el)
		{
			if(in_array($el,$current_indicators))
			{ 
				array_push($newClasses,$el);
			}
		}

		$class_names = join(' ',apply_filters('nav_menu_css_class',array_filter($newClasses),$item));

        $itemID = str_replace(" ", "-", strtolower($item->title));
		
		
		
        $output .= $indent . '<li class="' . $class_names .' ' . $value . '">';

        $attributes  = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) .'"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) .'"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';
         

        if(!empty($item->has_children)){
			$icon_name = (empty($item->icon_name))?' ': $item->icon_name;
	        $item_output .= '<h2><i class="'.$icon_name.'"></i>'.apply_filters('the_title',$item->title, $item->ID).'</h2>';
	        $item_output .= '<a href=#><i class="'.$icon_name.'"></i>';
       }else{                        
	        $item_output .= '<a ' .$attributes.'>';     
	   }
	        
        $item_output .= $args->link_before . apply_filters('the_title',$item->title, $item->ID);
        $item_output .= '</a>';
        $item_output .= $args->after;        

        $output .= apply_filters('walker_nav_menu_start_el',$item_output,$item,$depth,$args);
 	}
 	
 	
 	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
 	#var_dump($element);
	$id_field = $this->db_fields['id'];
	if ( !empty( $children_elements[ $element->$id_field ] ) ) {
		$element->classes[] = 'has-dropdown';
		$element->has_children = true;
	}
	
	
		
	
		Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}




 	
 	
}


class Walker_Simple_Example extends Walker {

    // Set the properties of the element which give the ID of the current item and its parent
    var $db_fields = array( 'parent' => 'parent_id', 'id' => 'object_id' );
 
    // Displays start of a level. E.g '<ul>'
    // @see Walker::start_lvl()
    function start_lvl(&$output, $depth=0, $args=array()) {
        $output .= "\n<ul>\n";
    }
 
    // Displays end of a level. E.g '</ul>'
    // @see Walker::end_lvl()
    function end_lvl(&$output, $depth=0, $args=array()) {
        $output .= "</ul>\n";
    }
 
    // Displays start of an element. E.g '<li> Item Name'
    // @see Walker::start_el()
    function start_el(&$output, $item, $depth=0, $args=array()) {
 		global $wp_query;
 		foreach ($item as $key => $value){
	 		echo $key . ' => ' . $value . ' <br /> ';
 		};
 		echo '<h1>' . $depth . '</h1>';
        $output .= "<li>".esc_attr($item->title);
    }
 
    // Displays end of an element. E.g '</li>'
    // @see Walker::end_el()
    function end_el(&$output, $item, $depth=0, $args=array()) {
        $output .= "</li>\n<br/><hr/><hr/><hr/>";
    }
}
#$elements=array(); // Array of elements
#echo Walker_Simple_Example::walk($elements);
