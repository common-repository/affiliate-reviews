<?php
/**
 * Get highest priority template.
 *
 * @param [type] $template_names
 * @param boolean $load
 * @param boolean $require_once
 * @return void
 */
if ( ! function_exists( 'affreviews_get_template' ) ) {
	function affreviews_get_template( $template_names, $load = false, $require_once = true, $params = false ) {
		// No file found yet
		$located = false;

		$template_base = apply_filters( 'affreviews_template_base', false );

		// Try to find a template file
		foreach ( (array) $template_names as $template_name ) {

			// Continue if template is empty
			if ( empty( $template_name ) ) {
				continue;
			}

			// Trim off any slashes from the template name
			$template_name = ltrim( $template_name, '/' );

			//First of all check if user set his path base
			if ( false !== $template_base && file_exists( trailingslashit( $template_base ) . 'templates/' . $template_name ) ) {
				$located = trailingslashit( $template_base ) . 'templates/' . $template_name;
				break;

				// Check child theme first
			} elseif ( file_exists( trailingslashit( get_stylesheet_directory() ) . 'affreviews/templates/' . $template_name ) ) {
				$located = trailingslashit( get_stylesheet_directory() ) . 'affreviews/templates/' . $template_name;
				break;

				// Check parent theme next
			} elseif ( file_exists( trailingslashit( get_template_directory() ) . 'affreviews/templates/' . $template_name ) ) {
				$located = trailingslashit( get_template_directory() ) . 'affreviews/templates/' . $template_name;
				break;

				// Check plugin templates
			} elseif ( file_exists( trailingslashit( affreviews_get_templates_dir() ) . $template_name ) ) {
				$located = trailingslashit( affreviews_get_templates_dir() ) . $template_name;
				break;
			}
		}

		if ( ( true === $load ) && ! empty( $located ) && ( false === $require_once ) ) {
			include $located;
		}

		if ( ( true === $load ) && ! empty( $located ) && ( true === $require_once ) ) {
			include_once $located;
		}

		return $located;
	}
}


/**
* Returns the path to the templates directory
*/
if ( ! function_exists( 'affreviews_get_templates_dir' ) ) {
	function affreviews_get_templates_dir() {
		return AFFREVIEWS_DIR . '/templates/';
	}
}

/**
 * Return svg icon
 */
if ( ! function_exists( 'affreviews_svg_icons' ) ) {
	function affreviews_svg_icons() {

		$icons = array(
			'check'      => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>',
			'star-empty' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
			<path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/></svg>',
			'star-half'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16"><path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/></svg>',
			'star-full'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>',
			'x'          => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16"><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>',
		);

		return apply_filters( 'affreviews_svg_icons', $icons );
	}
}

/**
 * Review rating.
 */
if ( ! function_exists( 'affreviews_get_rating' ) ) {
	function affreviews_get_rating( $post_id ) {

		if ( ! $post_id ) {
			return;
		}

		$html       = '';
		$count      = 0;
		$rating_num = affreviews_get_rating_num( $post_id );
		$half_icon  = apply_filters( 'affreviews_rating_half_icon', true );
		$icons      = affreviews_svg_icons();

		if ( ! $rating_num ) {
			return 'No rating available.';
		}

		$html .= '<div class="affr-rating"><div class="affr-rating-icons">';

		$rest = 5 - $rating_num;

		while ( $count < floor( $rating_num ) ) {
			$html .= $icons['star-full'];
			$count++;
		}

		if ( $rest > 0 ) {

			$count = 0;

			while ( $count < $rest ) {

				$dec = $rating_num - floor( $rating_num );

				if ( $half_icon ) {
					if ( 0.7 > $dec && 0.3 < $dec && is_float( $rest ) && 0 == $count ) {
						$html .= $icons['star-half'];
					} elseif ( 0.7 <= $dec && is_float( $rest ) && 0 == $count ) {
						$html .= $icons['star-full'];
					} else {
						$html .= $icons['star-empty'];
					}
				} else {
					if ( $dec >= 0.6 && is_float( $rest ) && 0 === $count ) {
						$html .= $icons['star-full'];
					} else {
						$html .= $icons['star-empty'];
					}
				}

				$count++;
			}
		}

		$html .= '</div></div><!-- /.affr-rating -->';

		return apply_filters( 'affreviews_rating_html', $html );
	}
}

