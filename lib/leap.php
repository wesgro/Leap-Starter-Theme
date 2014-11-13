<?php
/******************************************************************************************************************
*******************************************************************************************************************
  Truncate String
*******************************************************************************************************************
******************************************************************************************************************/
function truncate($input, $maxWords, $maxChars){
    $words = preg_split('/\s+/', strip_shortcodes($input));
    $words = array_slice($words, 0, $maxWords);
    $words = array_reverse($words);

    $chars = 0;
    $truncated = array();

    while(count($words) > 0)
    {
        $fragment = trim(array_pop($words));
        $chars += strlen($fragment);

        if($chars > $maxChars) break;

        $truncated[] = $fragment;
    }

    $result = implode($truncated, ' ');

    return $result . ($input == $result ? '' : '...');
}



// Thumbnail sizes
add_image_size( 'thumb-600-600', 600, 600, true );
add_image_size( 'thumb-300-300', 300, 300, true );
add_image_size( 'tiny', 1, 1, true );

add_image_size( 'blog-post', 500);

add_image_size( 'bg-slider-pmobile', 640, 640, true );
add_image_size( 'bg-slider-lmobile', 960,450, true );
add_image_size( 'bg-slider-ptab', 768, 450, true );
add_image_size( 'bg-slider-ltab', 1024, 500,  true );
add_image_size( 'bg-slider-desk', 1600, 700, true );


add_image_size( 'bg-content-pmobile', 320, 320,true );
add_image_size( 'bg-content-lmobile', 480, 430,true );
add_image_size( 'bg-content-ptab', 700, 523, true );
add_image_size( 'bg-content-ltab', 650, 483, true );
add_image_size( 'bg-content-desk', 650, 483, true );


add_image_size( 'full-content-width', 960, false );
add_image_size( 'big-view', 1024, false );

function array_reverse_keys($ar){ 
    return array_reverse(array_reverse($ar,true),false); 
} 
function get_responsive_sizes(){
  $sizes = array(
    'default' => '',
    'ldesk' => '(min-width:1027px)',
    'desk' => '(min-width:1026px)',
    'sdesk' => '(min-width:1025px)',
    'ltab' => '(min-width:1024px)',
    'ptab' => '(min-width:768px)',
    'lmobile' => '(min-width:767px)',
    'pmobile' => '(min-width:320px)',
  );
//   $sizes = krsort($sizes);
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
//$h = text
//$n = keywords to find separated by space
//$w = words near keywords to keep
function leap_truncatePreserveWords ($h,$n,$w=5,$tag='b') {
	$n = explode(" ",trim(strip_tags($n)));	//needles words
	$b = explode(" ",trim(strip_tags($h)));	//haystack words
	$c = array();						//array of words to keep/remove
	for ($j=0;$j<count($b);$j++) $c[$j]=false;
	for ($i=0;$i<count($b);$i++) 
		for ($k=0;$k<count($n);$k++) 
			if (stristr($b[$i],$n[$k])) {
				$b[$i]=preg_replace("/".$n[$k]."/i","<$tag>\\0</$tag>",$b[$i]);
				for ( $j= max( $i-$w , 0 ) ;$j<min( $i+$w, count($b)); $j++) $c[$j]=true; 
			}	
	$o = "";	// reassembly words to keep
	for ($j=0;$j<count($b);$j++) if ($c[$j]) $o.=" ".$b[$j]; else $o.=".";
	return preg_replace("/\.{3,}/i","...",$o);
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
function leap_class_names($classes) {
	// add 'class-name' to the $classes array
	if(!is_front_page()){
  	$classes[] = 'not-front';
	}
	// return the $classes array
	return $classes;
}
add_filter('body_class','leap_class_names');
add_action( 'login_enqueue_scripts', 'leap_login_logo' );
function leap_login_url() {  return home_url(); }
add_filter( 'login_headerurl', 'leap_login_url' );
function leap_login_title() { return get_option( 'blogname' ); }
add_filter( 'login_headertitle', 'leap_login_title' );
/**
* Add defer to all loaded scripts
*/
add_filter( 'clean_url', 'leap_add_defer_to_scripts', 11, 1 );
function leap_add_defer_to_scripts($url){
  preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
  if (count($matches)>1){
    //Then we're using IE
    $version = $matches[1];
  
    switch(true){
      case ($version<=8):
        //IE 8 or under!
        return $url;
      break;
  
      default:
        //You get the idea
        return defer_js($url);
      break;
    }
  }else{
    return defer_js($url);
  }
}
function defer_js($url){
  if ( (strpos( $url, '.js' ) === false) || is_admin()){ // not our file
    return $url;
  }
  // Must be a ', not "!
  return "$url' defer='defer";
}
add_filter('gform_init_scripts_footer', '__return_true');
add_filter( 'gform_cdata_open', 'wrap_gform_cdata_open' );
function wrap_gform_cdata_open( $content = '' ) {
  $content = 'document.addEventListener( "DOMContentLoaded", function() { ';
  preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
  if (count($matches)>1){
    //Then we're using IE
    $version = $matches[1];
    if($version<=8){
      $content = 'document.attachEvent( "onload", function() { ';
    }
  }
	
	return $content;
}
add_filter( 'gform_cdata_close', 'wrap_gform_cdata_close' );
function wrap_gform_cdata_close( $content = '' ) {
  $content = ' }, false );';
  return $content;
}
/*-----------------------------------------------------------
    Custom Walker Function that only shows an active class 
	and unique ID for each menu item, stripping out all the
	unnecessary classes and ID's. Nice!
-----------------------------------------------------------*/
 
class Mobile_Nav_Walker extends Walker_Nav_Menu
{
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
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

        $output .= apply_filters('walker_nav_menu_start_el',$item_output,$item,$depth,$args,$id);
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
    function start_el(&$output, $item, $depth=0, $args=array(), $current_object_id = 0) {
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

function adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Get decimal values
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    // Adjust number of steps and keep it inside 0 to 255
    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}