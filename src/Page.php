<?php
namespace Inc2734\WP_Breadcrumbs;

class Page extends AbstractBreadcrumbs {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$this->set_ancestors( get_the_ID(), 'page' );
		$this->set( get_the_title() );
	}
}