/**
 * Return affiliate rating number
 */
if ( ! function_exists( 'affreviews_get_rating_num' ) ) {
	function affreviews_get_rating_num( $post_id ) {

		if ( ! $post_id ) {
			return;
		}

		$rating_num = (float) get_post_meta( $post_id, 'affreviews_rating', true );

		return $rating_num;
	}
}

/**
 * Extend ruleset of wp_kses for SVG icons
 *
 * @return void
 */
if ( ! function_exists( 'affreviews_kses_extended_ruleset' ) ) {
	function affreviews_kses_extended_ruleset() {
		$kses_defaults = wp_kses_allowed_html( 'post' );

		$svg_args = array(
			'svg'   => array(
				'class'           => true,
				'aria-hidden'     => true,
				'aria-labelledby' => true,
				'role'            => true,
				'xmlns'           => true,
				'width'           => true,
				'height'          => true,
				'viewbox'         => true, // <= Must be lower case!
			),
			'g'     => array( 'fill' => true ),
			'title' => array( 'title' => true ),
			'path'  => array(
				'd'    => true,
				'fill' => true,
			),
		);
		return array_merge( $kses_defaults, $svg_args );
	}
}

/**
 * Review thumbnail element
 *
 * @param [type] $post_id
 * @return void
 */
if ( ! function_exists( 'affreviews_get_thumb' ) ) {
	function affreviews_get_thumb( $post_id, $atts = array() ) {

		if ( ! $post_id ) {
			return;
		}

		if ( ! has_post_thumbnail( $post_id ) ) {
			return;
		}

		$link = affreviews_get_review_link_url( $post_id );

		$classes         = '';
		$css_vars        = '';
		$image           = '';
		$pre_image_html  = $link ? '<a href="' . $link . '">' : '';
		$post_image_html = $link ? '</a>' : '';

		if ( in_array( 'logo-box', $atts, true ) || in_array( 'logo-circle', $atts, true ) ) {

			$background_color = get_post_meta( $post_id, 'affreviews_logo_background_color', true );

			if ( in_array( 'logo-circle', $atts, true ) ) {
				$classes        .= ' affr-thumb--circle';
				$pre_image_html .= '<div class="affr-thumb__inner">';
				$post_image_html = '</div>' . $post_image_html;
			} elseif ( in_array( 'logo-box', $atts, true ) ) {
				$classes .= ' affr-thumb--box';
			}

			if ( $background_color && '' !== $background_color ) {
				$css_vars = '--affr-logo-background-color: ' . $background_color . ';';
			}

			$image = get_the_post_thumbnail( $post_id, 'affreviews-logo' );
		} else {
			$image = get_the_post_thumbnail( $post_id, 'affreviews-product' );
		}

		$output  = '<div class="affr-thumb' . $classes . '" ' . ( $css_vars ? 'style="' . $css_vars . '"' : '' ) . '>';
		$output .= $pre_image_html;
		$output .= $image;
		$output .= $post_image_html;
		$output .= '</div><!-- /.affr-thumb -->';

		return $output;

	}
}

/**
 * Review pros list
 *
 * @param [type] $post_id
 * @return void
 */
if ( ! function_exists( 'affreviews_get_pros' ) ) {
	function affreviews_get_pros( $post_id, $num = 999999 ) {

		if ( ! $post_id ) {
			return;
		}

		$positives = get_post_meta( $post_id, 'affreviews_positives', false );
		$output    = '';
		$icons     = affreviews_svg_icons();

		if ( ! $positives ) {
			return;
		}

		$output .= '<div class="affr-pros affr-list">';
		$output .= '<ul>';
		$count   = 1;
		foreach ( $positives[0] as $item ) {
			if ( $count <= $num ) {
				$output .= "<li>{$icons['check']}<span>{$item}</span></li>";
			}
			$count++;
		}
		$output .= '</ul>';
		$output .= '</div><!-- /.affr-pros -->';

		return $output;
	}
}

