<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs\Contract\Controller;

/**
 * Abstract breadcrumbs item class
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class Controller {

	/**
	 * Store each item of breadcrumbs in ascending order.
	 *
	 * @var array
	 */
	protected $breadcrumbs = [];

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->set_items();
	}

	/**
	 * Sets breadcrumbs items.
	 *
	 * @return void
	 */
	abstract protected function set_items();

	/**
	 * Adds a item.
	 *
	 * @param string $title Title.
	 * @param string $link  Link url.
	 */
	protected function set( $title, $link = '' ) {
		$this->breadcrumbs[] = [
			'title' => $title,
			'link'  => $link,
		];
	}

	/**
	 * Set the ancestors of the specified page or taxonomy.
	 *
	 * @param int    $object_id   Post ID or Term ID.
	 * @param string $object_type Related post type.
	 */
	protected function set_ancestors( $object_id, $object_type ) {
		$ancestors = get_ancestors( $object_id, $object_type );
		krsort( $ancestors );

		$post_types = get_post_types(
			[
				'hierarchical' => true,
				'public'       => true,
			]
		);

		if ( in_array( $object_type, $post_types, true ) ) {
			foreach ( $ancestors as $ancestor_id ) {
				$this->set( get_the_title( $ancestor_id ), get_permalink( $ancestor_id ) );
			}
		} else {
			foreach ( $ancestors as $ancestor_id ) {
				$ancestor = get_term( $ancestor_id, $object_type );
				$this->set( $ancestor->name, get_term_link( $ancestor ) );
			}
		}
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
	 * Return year label.
	 *
	 * @param int $year Year.
	 * @return string
	 */
	public function year( $year ) {
		if ( 'ja' === get_locale() ) {
			$year .= '年';
		}
		return $year;
	}

	/**
	 * Return month label.
	 *
	 * @param int $month Month.
	 * @return string
	 */
	public function month( $month ) {
		if ( 'ja' === get_locale() ) {
			$month .= '月';
		} else {
			$monthes = [
				1  => 'January',
				2  => 'February',
				3  => 'March',
				4  => 'April',
				5  => 'May',
				6  => 'June',
				7  => 'July',
				8  => 'August',
				9  => 'September',
				10 => 'October',
				11 => 'November',
				12 => 'December',
			];
			$month   = $monthes[ $month ];
		}
		return $month;
	}

	/**
	 * Return day label.
	 *
	 * @param int $day Day.
	 * @return string
	 */
	public function day( $day ) {
		if ( 'ja' === get_locale() ) {
			$day .= '日';
		}
		return $day;
	}

	/**
	 * Return breadcrumbs items
	 *
	 * @return array
	 */
	public function get() {
		return $this->breadcrumbs;
	}
}
