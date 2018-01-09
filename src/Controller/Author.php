<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs\Controller;

/**
 * Author item of breadcrumbs
 */
class Author extends Controller {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$author_id = get_query_var( 'author' );
		$this->set( get_the_author_meta( 'display_name', $author_id ) );
	}
}
