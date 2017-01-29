<?php
namespace Inc2734\WP_Breadcrumbs;

class Tag extends AbstractBreadcrumbs {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$this->set( single_tag_title( '', false ) );
	}
}
