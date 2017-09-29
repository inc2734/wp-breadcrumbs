<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Day item of breadcrumbs
 */
class Inc2734_WP_Breadcrumbs_Day extends Inc2734_WP_Breadcrumbs_Abstract_Controller {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$year = get_query_var( 'year' );
		if ( $year ) {
			$month = get_query_var( 'monthnum' );
			$day   = get_query_var( 'day' );
		} else {
			$ymd   = get_query_var( 'm' );
			$year  = substr( $ymd, 0, 4 );
			$month = substr( $ymd, 4, 2 );
			$day   = substr( $ymd, -2 );
		}
		$this->set( $this->year( $year ), get_year_link( $year ) );
		$this->set( $this->month( $month ), get_month_link( $year, $month ) );
		$this->set( $this->day( $day ) );
	}
}
