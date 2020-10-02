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

		if ( is_year() ) {
			$title = preg_replace( '|^[^:]*:|', '', get_the_archive_title() );
			$this->set( trim( $title ), $this->get_year_link( $year ) );
			return;
		}

		// phpcs:disable WordPress.WP.I18n.MissingArgDomain
		$this->set( get_the_date( _x( 'Y', 'yearly archives date format' ) ), $this->get_year_link( $year ) );
		// phpcs:enable

		if ( is_month() ) {
			$title = preg_replace( '|^[^:]*:|', '', get_the_archive_title() );
			$this->set( trim( $title ), $this->get_month_link( $year, $month ) );
			return;
		}

		// phpcs:disable WordPress.WP.I18n.MissingArgDomain
		$this->set( get_the_date( _x( 'F', 'monthly archives date format' ) ), $this->get_month_link( $year, $month ) );
		// phpcs:enable

		if ( is_day() ) {
			$this->set( get_the_date(), $this->get_day_link( $year, $month, $day ) );
		}
	}

	/**
	 * Return year archive url.
	 *
	 * @param int $year Year.
	 */
	protected function get_year_link( $year ) {
		$post_type = $this->get_post_type();
		$url       = get_year_link( $year );
		$url       = ( 'post' !== $post_type ) ? add_query_arg( 'post_type', $post_type, $url ) : $url;
		return $url;
	}

	/**
	 * Return month archive url.
	 *
	 * @param int $year Year.
	 * @param int $month Month.
	 */
	protected function get_month_link( $year, $month ) {
		$post_type = $this->get_post_type();
		$url       = get_month_link( $year, $month );
		$url       = ( 'post' !== $post_type ) ? add_query_arg( 'post_type', $post_type, $url ) : $url;
		return $url;
	}

	/**
	 * Return day archive url.
	 *
	 * @param int $year Year.
	 * @param int $month Month.
	 * @param int $day Day.
	 */
	protected function get_day_link( $year, $month, $day ) {
		$post_type = $this->get_post_type();
		$url       = get_day_link( $year, $month, $day );
		$url       = ( 'post' !== $post_type ) ? add_query_arg( 'post_type', $post_type, $url ) : $url;
		return $url;
	}
}
