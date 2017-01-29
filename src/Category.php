<?php
namespace Inc2734\WP_Breadcrumbs;

class Category extends AbstractBreadcrumbs {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$category_name = single_cat_title( '', false );
		$category_id   = get_cat_ID( $category_name );
		$this->set_ancestors( $category_id, 'category' );
		$this->set( $category_name );
	}
}
