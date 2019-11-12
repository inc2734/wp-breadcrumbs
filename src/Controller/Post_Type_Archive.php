<?php
/**
 * @package inc2734/wp-breadcrumbs
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Breadcrumbs\Controller;

use Inc2734\WP_Breadcrumbs\Contract\Controller\Controller as Base;

/**
 * Post type archive item of breadcrumbs
 */
class Post_Type_Archive extends Base {

	/**
	 * Sets breadcrumbs items
	 *
	 * @return void
	 */
	protected function set_items() {
		$post_type = $this->get_post_type();
		if ( ! $post_type || 'post' === $post_type ) {
			return;
		}

		$post_type_object = get_post_type_object( $post_type );
		if ( ! $post_type_object->has_archive ) {
			return;
		}

		$this->set( $post_type_object->label, get_post_type_archive_link( $post_type ) );
	}
}
