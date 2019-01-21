<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs\Controller;

use Inc2734\WP_Breadcrumbs\Contract\Controller\Controller as Base;

/**
 * Month item of breadcrumbs
 */
class Month extends Base {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$year = get_query_var( 'year' );
		if ( $year ) {
			$month = get_query_var( 'monthnum' );
		} else {
			$ymd   = get_query_var( 'm' );
			$year  = substr( $ymd, 0, 4 );
			$month = substr( $ymd, -2 );
		}
		$this->set( $this->year( $year ), get_year_link( $year ) );
		$this->set( $this->month( $month ) );
	}
}