/**
 * Review cons list
 *
 * @param [type] $post_id
 * @return void
 */
if ( ! function_exists( 'affreviews_get_cons' ) ) {
	function affreviews_get_cons( $post_id, $num = 999999 ) {

		if ( ! $post_id ) {
			return;
		}

		$negatives = get_post_meta( $post_id, 'affreviews_negatives', false );
		$output    = '';
		$icons     = affreviews_svg_icons();

		if ( ! $negatives ) {
			return;
		}

		$output .= '<div class="affr-cons affr-list">';
		$output .= '<ul>';
		$count   = 1;
		foreach ( $negatives[0] as $item ) {
			if ( $count <= $num ) {
				$output .= "<li>{$icons['x']}<span>{$item}</span></li>";
			}
			$count++;
		}
		$output .= '</ul>';
		$output .= '</div><!-- /.affr-cons -->';

		return $output;
	}
}

/**
 * Review infolist
 *
 * @param [type] $post_id
 * @return void
 */
if ( ! function_exists( 'affreviews_get_infolist' ) ) {
	function affreviews_get_infolist( $post_id ) {

		if ( ! $post_id ) {
			return;
		}

		$infolist = get_post_meta( $post_id, 'affreviews_group_info_list', false );

		$output = '';
		$icons  = affreviews_svg_icons();

		if ( ! isset( $infolist[0] ) ) {
			return;
		}

		$output .= '<div class="affr-infolist">';
		$output .= '<ul>';
		foreach ( $infolist[0] as $item ) {
			$output .= "<li><span class='affr-infolist__title'>{$item['title']}:</span><span class='affr-infolist__value'>{$item['value']}</span></li>";
		}
		$output .= '</ul>';
		$output .= '</div><!-- /.affr-infolist -->';

		return $output;
	}
}

/**
 * Review title
 *
 * @param [type] $post_id
 * @return void
 */
if ( ! function_exists( 'affreviews_get_title' ) ) {
	function affreviews_get_title( $post_id ) {
		if ( ! $post_id ) {
			return;
		}

		$output  = '<div class="affr-title">';
		$output .= get_the_title( $post_id );
		$output .= '</div><!-- /.affr-title -->';

		return $output;
	}
}

/**
 * Review bonus
 *
 * @param [type] $post_id
 * @return void
 */
if ( ! function_exists( 'affreviews_get_bonus' ) ) {
	function affreviews_get_bonus( $post_id ) {
		if ( ! $post_id ) {
			return;
		}

		$affbonus = get_post_meta( $post_id, 'affreviews_bonus', true );
		if ( empty( $affbonus ) ) {
			return;
		}

		$output  = '<div class="affr-bonus">';
		$output .= '<p>' . $affbonus . '</p>';
		$output .= '</div><!-- /.affr-bonus -->';

		return $output;
	}
}

/**
 * Review link
 *
 * @param [type] $post_id
 * @return void
 */
if ( ! function_exists( 'affreviews_get_review_link' ) ) {
	function affreviews_get_review_link( $post_id, $review_link_text = null ) {
		if ( ! $post_id ) {
			return;
		}

		$link = affreviews_get_review_link_url( $post_id );
		if ( ! $link ) {
			return;
		}

		$review_link_text = $review_link_text ?? __( 'Read Review', 'affreviews' );

		$output  = '<div class="affr-link">';
		$output .= '<a href="' . $link . '">' . $review_link_text . '</a>';
		$output .= '</div><!-- /.affr-link -->';

		return $output;

	}
}

/**
 * Review link URL
 *
 * @param [type] $post_id
 * @return void
 */
