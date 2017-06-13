<?php
class Inc2734_WP_Breadcrumbs_Not_Found extends Inc2734_WP_Breadcrumbs_Abstract_Controller {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$this->set( __( 'ページが見つかりませんでした' ) );
	}
}
