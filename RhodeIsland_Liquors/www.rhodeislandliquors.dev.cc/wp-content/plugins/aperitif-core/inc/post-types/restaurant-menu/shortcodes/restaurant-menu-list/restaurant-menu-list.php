<?php

if ( ! function_exists( 'aperitif_core_add_restaurant_menu_list_shortcode' ) ) {
	/**
	 * Function that is adding shortcode into shortcodes list for registration
	 *
	 * @param array $shortcodes - Array of registered shortcodes
	 *
	 * @return array
	 */
	function aperitif_core_add_restaurant_menu_list_shortcode( $shortcodes ) {
		$shortcodes[] = 'AperitifCoreRestaurantMenuListShortcode';
		
		return $shortcodes;
	}
	
	add_filter( 'aperitif_core_filter_register_shortcodes', 'aperitif_core_add_restaurant_menu_list_shortcode' );
}

if ( class_exists( 'AperitifCoreListShortcode' ) ) {
	class AperitifCoreRestaurantMenuListShortcode extends AperitifCoreListShortcode {
		
		public function __construct() {
			$this->set_post_type( 'restaurant-menu' );
			$this->set_layouts( apply_filters( 'aperitif_core_filter_restaurant_menu_list_layouts', array() ) );
			
			parent::__construct();
		}
		
		public function map_shortcode() {
			$this->set_shortcode_path( APERITIF_CORE_CPT_URL_PATH . '/restaurant-menu/shortcodes/restaurant-menu-list' );
			$this->set_base( 'aperitif_core_restaurant_menu_list' );
			$this->set_name( esc_html__( 'Restaurant Menu List', 'aperitif-core' ) );
			$this->set_description( esc_html__( 'Shortcode that displays list of restaurant menu', 'aperitif-core' ) );
			$this->set_category( esc_html__( 'Aperitif Core', 'aperitif-core' ) );
			
			$this->set_option( array(
				'field_type' => 'text',
				'name'       => 'custom_class',
				'title'      => esc_html__( 'Custom Class', 'aperitif-core' )
			) );
			$this->set_option( array(
				'field_type'    => 'select',
				'name'          => 'skin',
				'title'         => esc_html__( 'Set Skin', 'aperitif-core' ),
				'options'       => aperitif_core_get_select_type_options_pool( 'skin' ),
				'default_value' => 'default',
				'group'         => esc_html__( 'Additional', 'aperitif-core' )
			) );
			$this->map_list_options( array(
				'exclude_behavior' => array( 'masonry', 'justified-gallery', 'slider' ),
				'exclude_option'   => array( 'images_proportion' ),
				'default_columns'  => '2',
			) );
			$this->map_query_options( array( 'post_type' => $this->get_post_type() ) );
			$this->map_layout_options( array(
				'layouts' => $this->get_layouts()
			) );
			$this->map_extra_options();
		}
		
		public function render( $options, $content = null ) {
			parent::render( $options );
			
			$atts = $this->get_atts();
			
			$atts['post_type'] = $this->get_post_type();
			
			// Additional query args
			$atts['additional_query_args'] = $this->get_additional_query_args( $atts );
			
			$atts['holder_classes'] = $this->get_holder_classes( $atts );
			$atts['item_classes']   = $this->get_item_classes( $atts );
			
			$atts['query_result'] = new \WP_Query( aperitif_core_get_query_params( $atts ) );
			
			return aperitif_core_get_template_part( 'post-types/restaurant-menu/shortcodes/restaurant-menu-list', 'templates/content', $atts['behavior'], $atts );
		}
		
		private function get_holder_classes( $atts ) {
			$holder_classes = $this->init_holder_classes();
			
			$holder_classes[] = 'qodef-restaurant-menu-list';
			
			$list_classes            = $this->get_list_classes( $atts );
			$hover_animation_classes = $this->get_hover_animation_classes( $atts );
			$holder_classes          = array_merge( $holder_classes, $list_classes, $hover_animation_classes );
			
			return implode( ' ', $holder_classes );
		}
		
		public function get_item_classes( $atts ) {
			$item_classes = $this->init_item_classes();
			
			$list_item_classes = $this->get_list_item_classes( $atts );
			
			$item_classes = array_merge( $item_classes, $list_item_classes );
			
			return implode( ' ', $item_classes );
		}
	}
}