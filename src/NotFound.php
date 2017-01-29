<?php
namespace Inc2734\WP_Breadcrumbs;

class NotFound extends AbstractBreadcrumbs {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$this->set( __( 'ページが見つかりませんでした' ) );
	}
}
