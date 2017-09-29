<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Author item of breadcrumbs
 */
class Inc2734_WP_Breadcrumbs_Author extends Inc2734_WP_Breadcrumbs_Abstract_Controller {

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
