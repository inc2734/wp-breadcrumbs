<?php
class Inc2734_WP_Breadcrumbs_Front_Page extends Inc2734_WP_Breadcrumbs_Abstract_Controller {

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
		if ( 'ja' === get_locale() ) {
			$home_label = __( 'ホーム' );
		} else {
			$home_label = __( 'Home' );
		}
		if ( $page_on_front ) {
			$home_label = get_the_title( $page_on_front );
		}
		return $home_label;
	}
}
