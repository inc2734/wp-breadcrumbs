<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs\Controller;

/**
 * Front page item of breadcrumbs
 */
class Front_Page extends Controller {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$home_label = $this->get_home_label();

		if ( is_front_page() ) {
			$this->set( $home_label );
		} else {
			$this->set( $home_label, home_url() );
		}
	}

	/**
	 * Return front page label
	 *
	 * @return string
	 */
	protected function get_home_label() {
		$page_on_front = get_option( 'page_on_front' );
		$home_label = __( 'Home', 'inc2734-wp-breadcrumbs' );
		if ( $page_on_front ) {
			$home_label = get_the_title( $page_on_front );
		}
		return $home_label;
	}
}
