<?php
namespace Inc2734\WP_Breadcrumbs;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Breadcrumbs {

	/**
	 * Store each item of breadcrumbs in ascending order
	 * @var array
	 */
	protected $breadcrumbs = [];

	/**
	 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
	 */
	public function __construct() {
		$breadcrumb = new FrontPage();
		$this->set_items( $breadcrumb->get() );

		$breadcrumb = new Blog();
		$this->set_items( $breadcrumb->get() );

		if ( is_404() ) {
			$breadcrumb = new NotFound();
		} elseif ( is_search() ) {
			$breadcrumb = new Search();
		} elseif ( is_tax() ) {
			$breadcrumb = new Taxonomy();
		} elseif ( is_attachment() ) {
			$breadcrumb = new Attachment();
		} elseif ( is_page() && ! is_front_page() ) {
			$breadcrumb = new Page();
		} elseif ( is_post_type_archive() ) {
			$breadcrumb = new PostTypeArchive();
		} elseif ( is_single() ) {
			$breadcrumb = new Single();
		} elseif ( is_category() ) {
			$breadcrumb = new Category();
		} elseif ( is_tag() ) {
			$breadcrumb = new Tag();
		} elseif ( is_author() ) {
			$breadcrumb = new Author();
		} elseif ( is_day() ) {
			$breadcrumb = new Day();
		} elseif ( is_month() ) {
			$breadcrumb = new Month();
		} elseif ( is_year() ) {
			$breadcrumb = new Year();
		} elseif ( is_home() && ! is_front_page() ) {
			$breadcrumb = new Home();
		}

		$this->set_items( $breadcrumb->get() );
	}

	/**
	 * Sets breadcrumbs items
	 *
	 * @param array $items
	 * @return void
	 */
	protected function set_items( $items ) {
		foreach ( $items as $item ) {
			$this->set( $item['title'], $item['link'] );
		}
	}

	/**
	 * Adds a item
	 *
	 * @param string $title
	 * @param string $link
	 */
	protected function set( $title, $link = '' ) {
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
