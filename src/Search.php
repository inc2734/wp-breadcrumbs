<?php
namespace Inc2734\WP_Breadcrumbs;

class Search extends AbstractBreadcrumbs {

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
