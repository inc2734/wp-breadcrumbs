<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs\Controller;

/**
 * Not found item of breadcrumbs
 */
class Not_Found extends Controller {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$this->set( __( 'Page not found', 'inc2734-wp-breadcrumbs' ) );
	}
}
