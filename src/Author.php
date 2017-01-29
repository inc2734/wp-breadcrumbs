<?php
namespace Inc2734\WP_Breadcrumbs;

class Author extends AbstractBreadcrumbs {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$author_id = get_query_var( 'author' );
		$this->set( get_the_author_meta( 'display_name', $author_id ) );
	}
}
