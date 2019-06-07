<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs\Controller;

use Inc2734\WP_Breadcrumbs\Contract\Controller\Controller as Base;

/**
 * Search item of breadcrumbs
 */
class Search extends Base {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$this->set(
			sprintf(
				/* translators: %1$s: Search query */
				__( 'Search results of "%1$s"', 'inc2734-wp-breadcrumbs' ),
				get_search_query()
			)
		);
	}
}
