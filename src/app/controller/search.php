<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Search item of breadcrumbs
 */
class Inc2734_WP_Breadcrumbs_Search extends Inc2734_WP_Breadcrumbs_Abstract_Controller {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$this->set(
			sprintf(
				__( 'Search results of "%1$s"', 'inc2734-wp-breadcrumbs' ),
				get_search_query()
			)
		);
	}
}