if ( ! function_exists( 'affreviews_get_review_link_url' ) ) {
	function affreviews_get_review_link_url( $post_id ) {
		if ( ! $post_id ) {
			return;
		}

		$settings           = get_option( 'affreviews_general_settings' );
		$affreviews_afflink = get_post_meta( $post_id, 'affreviews_review_link', true );

		if ( isset( $settings['reviews_visibility'] ) && 'visible' === $settings['reviews_visibility'] ) {
			return get_permalink( $post_id );
		} elseif ( $affreviews_afflink ) {
			return $affreviews_afflink;
		} else {
			return;
		}

	}
}

/**
 * Review counter
 *
 * @param [int] $count
 * @return void
 */
if ( ! function_exists( 'affreviews_get_review_count' ) ) {
	function affreviews_get_review_count( $count ) {
		if ( ! $count ) {
			return;
		}

		$output  = '<div class="affr-counter">';
		$output .= $count;
		$output .= '</div><!-- /.affr-counter -->';

		return $output;

	}
}

/**
 * Review tag
 *
 * @param [int] $count
 * @return void
 */
if ( ! function_exists( 'affreviews_get_tag' ) ) {
	function affreviews_get_tag( $post_id ) {
		if ( ! $post_id ) {
			return;
		}

		$affreviews_tag_text             = get_post_meta( $post_id, 'affreviews_tag_text', true );
		$affreviews_tag_background_color = get_post_meta( $post_id, 'affreviews_tag_background_color', true );
		$affreviews_text_color           = '';
		$css                             = '';

		if ( empty( $affreviews_tag_text ) ) {
			return;
		}

		if ( isset( $affreviews_tag_background_color ) && ! empty( $affreviews_tag_background_color ) ) {
			$affreviews_text_color = affreviews_get_contrast_color( $affreviews_tag_background_color );
			$css                   = "--affr-tag-text-color:{$affreviews_text_color};--affr-tag-background-color:{$affreviews_tag_background_color};";
		}

		$output  = '<div class="affr-tag" style="' . $css . '">';
		$output .= $affreviews_tag_text;
		$output .= '</div><!-- /.affr-tag -->';

		return $output;

	}
}

/**
 * Get contrast color based on background color
 *
 * @param [int] $hex_color
 * @return void
 */
if ( ! function_exists( 'affreviews_get_contrast_color' ) ) {
	function affreviews_get_contrast_color( $hex_color ) {
		// hex_color RGB
		$r1 = hexdec( substr( $hex_color, 1, 2 ) );
		$g1 = hexdec( substr( $hex_color, 3, 2 ) );
		$b1 = hexdec( substr( $hex_color, 5, 2 ) );

		// Black RGB
		$blackcolor   = '#000000';
		$r2blackcolor = hexdec( substr( $blackcolor, 1, 2 ) );
		$g2blackcolor = hexdec( substr( $blackcolor, 3, 2 ) );
		$b2blackcolor = hexdec( substr( $blackcolor, 5, 2 ) );

		 // Calc contrast ratio
		 $l1 = 0.2126 * pow( $r1 / 255, 2.2 ) +
			   0.7152 * pow( $g1 / 255, 2.2 ) +
			   0.0722 * pow( $b1 / 255, 2.2 );

		$l2 = 0.2126 * pow( $r2blackcolor / 255, 2.2 ) +
			  0.7152 * pow( $g2blackcolor / 255, 2.2 ) +
			  0.0722 * pow( $b2blackcolor / 255, 2.2 );

		$contrastratio = 0;
		if ( $l1 > $l2 ) {
			$contrastratio = (int) ( ( $l1 + 0.05 ) / ( $l2 + 0.05 ) );
		} else {
			$contrastratio = (int) ( ( $l2 + 0.05 ) / ( $l1 + 0.05 ) );
		}

		// If contrast is more than 5, return black color
		if ( $contrastratio > 5 ) {
			return '#000000';
		} else {
			// if not, return white color.
			return '#FFFFFF';
		}
	}
}

