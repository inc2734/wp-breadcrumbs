<?php
class Inc2734_WP_Breadcrumbs_Tag extends Inc2734_WP_Breadcrumbs_Abstract_Controller {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$this->set( single_tag_title( '', false ) );
	}
}