<?php
/**
 * Adds HTML markup.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'lalita_body_schema' ) ) {
	/**
	 * Figure out which schema tags to apply to the <body> element.
	 *
	 */
	function lalita_body_schema() {
		// Set up blog variable
		$blog = ( is_home() || is_archive() || is_attachment() || is_tax() || is_single() ) ? true : false;

		// Set up default itemtype
		$itemtype = 'WebPage';

		// Get itemtype for the blog
		$itemtype = ( $blog ) ? 'Blog' : $itemtype;

		// Get itemtype for search results
		$itemtype = ( is_search() ) ? 'SearchResultsPage' : $itemtype;

		// Get the result
		$result = apply_filters( 'lalita_body_itemtype', $itemtype );

		// Return our HTML
		echo "itemtype='https://schema.org/" . esc_html( $result ) . "' itemscope='itemscope'";
	}
}

if ( ! function_exists( 'lalita_article_schema' ) ) {
	/**
	 * Figure out which schema tags to apply to the <article> element
	 * The function determines the itemtype: lalita_article_schema( 'BlogPosting' )
	 *
	 */
	function lalita_article_schema( $type = 'CreativeWork' ) {
		// Get the itemtype
		$itemtype = apply_filters( 'lalita_article_itemtype', $type );

		// Print the results
		echo "itemtype='https://schema.org/" . esc_html( $itemtype ) . "' itemscope='itemscope'";
	}
}

if ( ! function_exists( 'lalita_body_classes' ) ) {
	add_filter( 'body_class', 'lalita_body_classes' );
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 */
	function lalita_body_classes( $classes ) {
		// Get Customizer settings
		$lalita_settings = wp_parse_args(
			get_option( 'lalita_settings', array() ),
			lalita_get_defaults()
		);

		// Get the layout
		$layout = lalita_get_layout();

		// Get the navigation location
		$navigation_location = lalita_get_navigation_location();

		// Get the footer widgets
		$widgets = lalita_get_footer_widgets();

		// Full width content
		// Used for page builders, sets the content to full width and removes the padding
		$full_width = get_post_meta( get_the_ID(), '_lalita-full-width-content', true );
		$classes[] = ( '' !== $full_width && false !== $full_width && is_singular() && 'true' == $full_width ) ? 'full-width-content' : '';

		// Contained content
		// Used for page builders, basically just removes the content padding
		$classes[] = ( '' !== $full_width && false !== $full_width && is_singular() && 'contained' == $full_width ) ? 'contained-content' : '';

		// Let us know if a featured image is being used
		if ( has_post_thumbnail() ) {
			$classes[] = 'featured-image-active';
		}

		// Layout classes
		$classes[] = ( $layout ) ? $layout : 'right-sidebar';
		$classes[] = ( $navigation_location ) ? $navigation_location : 'nav-below-header';
		$classes[] = ( $lalita_settings['header_layout_setting'] ) ? $lalita_settings['header_layout_setting'] : 'fluid-header';
		$classes[] = ( $lalita_settings['content_layout_setting'] ) ? $lalita_settings['content_layout_setting'] : 'separate-containers';
		$classes[] = ( '' !== $widgets ) ? 'active-footer-widgets-' . $widgets : 'active-footer-widgets-3';
		$classes[] = ( 'enable' == $lalita_settings['nav_search'] ) ? 'nav-search-enabled' : '';

		// Navigation alignment class
		if ( $lalita_settings['nav_alignment_setting'] == 'left' ) {
			$classes[] = 'nav-aligned-left';
		} elseif ( $lalita_settings['nav_alignment_setting'] == 'center' ) {
			$classes[] = 'nav-aligned-center';
		} elseif ( $lalita_settings['nav_alignment_setting'] == 'right' ) {
			$classes[] = 'nav-aligned-right';
		} else {
			$classes[] = 'nav-aligned-left';
		}

		// Transparent header
		$transparent_header = get_post_meta( get_the_ID(), '_lalita-transparent-header', true );
		if ( $transparent_header == true ) {
			$classes[] = 'transparent-header';
		}


		// Header alignment class
		if ( $lalita_settings['header_alignment_setting'] == 'left' ) {
			$classes[] = 'header-aligned-left';
		} elseif ( $lalita_settings['header_alignment_setting'] == 'center' ) {
			$classes[] = 'header-aligned-center';
		} elseif ( $lalita_settings['header_alignment_setting'] == 'right' ) {
			$classes[] = 'header-aligned-right';
		} else {
			$classes[] = 'header-aligned-left';
		}

		// Navigation dropdown type
		if ( 'click' == $lalita_settings[ 'nav_dropdown_type' ] ) {
			$classes[] = 'dropdown-click';
			$classes[] = 'dropdown-click-menu-item';
		} elseif ( 'click-arrow' == $lalita_settings[ 'nav_dropdown_type' ] ) {
			$classes[] = 'dropdown-click-arrow';
			$classes[] = 'dropdown-click';
		} else {
			$classes[] = 'dropdown-hover';
		}

		// Navigation Effect
		$naveffect = $lalita_settings[ 'nav_effect' ];
		$classes[] = 'navigation-effect-' . esc_attr( $naveffect );

		return $classes;
	}
}