/**
 * Review affiliate button
 *
 * @param [type] $post_id
 * @return void
 */
if ( ! function_exists( 'affreviews_get_aff_button' ) ) {
	function affreviews_get_aff_button( $post_id, $button_text = null ) {
		if ( ! $post_id ) {
			return;
		}

		$button_text = $button_text ?? __( 'Check Best Deals', 'affreviews' );
		$afflink     = get_post_meta( $post_id, 'affreviews_afflink', true );

		if ( empty( $afflink ) ) {
			return;
		}

		$button_atts = apply_filters( 'affreviews_aff_button_atts', 'target="_blank" rel="nofollow"' );

		$output  = '<div class="affr-button">';
		$output .= '<a href="' . $afflink . '" class="affr-button-el" ' . $button_atts . '>' . $button_text;
		$output .= '</a></div><!-- /.affr-button -->';

		return $output;
	}
}

/**
 * Review terms
 *
 * @param [type] $post_id
 * @return void
 */
if ( ! function_exists( 'affreviews_get_terms' ) ) {
	function affreviews_get_terms( $post_id ) {
		if ( ! $post_id ) {
			return;
		}

		$terms = get_post_meta( $post_id, 'affreviews_terms', true );
		if ( empty( $terms ) ) {
			return;
		}

		$output  = '<div class="affr-terms">';
		$output .= '<p>' . nl2br( $terms ) . '</p>';
		$output .= '</div><!-- /.affr-terms -->';

		return $output;
	}
}

/**
 * Review description
 *
 * @param [type] $post_id
 * @return void
 */
if ( ! function_exists( 'affreviews_get_description' ) ) {
	function affreviews_get_description( $post_id ) {
		if ( ! $post_id ) {
			return;
		}

		$descr = get_post_meta( $post_id, 'affreviews_description', true );
		if ( empty( $descr ) ) {
			return;
		}

		$output  = '<div class="affr-description">';
		$output .= '<p>' . nl2br( $descr ) . '</p>';
		$output .= '</div><!-- /.affr-description -->';

		return $output;
	}
}

/**
 * Set CSS variables to the head
 *
 * @return void
 */
if ( ! function_exists( 'affreviews_register_css_vars' ) ) {
	function affreviews_register_css_vars( $plugin_name = 'affreviews' ) {
		$settings = get_option( 'affreviews_visual_settings' );
		if ( empty( $settings ) ) {
			return;
		}
		$css  = ':root {';
		$css .= isset( $settings['button_color'] ) ? "--affr-button-color:{$settings['button_color']};" : '';
		$css .= isset( $settings['button_text_color'] ) ? "--affr-button-text-color:{$settings['button_text_color']};" : '';
		$css .= isset( $settings['button_radius'] ) ? "--affr-button-radius:{$settings['button_radius']};" : '';
		$css .= isset( $settings['button_font_weight'] ) ? "--affr-button-font-weight:{$settings['button_font_weight']};" : '';
		$css .= isset( $settings['button_font_size'] ) ? "--affr-button-font-size:{$settings['button_font_size']};" : '';
		$css .= isset( $settings['button_padding'] ) ? "--affr-button-padding:{$settings['button_padding']['top']} {$settings['button_padding']['left']} {$settings['button_padding']['bottom']} {$settings['button_padding']['right']};" : '';
		$css .= isset( $settings['secondary_color'] ) ? "--affr-secondary-color:{$settings['secondary_color']};" : '';
		$css .= isset( $settings['rating_color'] ) ? "--affr-rating-color:{$settings['rating_color']};" : '';
		$css .= isset( $settings['link_color'] ) ? "--affr-link-color:{$settings['link_color']};" : '';
		$css .= isset( $settings['box_bg_color'] ) ? "--affr-box-bg-color:{$settings['box_bg_color']};" : '';
		$css .= isset( $settings['text_color'] ) ? "--affr-text-color:{$settings['text_color']};" : '';
		$css .= '}';
		wp_add_inline_style( $plugin_name, $css );
	}
}
