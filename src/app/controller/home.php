<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Home item of breadcrumbs
 */
class Inc2734_WP_Breadcrumbs_Home extends Inc2734_WP_Breadcrumbs_Abstract_Controller {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$show_on_front  = get_option( 'show_on_front' );
		$page_for_posts = get_option( 'page_for_posts' );
		if ( 'page' === $show_on_front && $page_for_posts ) {
			$title = get_the_title( $page_for_posts );
			$this->set( $title );
		}
	}
}
