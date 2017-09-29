<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Attachment item of breadcrumbs
 */
class Inc2734_WP_Breadcrumbs_Attachment extends Inc2734_WP_Breadcrumbs_Abstract_Controller {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$this->set( get_the_title() );
	}
}
