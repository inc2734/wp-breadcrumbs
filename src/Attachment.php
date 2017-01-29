<?php
namespace Inc2734\WP_Breadcrumbs;

class Attachment extends AbstractBreadcrumbs {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$this->set( get_the_title() );
	}
}
