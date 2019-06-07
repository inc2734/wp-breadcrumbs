<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs\Controller;

use Inc2734\WP_Breadcrumbs\Contract\Controller\Controller as Base;

/**
 * Author item of breadcrumbs
 */
class Author extends Base {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$user = get_queried_object();
		$display_name = get_the_author_meta( 'display_name', $user->ID );
		$this->set( $display_name, get_author_posts_url( $user->ID ) );
	}
}
