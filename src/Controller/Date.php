<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs\Controller;

use Inc2734\WP_Breadcrumbs\Contract\Controller\Controller as Base;

/**
 * Date items of breadcrumbs
 */
class Date extends Base {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$year  = get_query_var( 'year' );
		$month = get_query_var( 'monthnum' );
		$day   = get_query_var( 'day' );
		$this->set( $year, get_year_link( $year ) );
		if ( is_month() || is_day() ) {
			$this->set( trim(single_month_title( ' ', false )), get_month_link( $year, $month ) );	
		}
		if ( is_day() ) {
			$this->set( get_the_date(), get_day_link( $year, $month, $day ) );	
		}
	}
}
