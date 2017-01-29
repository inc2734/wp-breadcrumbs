<?php
namespace Inc2734\WP_Breadcrumbs;

class Year extends AbstractBreadcrumbs {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$year = get_query_var( 'year' );
		if ( ! $year ) {
			$ymd  = get_query_var( 'm' );
			$year = $ymd;
		}
		$this->set( $this->year( $year ) );
	}
}
