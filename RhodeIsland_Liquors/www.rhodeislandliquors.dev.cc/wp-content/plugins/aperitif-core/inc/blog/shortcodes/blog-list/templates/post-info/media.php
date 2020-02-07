<div class="qodef-e-media">
	<?php switch ( get_post_format() ) {
		case 'gallery':
			aperitif_core_theme_template_part( 'blog', 'templates/parts/post-format/gallery' );
			break;
		case 'video':
			aperitif_core_theme_template_part( 'blog', 'templates/parts/post-format/video' );
			break;
		case 'audio':
			aperitif_core_theme_template_part( 'blog', 'templates/parts/post-format/audio' );
			break;
		default:
			aperitif_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/image' );
			break;
	} ?>
</div>