if ( ! function_exists( 'lalita_top_bar_classes' ) ) {
	add_filter( 'lalita_top_bar_class', 'lalita_top_bar_classes' );
	/**
	 * Adds custom classes to the header.
	 *
	 */
	function lalita_top_bar_classes( $classes ) {
		$classes[] = 'top-bar';

		if ( 'contained' == lalita_get_setting( 'top_bar_width' ) ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		$classes[] = 'top-bar-align-' . lalita_get_setting( 'top_bar_alignment' );

		return $classes;
	}
}

if ( ! function_exists( 'lalita_right_sidebar_classes' ) ) {
	add_filter( 'lalita_right_sidebar_class', 'lalita_right_sidebar_classes' );
	/**
	 * Adds custom classes to the right sidebar.
	 *
	 */
	function lalita_right_sidebar_classes( $classes ) {
		$right_sidebar_width = apply_filters( 'lalita_right_sidebar_width', '25' );
		$left_sidebar_width = apply_filters( 'lalita_left_sidebar_width', '25' );

		$right_sidebar_tablet_width = apply_filters( 'lalita_right_sidebar_tablet_width', $right_sidebar_width );
		$left_sidebar_tablet_width = apply_filters( 'lalita_left_sidebar_tablet_width', $left_sidebar_width );

		$classes[] = 'widget-area';
		$classes[] = 'grid-' . $right_sidebar_width;
		$classes[] = 'tablet-grid-' . $right_sidebar_tablet_width;
		$classes[] = 'grid-parent';
		$classes[] = 'sidebar';

		// Get the layout
		$layout = lalita_get_layout();

		if ( '' !== $layout ) {
			switch ( $layout ) {
				case 'both-left' :
					$total_sidebar_width = $left_sidebar_width + $right_sidebar_width;
					$classes[] = 'pull-' . ( 100 - $total_sidebar_width );

					$total_sidebar_tablet_width = $left_sidebar_tablet_width + $right_sidebar_tablet_width;
					$classes[] = 'tablet-pull-' . ( 100 - $total_sidebar_tablet_width );
				break;
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'lalita_left_sidebar_classes' ) ) {
	add_filter( 'lalita_left_sidebar_class', 'lalita_left_sidebar_classes' );
	/**
	 * Adds custom classes to the left sidebar.
	 *
	 */
	function lalita_left_sidebar_classes( $classes ) {
		$right_sidebar_width = apply_filters( 'lalita_right_sidebar_width', '25' );
		$left_sidebar_width = apply_filters( 'lalita_left_sidebar_width', '25' );
		$total_sidebar_width = $left_sidebar_width + $right_sidebar_width;

		$right_sidebar_tablet_width = apply_filters( 'lalita_right_sidebar_tablet_width', $right_sidebar_width );
		$left_sidebar_tablet_width = apply_filters( 'lalita_left_sidebar_tablet_width', $left_sidebar_width );
		$total_sidebar_tablet_width = $left_sidebar_tablet_width + $right_sidebar_tablet_width;

		$classes[] = 'widget-area';
		$classes[] = 'grid-' . $left_sidebar_width;
		$classes[] = 'tablet-grid-' . $left_sidebar_tablet_width;
		$classes[] = 'mobile-grid-100';
		$classes[] = 'grid-parent';
		$classes[] = 'sidebar';

		// Get the layout
		$layout = lalita_get_layout();

		if ( '' !== $layout ) {
			switch ( $layout ) {
				case 'left-sidebar' :
					$classes[] = 'pull-' . ( 100 - $left_sidebar_width );
					$classes[] = 'tablet-pull-' . ( 100 - $left_sidebar_tablet_width );
				break;

				case 'both-sidebars' :
				case 'both-left' :
					$classes[] = 'pull-' . ( 100 - $total_sidebar_width );
					$classes[] = 'tablet-pull-' . ( 100 - $total_sidebar_tablet_width );
				break;
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'lalita_content_classes' ) ) {
	add_filter( 'lalita_content_class', 'lalita_content_classes' );
	/**
	 * Adds custom classes to the content container.
	 *
	 */
	function lalita_content_classes( $classes ) {
		$right_sidebar_width = apply_filters( 'lalita_right_sidebar_width', '25' );
		$left_sidebar_width = apply_filters( 'lalita_left_sidebar_width', '25' );
		$total_sidebar_width = $left_sidebar_width + $right_sidebar_width;

		$right_sidebar_tablet_width = apply_filters( 'lalita_right_sidebar_tablet_width', $right_sidebar_width );
		$left_sidebar_tablet_width = apply_filters( 'lalita_left_sidebar_tablet_width', $left_sidebar_width );
		$total_sidebar_tablet_width = $left_sidebar_tablet_width + $right_sidebar_tablet_width;

		$classes[] = 'content-area';
		$classes[] = 'grid-parent';
		$classes[] = 'mobile-grid-100';

		// Get the layout
		$layout = lalita_get_layout();

		if ( '' !== $layout ) {
			switch ( $layout ) {

				case 'right-sidebar' :
					$classes[] = 'grid-' . ( 100 - $right_sidebar_width );
					$classes[] = 'tablet-grid-' . ( 100 - $right_sidebar_tablet_width );
				break;

				case 'left-sidebar' :
					$classes[] = 'push-' . $left_sidebar_width;
					$classes[] = 'grid-' . ( 100 - $left_sidebar_width );
					$classes[] = 'tablet-push-' . $left_sidebar_tablet_width;
					$classes[] = 'tablet-grid-' . ( 100 - $left_sidebar_tablet_width );
				break;

				case 'no-sidebar' :
					$classes[] = 'grid-100';
					$classes[] = 'tablet-grid-100';
				break;

				case 'both-sidebars' :
					$classes[] = 'push-' . $left_sidebar_width;
					$classes[] = 'grid-' . ( 100 - $total_sidebar_width );
					$classes[] = 'tablet-push-' . $left_sidebar_tablet_width;
					$classes[] = 'tablet-grid-' . ( 100 - $total_sidebar_tablet_width );
				break;

				case 'both-right' :
					$classes[] = 'grid-' . ( 100 - $total_sidebar_width );
					$classes[] = 'tablet-grid-' . ( 100 - $total_sidebar_tablet_width );
				break;

				case 'both-left' :
					$classes[] = 'push-' . $total_sidebar_width;
					$classes[] = 'grid-' . ( 100 - $total_sidebar_width );
					$classes[] = 'tablet-push-' . $total_sidebar_tablet_width;
					$classes[] = 'tablet-grid-' . ( 100 - $total_sidebar_tablet_width );
				break;
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'lalita_header_classes' ) ) {
	add_filter( 'lalita_header_class', 'lalita_header_classes' );
	/**
	 * Adds custom classes to the header.
	 *
	 */
	function lalita_header_classes( $classes ) {
		$classes[] = 'site-header';

		// Get theme options
		$lalita_settings = wp_parse_args(
			get_option( 'lalita_settings', array() ),
			lalita_get_defaults()
		);
		$header_layout = $lalita_settings['header_layout_setting'];

		if ( $header_layout == 'contained-header' ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		return $classes;
	}
}

if ( ! function_exists( 'lalita_inside_header_classes' ) ) {
	add_filter( 'lalita_inside_header_class', 'lalita_inside_header_classes' );
	/**
	 * Adds custom classes to inside the header.
	 *
	 */
	function lalita_inside_header_classes( $classes ) {
		$classes[] = 'inside-header';
		$inner_header_width = lalita_get_setting( 'header_inner_width' );

		if ( $inner_header_width !== 'full-width' ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		return $classes;
	}
}

if ( ! function_exists( 'lalita_navigation_classes' ) ) {
	add_filter( 'lalita_navigation_class', 'lalita_navigation_classes' );
	/**
	 * Adds custom classes to the navigation.
	 *
	 */
	function lalita_navigation_classes( $classes ) {
		$classes[] = 'main-navigation';

		// Get theme options
		$lalita_settings = wp_parse_args(
			get_option( 'lalita_settings', array() ),
			lalita_get_defaults()
		);
		$nav_layout = $lalita_settings['nav_layout_setting'];

		if ( $nav_layout == 'contained-nav' ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		return $classes;
	}
}

if ( ! function_exists( 'lalita_inside_navigation_classes' ) ) {
	add_filter( 'lalita_inside_navigation_class', 'lalita_inside_navigation_classes' );
	/**
	 * Adds custom classes to the inner navigation.
	 *
	 */
	function lalita_inside_navigation_classes( $classes ) {
		$classes[] = 'inside-navigation';
		$inner_nav_width = lalita_get_setting( 'nav_inner_width' );

		if ( $inner_nav_width !== 'full-width' ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		return $classes;
	}
}

if ( ! function_exists( 'lalita_menu_classes' ) ) {
	add_filter( 'lalita_menu_class', 'lalita_menu_classes' );
	/**
	 * Adds custom classes to the menu.
	 *
	 */
	function lalita_menu_classes( $classes ) {
		$classes[] = 'menu';
		$classes[] = 'sf-menu';
		return $classes;
	}
}

if ( ! function_exists( 'lalita_footer_classes' ) ) {
	add_filter( 'lalita_footer_class', 'lalita_footer_classes' );
	/**
	 * Adds custom classes to the footer.
	 *
	 */
	function lalita_footer_classes( $classes ) {
		$classes[] = 'site-footer';

		// Get theme options
		$lalita_settings = wp_parse_args(
			get_option( 'lalita_settings', array() ),
			lalita_get_defaults()
		);
		$footer_layout = $lalita_settings['footer_layout_setting'];

		if ( $footer_layout == 'contained-footer' ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		// Footer bar
		$classes[] = ( is_active_sidebar( 'footer-bar' ) ) ? 'footer-bar-active' : '';
		$classes[] = ( is_active_sidebar( 'footer-bar' ) ) ? 'footer-bar-align-' . $lalita_settings[ 'footer_bar_alignment' ] : '';

		return $classes;
	}
}

if ( ! function_exists( 'lalita_inside_footer_classes' ) ) {
	add_filter( 'lalita_inside_footer_class', 'lalita_inside_footer_classes' );
	/**
	 * Adds custom classes to the footer.
	 *
	 */
	function lalita_inside_footer_classes( $classes ) {
		$classes[] = 'footer-widgets-container';
		$inside_footer_width = lalita_get_setting( 'footer_widgets_inner_width' );

		if ( $inside_footer_width !== 'full-width' ) {
			$classes[] = 'grid-container';
			$classes[] = 'grid-parent';
		}

		return $classes;
	}
}

if ( ! function_exists( 'lalita_main_classes' ) ) {
	add_filter( 'lalita_main_class', 'lalita_main_classes' );
	/**
	 * Adds custom classes to the <main> element
	 *
	 */
	function lalita_main_classes( $classes ) {
		$classes[] = 'site-main';
		return $classes;
	}
}

if ( ! function_exists( 'lalita_post_classes' ) ) {
	add_filter( 'post_class', 'lalita_post_classes' );
	/**
	 * Adds custom classes to the <article> element.
	 * Remove .hentry class from pages to comply with structural data guidelines.
	 *
	 */
	function lalita_post_classes( $classes ) {
		if ( 'page' == get_post_type() ) {
			$classes = array_diff( $classes, array( 'hentry' ) );
		}

		return $classes;
	}
}
