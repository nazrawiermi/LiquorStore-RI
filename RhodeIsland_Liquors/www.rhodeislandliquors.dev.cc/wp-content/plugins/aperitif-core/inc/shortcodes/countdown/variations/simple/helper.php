<?php

if ( ! function_exists( 'aperitif_core_add_countdown_variation_simple' ) ) {
	function aperitif_core_add_countdown_variation_simple( $variations ) {
		
		$variations['simple'] = esc_html__( 'Simple', 'aperitif-core' );
		
		return $variations;
	}
	
	add_filter( 'aperitif_core_filter_countdown_layouts', 'aperitif_core_add_countdown_variation_simple' );
}
