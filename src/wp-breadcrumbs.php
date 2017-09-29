<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Create array for breadcrumbs
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Inc2734_WP_Breadcrumbs {

	/**
	 * Store each item of breadcrumbs in ascending order
	 * @var array
	 */
	protected $breadcrumbs = array();

	/**
	 * @todo
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 */
	public function __construct() {
		load_textdomain( 'inc2734-wp-breadcrumbs', __DIR__ . '/languages/' . get_locale() . '.mo' );

		$includes = array(
			'/app/abstract',
			'/app/controller',
		);
		foreach ( $includes as $include ) {
			foreach ( glob( __DIR__ . $include . '/*.php' ) as $file ) {
				require_once( $file );
			}
		}

		$breadcrumb = new Inc2734_WP_Breadcrumbs_Front_Page();
		$this->_set_items( $breadcrumb->get() );

		$breadcrumb = new Inc2734_WP_Breadcrumbs_Blog();
		$this->_set_items( $breadcrumb->get() );

		if ( is_404() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Not_Found();
		} elseif ( is_search() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Search();
		} elseif ( is_tax() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Taxonomy();
		} elseif ( is_attachment() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Attachment();
		} elseif ( is_page() && ! is_front_page() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Page();
		} elseif ( is_post_type_archive() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Post_Type_Archive();
		} elseif ( is_single() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Single();
		} elseif ( is_category() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Category();
		} elseif ( is_tag() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Tag();
		} elseif ( is_author() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Author();
		} elseif ( is_day() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Day();
		} elseif ( is_month() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Month();
		} elseif ( is_year() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Year();
		} elseif ( is_home() && ! is_front_page() ) {
			$breadcrumb = new Inc2734_WP_Breadcrumbs_Home();
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
		$this->breadcrumbs[] = array(
			'title' => $title,
			'link'  => $link,
		);
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
