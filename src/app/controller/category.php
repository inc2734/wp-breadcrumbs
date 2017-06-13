<?php
class Inc2734_WP_Breadcrumbs_Category extends Inc2734_WP_Breadcrumbs_Abstract_Controller {

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
