<?php
namespace Inc2734\WP_Breadcrumbs;

class FrontPage extends AbstractBreadcrumbs {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$home_label = $this->get_home_label();

		if ( is_front_page() ) {
			$this->set( $home_label );
		} else {
			$this->set( $home_label, home_url() );
		}
	}

	/**
	 * Return front page label
	 *
	 * @return string
	 */
	protected function get_home_label() {
		$page_on_front = get_option( 'page_on_front' );
		$home_label    = __( 'ホーム' );
		if ( $page_on_front ) {
			$home_label = get_the_title( $page_on_front );
		}
		return $home_label;
	}
}
