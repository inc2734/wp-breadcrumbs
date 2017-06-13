<?php
namespace Inc2734\WP_Breadcrumbs;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Breadcrumbs {

	/**
	 * $WP_Breadcrumbs
	 * @var Inc2734_WP_Breadcrumbs
	 */
	protected $WP_Breadcrumbs;

	/**
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 */
	public function __construct() {
		include_once( __DIR__ . '/wp-breadcrumbs.php' );
		$this->WP_Breadcrumbs = new \Inc2734_WP_Breadcrumbs();
	}

	/**
	 * Gets breadcrumbs items
	 *
	 * @return array
	 */
	public function get() {
		return $this->WP_Breadcrumbs->get();
	}
}
