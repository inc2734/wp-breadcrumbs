<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs\Controller;

use Inc2734\WP_Breadcrumbs\Contract\Controller\Controller as Base;

/**
 * Single item of breadcrumbs
 */
class Single extends Base {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$post_type = $this->get_post_type();
		$post_type_object = get_post_type_object( $post_type );

		if ( $post_type && 'post' !== $post_type ) {
			if ( $post_type_object->has_archive ) {
				$this->set_post_type_archive( $post_type_object );
			}
			$this->set_terms( $post_type_object );
		} else {
			$this->set_categories();
		}

		$this->set( get_the_title(), get_permalink() );
	}

	/**
	 * Sets Breadcrumbs items of post type archive
	 *
	 * @param object $post_type_object
	 * @return void
	 */
	protected function set_post_type_archive( $post_type_object ) {
		$label = $post_type_object->label;
		$this->set( $label, get_post_type_archive_link( $post_type_object->name ) );
	}

	/**
	 * Sets Breadcrumbs items of terms
	 *
	 * @param object $post_type_object
	 * @return void
	 */
	protected function set_terms( $post_type_object ) {
		$taxonomies = get_object_taxonomies( $post_type_object->name );
		if ( ! $taxonomies ) {
			return;
		}

		$taxonomy = apply_filters( 'inc2734_wp_breadcrumbs_main_taxonomy', array_shift( $taxonomies ), $taxonomies, $post_type_object );
		$terms    = get_the_terms( get_the_ID(), $taxonomy );

		if ( ! $terms ) {
			return;
		}

		if ( count( $terms ) > 1 ) {
			$main_term = apply_filters( 'inc2734_wp_breadcrumbs_main_term', array_shift( $terms ), $terms, $taxonomy, get_the_ID() );
		} else {
			$main_term = $terms[0];
		}

		$this->set_ancestors( $main_term->term_id, $taxonomy );
		$this->set( $main_term->name, get_term_link( $main_term ) );
	}

	/**
	 * Sets Breadcrumbs items of categories
	 *
	 * @return void
	 */
	protected function set_categories() {
		$categories = get_the_category( get_the_ID() );

		if ( $categories ) {
			if ( count( $categories ) > 1 ) {
				$main_category = apply_filters( 'inc2734_wp_breadcrumbs_main_term', array_shift( $categories ), $categories, 'category', get_the_ID() );
			} else {
				$main_category = $categories[0];
			}
			$this->set_ancestors( $main_category->term_id, 'category' );
			$this->set( $main_category->name, get_term_link( $main_category ) );
		}
	}
}
