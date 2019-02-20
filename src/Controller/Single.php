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

		$this->set( get_the_title() );
	}

	/**
	 * Sets Breadcrumbs items of post type archive
	 *
	 * @param object $post_type_object
	 * @return void
	 */
	protected function set_post_type_archive( $post_type_object ) {
		$label = $post_type_object->label;
		$this->set( $label, $this->get_post_type_archive_link( $post_type_object->name ) );
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

		$taxonomy = apply_filters( 'inc2734_wp_breadcrumbs_main_taxonomy', array_shift( $taxonomies ), $taxonomies, $post_type_object->name );
		$terms    = get_the_terms( get_the_ID(), $taxonomy );

		if ( ! $terms ) {
			return;
		}

		$term = array_shift( $terms );
		$this->set_ancestors( $term->term_id, $taxonomy );
		$this->set( $term->name, get_term_link( $term ) );
	}

	/**
	 * Sets Breadcrumbs items of categories
	 *
	 * @return void
	 */
	protected function set_categories() {
		$categories = get_the_category( get_the_ID() );
		if ( $categories ) {
			$category = array_shift( $categories );
			$this->set_ancestors( $category->term_id, 'category' );
			$this->set( $category->name, get_term_link( $category ) );
		}
	}
}
