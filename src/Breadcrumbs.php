<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs;

use Inc2734\WP_Breadcrumbs\Controller;

/**
 * Create array for breadcrumbs
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Breadcrumbs {

	/**
	 * Store each item of breadcrumbs in ascending order
	 * @var array
	 */
	protected $breadcrumbs = [];

	/**
	 * @todo
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 */
	public function __construct() {
		load_textdomain( 'inc2734-wp-breadcrumbs', __DIR__ . '/languages/' . get_locale() . '.mo' );

		$breadcrumb = new Controller\Front_Page();
		$this->_set_items( $breadcrumb->get() );

		$breadcrumb = new Controller\Blog();
		$this->_set_items( $breadcrumb->get() );

		if ( is_404() ) {
			$breadcrumb = new Controller\Not_Found();
		} elseif ( is_search() ) {
			$breadcrumb = new Controller\Search();
		} elseif ( is_tax() ) {
			$breadcrumb = new Controller\Taxonomy();
		} elseif ( is_attachment() ) {
			$breadcrumb = new Controller\Attachment();
		} elseif ( is_page() && ! is_front_page() ) {
			$breadcrumb = new Controller\Page();
		} elseif ( is_post_type_archive() ) {
			$breadcrumb = new Controller\Post_Type_Archive();
		} elseif ( is_single() ) {
			$breadcrumb = new Controller\Single();
		} elseif ( is_category() ) {
			$breadcrumb = new Controller\Category();
		} elseif ( is_tag() ) {
			$breadcrumb = new Controller\Tag();
		} elseif ( is_author() ) {
			$breadcrumb = new Controller\Author();
		} elseif ( is_day() ) {
			$breadcrumb = new Controller\Day();
		} elseif ( is_month() ) {
			$breadcrumb = new Controller\Month();
		} elseif ( is_year() ) {
			$breadcrumb = new Controller\Year();
		} elseif ( is_home() && ! is_front_page() ) {
			$breadcrumb = new Controller\Home();
		}

		$this->_set_items( $breadcrumb->get() );
	}

	/**
	 * Sets breadcrumbs items
	 *
	 * @param array $items
	 * @return void
	 */
	protected function _set_items( $items ) {
		foreach ( $items as $item ) {
			$this->_set( $item['title'], $item['link'] );
		}
	}

	/**
	 * Adds a item
	 *
	 * @param string $title
	 * @param string $link
	 */
	protected function _set( $title, $link = '' ) {
		$this->breadcrumbs[] = [
			'title' => $title,
			'link'  => $link,
		];
	}

	/**
	 * Gets breadcrumbs items
	 *
	 * @return array
	 */
	public function get() {
		return apply_filters( 'inc2734_wp_breadcrumbs', $this->breadcrumbs );
	}
}
