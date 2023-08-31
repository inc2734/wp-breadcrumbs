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
		$post_type        = $this->get_post_type();
		$post_type_object = get_post_type_object( $post_type );

		if ( $post_type ) {
			$this->set_terms( $post_type_object );
		}

		if ( $post_type_object->hierarchical ) {
			$this->set_ancestors( get_the_ID(), $post_type );
		}

		$this->set( get_the_title(), get_permalink() );
	}

	/**
	 * Sets Breadcrumbs items of terms.
	 *
	 * @param object $post_type_object The post type object.
	 * @return void
	 */
	protected function set_terms( $post_type_object ) {
		$taxonomies = get_object_taxonomies( $post_type_object->name );
		if ( ! $taxonomies ) {
			return;
		}

		$main_taxonomy = null;
		$main_term     = null;

		foreach ( $taxonomies as $taxonomy ) {
			$terms = get_the_terms( get_the_ID(), $taxonomy );
			if ( ! $terms ) {
				continue;
			}

			$main_taxonomy = $taxonomy;
			break;
		}

		$main_taxonomy = apply_filters( 'inc2734_wp_breadcrumbs_main_taxonomy', $main_taxonomy, $taxonomies, $post_type_object );
		$terms         = get_the_terms( get_the_ID(), $main_taxonomy );
		if ( ! $terms ) {
			return;
		}

		$main_term = apply_filters( 'inc2734_wp_breadcrumbs_main_term', $terms[0], $terms, $main_taxonomy, get_the_ID() );

		$this->set_ancestors( $main_term->term_id, $taxonomy );
		$this->set( $main_term->name, get_term_link( $main_term ) );
	}
}
