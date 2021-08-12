<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs;

use Inc2734\WP_Breadcrumbs\Controller;

class Bootstrap {

	/**
	 * Store each item of breadcrumbs in ascending order
	 *
	 * @var array
	 */
	protected $breadcrumbs = [];

	/**
	 * Constructor
	 */
	public function __construct() {
		load_textdomain( 'inc2734-wp-breadcrumbs', __DIR__ . '/languages/' . get_locale() . '.mo' );

		$breadcrumb = new Controller\Front_Page();
		$this->_set_items( $breadcrumb->get() );

		$post_type        = $this->get_post_type();
		$post_type_object = get_post_type_object( $post_type );

		if ( 'post' === $post_type || ( '' === $post_type && ! is_tax() ) ) {
			$breadcrumb = new Controller\Blog();
			$this->_set_items( $breadcrumb->get() );
		} elseif ( is_tax() ) {
			$breadcrumb = new Controller\Post_Type_Archive();
			$this->_set_items( $breadcrumb->get() );
		} elseif ( $post_type && ! empty( $post_type_object->has_archive ) ) {
			$breadcrumb = new Controller\Post_Type_Archive();
			$this->_set_items( $breadcrumb->get() );
		}

		$controllers = array_filter(
			[
				'Not_Found'  => is_404(),
				'Search'     => is_search(),
				'Taxonomy'   => is_tax() || is_category() || is_tag(),
				'Attachment' => is_attachment(),
				'Page'       => is_page() && ! is_front_page(),
				'Single'     => is_single(),
				'Author'     => is_author(),
				'Date'       => is_date(),
				'Home'       => is_home() && ! is_front_page(),
			]
		);

		if ( ! $controllers ) {
			return;
		}

		$class = '\Inc2734\WP_Breadcrumbs\Controller\\' . key( $controllers );
		if ( ! class_exists( $class ) ) {
			return;
		}

		$breadcrumb = new $class();
		$this->_set_items( $breadcrumb->get() );
	}

	/**
	 * Sets breadcrumbs items.
	 *
	 * @param array $items Array of items.
	 * @return void
	 */
	protected function _set_items( $items ) {
		foreach ( $items as $item ) {
			$this->_set( $item['title'], $item['link'] );
		}
	}

	/**
	 * Adds a item.
	 *
	 * @param string $title Title.
	 * @param string $link  Link url.
	 */
	protected function _set( $title, $link = '' ) {
		$this->breadcrumbs[] = [
			'title' => $title,
			'link'  => $link,
		];
	}

	/**
	 * Return the current post type.
	 *
	 * @return string
	 */
	protected function get_post_type() {
		$post_type = get_post_type();
		if ( $post_type ) {
			return $post_type;
		}

		if ( is_category() ) {
			$taxonomy_object = get_taxonomy( 'category' );
			return $taxonomy_object->object_type[0];
		} elseif ( is_tag() ) {
			$taxonomy_object = get_taxonomy( 'post_tag' );
			return $taxonomy_object->object_type[0];
		} elseif ( is_tax() ) {
			$term            = get_query_var( 'taxonomy' );
			$taxonomy_object = get_taxonomy( $term );
			return $taxonomy_object->object_type[0];
		} elseif ( is_archive() ) {
			return get_query_var( 'post_type' );
		} elseif ( is_home() ) {
			return 'post';
		}

		return $post_type;
	}

	/**
	 * Gets breadcrumbs items
	 *
	 * @return array
	 */
	public function get() {
		$remove_link = apply_filters( 'inc2734_wp_breadcrumbs_remove_last_link', true );
		foreach ( $this->breadcrumbs as $k => $item ) {
			if ( count( $this->breadcrumbs ) === $k + 1 && $remove_link ) {
				unset( $item['link'] );
			}
		}
		return apply_filters( 'inc2734_wp_breadcrumbs', $this->breadcrumbs );
	}
}
