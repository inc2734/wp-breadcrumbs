<?php
class Inc2734_WP_Breadcrumbs_Search extends Inc2734_WP_Breadcrumbs_Abstract_Controller {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$this->set(
			sprintf(
				__( '「%s」の検索結果' ),
				get_search_query()
			)
		);
	}
}
