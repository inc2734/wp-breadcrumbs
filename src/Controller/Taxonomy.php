<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs\Controller;

use Inc2734\WP_Breadcrumbs\Contract\Controller\Controller as Base;

/**
 * Taxonomy item of breadcrumbs
 */
class Taxonomy extends Base {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$term     = get_queried_object();
		$taxonomy = $term->taxonomy;

		if ( is_taxonomy_hierarchical( $taxonomy ) && $term->parent ) {
			$this->set_ancestors( $term->term_id, $taxonomy );
		}

		$this->set( $term->name, get_term_link( $term ) );
	}
}
