<?php

/*
 * Template Name: test Template
 */
/**
*/
//function get_the_content( $more_link_text = null, $strip_teaser = false ) {
//	global $page, $more, $preview, $pages, $multipage;
//
//	$post = get_post();
//        
//
//	if ( null === $more_link_text ) {
//		$more_link_text = sprintf(
//			'<span aria-label="%1$s">%2$s</span>',
//			sprintf(
//				/* translators: %s: Name of current post */
//				__( 'Continue reading %s' ),
//				the_title_attribute( array( 'echo' => false ) )
//			),
//			__( '(more&hellip;)' )
//		);
//	}
//
//	$output = '';
//	$has_teaser = false;
//
//	// If post password required and it doesn't match the cookie.
//	if ( post_password_required( $post ) )
//		return get_the_password_form( $post );
//
//	if ( $page > count( $pages ) ) // if the requested page doesn't exist
//		$page = count( $pages ); // give them the highest numbered page that DOES exist
//
//	$content = $pages[$page - 1];
//	if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
//		$content = explode( $matches[0], $content, 2 );
//		if ( ! empty( $matches[1] ) && ! empty( $more_link_text ) )
//			$more_link_text = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );
//
//		$has_teaser = true;
//	} else {
//		$content = array( $content );
//	}
//
//	if ( false !== strpos( $post->post_content, '<!--noteaser-->' ) && ( ! $multipage || $page == 1 ) )
//		$strip_teaser = true;
//
//	$teaser = $content[0];
////        if(isset($post) && $post->post_name == 'competition'){
////            if(isset($_GET['competition'])){
////              $teaser = str_replace('[$$###COMP###$$]',$_GET['competition'], $teaser);
////            }
////            if(isset($_GET['leaguetbl'])){
////                $teaser = str_replace('[$$###LEAGUETABLE###$$]', $_GET['leaguetbl'], $teaser);
////            }
////            if(isset($_GET['tid'])){
////                $teaser = str_replace('[$$###TID###$$]', $_GET['tid'], $teaser);
////            }
////        }
//        //echo htmlspecialchars($teaser);exit;
//	if ( $more && $strip_teaser && $has_teaser )
//		$teaser = '';
//
//	$output .= $teaser;
//
//	if ( count( $content ) > 1 ) {
//		if ( $more ) {
//			$output .= '<span id="more-' . $post->ID . '"></span>' . $content[1];
//		} else {
//			if ( ! empty( $more_link_text ) )
//
//				/**
//				 * Filters the Read More link text.
//				 *
//				 * @since 2.8.0
//				 *
//				 * @param string $more_link_element Read More link element.
//				 * @param string $more_link_text    Read More text.
//				 */
//				$output .= apply_filters( 'the_content_more_link', ' <a href="' . get_permalink() . "#more-{$post->ID}\" class=\"more-link\">$more_link_text</a>", $more_link_text );
//			$output = force_balance_tags( $output );
//		}
//	}
//
//	if ( $preview ) // Preview fix for JavaScript bug with foreign languages.
//		$output =	preg_replace_callback( '/\%u([0-9A-F]{4})/', '_convert_urlencoded_to_entities', $output );
//
//	return $output;
//}