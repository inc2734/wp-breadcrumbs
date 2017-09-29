<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Blog item of breadcrumbs
 */
class Inc2734_WP_Breadcrumbs_Blog extends Inc2734_WP_Breadcrumbs_Abstract_Controller {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$post_type = $this->get_post_type();
		if ( ( is_category() || is_tag() || is_date() || is_author() ) || ( is_single() && 'post' === $post_type ) ) {
			$show_on_front  = get_option( 'show_on_front' );
			$page_for_posts = get_option( 'page_for_posts' );
			if ( 'page' === $show_on_front && $page_for_posts ) {
				$this->set( get_the_title( $page_for_posts ), get_permalink( $page_for_posts ) );
			}
		}
	}
}
