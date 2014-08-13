<?php
// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'leap_flush_rewrite_rules' );
function leap_flush_rewrite_rules() {
	flush_rewrite_rules();
}

/**
* Sliders post type
*/
function slider_post_type(){
  if ( ! class_exists( 'Super_Custom_Post_Type' ) ){
    return;
  }
  $menu = new Super_Custom_Post_Type( 'slider' );
  $menu->set_icon( 'tasks' );
}
add_action( 'after_setup_theme', 'slider_post_type' );
/**
* Sliders fields
*/
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_sliders',
		'title' => 'Sliders',
		'fields' => array (
			array (
				'key' => 'field_53ea52b432c93',
				'label' => 'Slider Image',
				'name' => 'image',
				'type' => 'image',
				'required' => 1,
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_53ea52da32c96',
				'label' => 'Slider Text',
				'name' => 'slider_text',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_53ea52bf32c94',
				'label' => 'Link Text',
				'name' => 'link_text',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_53ea52c432c95',
				'label' => 'Link URL',
				'name' => 'link_url',
				'type' => 'page_link',
				'post_type' => array (
					0 => 'post',
					1 => 'page',
				),
				'allow_null' => 0,
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'slider',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'permalink',
				1 => 'the_content',
				2 => 'excerpt',
				3 => 'custom_fields',
				4 => 'discussion',
				5 => 'comments',
				6 => 'revisions',
				7 => 'slug',
				8 => 'author',
				9 => 'format',
				10 => 'featured_image',
				11 => 'categories',
				12 => 'tags',
				13 => 'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));
}

