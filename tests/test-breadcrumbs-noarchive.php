<?php
class BreadcrumbsTestNoarchive extends WP_UnitTestCase {

	public function setup() {
		global $wp_rewrite;
		parent::setup();

		$wp_rewrite->init();
		$wp_rewrite->set_permalink_structure( '/%year%/%monthnum%/%day%/%postname%/' );

		$this->author_id     = $this->factory->user->create();
		$this->post_ids      = $this->factory->post->create_many( 20, [ 'post_author' => $this->author_id ] );
		$this->front_page_id = $this->factory->post->create( [ 'post_type' => 'page', 'post_title' => 'HOME' ] );
		$this->blog_page_id  = $this->factory->post->create( [ 'post_type' => 'page', 'post_title' => 'BLOG' ] );
		$this->tag_id        = $this->factory->term->create( array( 'taxonomy' => 'post_tag' ) );
		$this->post_type     = rand_str( 12 );
		$this->taxonomy      = rand_str( 12 );

		register_post_type(
			$this->post_type,
			[
				'public'      => true ,
				'taxonomies'  => ['category'],
				'has_archive' => false
			]
		);

		register_taxonomy(
			$this->taxonomy,
			$this->post_type,
			[
				'public' => true,
			]
		);

		foreach( $this->post_ids as $post_id ) {
			wp_set_object_terms( $post_id, get_term( $this->tag_id, 'post_tag' )->slug, 'post_tag' );
		}

		create_initial_taxonomies();
		$wp_rewrite->flush_rules();
	}

	public function tearDown() {
		parent::tearDown();

		update_option( 'show_on_front', 'posts' );
		update_option( 'page_on_front', 0 );
		update_option( 'page_for_posts', 0 );
		_unregister_post_type( $this->post_type );
		_unregister_taxonomy( $this->taxonomy, $this->post_type );
	}

	public function test_single() {
		// Post
		$newest_post = get_post( $this->post_ids[0] );
		$categories = get_the_category( $newest_post );
		$this->go_to( get_permalink( $newest_post ) );
		$breadcrumbs = new \Inc2734\WP_Breadcrumbs\Breadcrumbs();
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://example.org' ],
				[ 'title' => $categories[0]->name, 'link' => get_term_link( $categories[0] ) ],
				[ 'title' => get_the_title( $newest_post ), 'link' => '' ],
			],
			$breadcrumbs->get()
		);

		// Custom post with has_archive = false
		$custom_post_type_id = $this->factory->post->create( [ 'post_type' => $this->post_type ] );
		$custom_post = get_post( $custom_post_type_id );
		$this->go_to( get_permalink( $custom_post_type_id ) );
		$breadcrumbs = new \Inc2734\WP_Breadcrumbs\Breadcrumbs();
		$post_type_object = get_post_type_object( $custom_post->post_type );
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://example.org' ],
				[ 'title' => get_the_title( $custom_post_type_id ), 'link' => '' ],
			],
			$breadcrumbs->get()
		);
	}

}
