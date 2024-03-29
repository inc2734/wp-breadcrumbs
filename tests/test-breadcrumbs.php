<?php
require_once __DIR__ . '/../vendor/autoload.php';

class BreadcrumbsTest extends WP_UnitTestCase {

	public function set_up() {
		global $wp_rewrite;
		parent::set_up();

		$wp_rewrite->init();
		$wp_rewrite->set_permalink_structure( '/%year%/%monthnum%/%day%/%postname%/' );

		$this->author_id     = $this->factory->user->create();
		$this->post_ids      = $this->factory->post->create_many( 20, [ 'post_author' => $this->author_id ] );
		$this->front_page_id = $this->factory->post->create( [ 'post_type' => 'page', 'post_title' => 'HOME' ] );
		$this->blog_page_id  = $this->factory->post->create( [ 'post_type' => 'page', 'post_title' => 'BLOG' ] );
		$this->tag_id        = $this->factory->term->create( array( 'taxonomy' => 'post_tag' ) );
		$this->category_id   = $this->factory->term->create( array( 'taxonomy' => 'category' ) );

		foreach( $this->post_ids as $post_id ) {
			wp_set_object_terms( $post_id, get_term( $this->tag_id, 'post_tag' )->slug, 'post_tag' );
			wp_set_object_terms( $post_id, get_term( $this->category_id, 'category' )->slug, 'category' );
		}

		$this->post_type = rand_str( 12 );
		$this->taxonomy  = rand_str( 12 );

		register_post_type(
			$this->post_type,
			[
				'public'      => true ,
				'taxonomies'  => [ 'category' ],
				'has_archive' => true
			]
		);

		register_taxonomy(
			$this->taxonomy,
			[ $this->post_type ],
			[
				'public' => true,
			]
		);

		create_initial_taxonomies();
		$wp_rewrite->flush_rules();

		add_filter( 'inc2734_wp_breadcrumbs_remove_last_link', '__return_false' );
	}

	public function tear_down() {
		parent::tear_down();

		update_option( 'show_on_front', 'posts' );
		update_option( 'page_on_front', 0 );
		update_option( 'page_for_posts', 0 );
		_unregister_post_type( $this->post_type );
		_unregister_taxonomy( $this->taxonomy, $this->post_type );
	}

	public function test_front_page() {
		$this->go_to( home_url() );
		$breadcrumbs = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link'  => home_url('/') ]
			],
			$breadcrumbs->get()
		);
	}

	public function test_blog() {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $this->front_page_id );
		update_option( 'page_for_posts', $this->blog_page_id );

		$this->go_to( get_permalink( $this->blog_page_id ) );
		$breadcrumbs = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$this->assertEquals(
			[
				[ 'title' => 'HOME', 'link' => 'http://localhost:8889/' ],
				[ 'title' => 'BLOG', 'link' => get_permalink($this->blog_page_id) ]
			],
			$breadcrumbs->get()
		);
	}

	public function test_category() {
		$category = get_terms( 'category' )[0];
		$this->go_to( get_term_link( $category ) );
		$breadcrumbs = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://localhost:8889/' ],
				[ 'title' => $category->name, 'link' => get_term_link($category) ]
			],
			$breadcrumbs->get()
		);
	}

	public function test_post_tag() {
		$post_tag = get_terms( 'post_tag' )[0];
		$this->go_to( get_term_link( $post_tag ) );
		$breadcrumbs = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://localhost:8889/' ],
				[ 'title' => $post_tag->name, 'link' => get_term_link( $post_tag ) ]
			],
			$breadcrumbs->get()
		);
	}

	public function test_year() {
		$newest_post = get_post( $this->post_ids[0] );
		$year = date( 'Y', strtotime( $newest_post->post_date ) );
		$this->go_to( get_year_link( $year ) );
		$breadcrumbs     = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$breadcrumb_year = new \Inc2734\WP_Breadcrumbs\Controller\Date();
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://localhost:8889/' ],
				[ 'title' => '<span>' . $breadcrumb_year->year( $year ) . '</span>', 'link' => get_year_link( $year ) ]
			],
			$breadcrumbs->get()
		);
	}

	public function test_month() {
		$newest_post = get_post( $this->post_ids[0] );
		$year  = date( 'Y', strtotime( $newest_post->post_date ) );
		$month = date( 'n', strtotime( $newest_post->post_date ) );
		$this->go_to( get_month_link( $year, $month ) );
		$breadcrumbs      = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$breadcrumb_month = new \Inc2734\WP_Breadcrumbs\Controller\Date();
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://localhost:8889/' ],
				[ 'title' => $year, 'link' => "http://localhost:8889/$year/" ],
				[ 'title' => '<span>' . trim( single_month_title( ' ', false ) ) . '</span>', 'link' => get_month_link( $year, $month ) ]
			],
			$breadcrumbs->get()
		);
	}

	public function test_day() {
		$newest_post = get_post( $this->post_ids[0] );
		$year  = date( 'Y', strtotime( $newest_post->post_date ) );
		$month = date( 'n', strtotime( $newest_post->post_date ) );
		$day   = date( 'j', strtotime( $newest_post->post_date ) );
		$this->go_to( get_day_link( $year, $month, $day ) );
		$breadcrumbs    = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$breadcrumb_day = new \Inc2734\WP_Breadcrumbs\Controller\Date();
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://localhost:8889/' ],
				[ 'title' => $breadcrumb_day->year( $year ), 'link' => "http://localhost:8889/$year/" ],
				[ 'title' => get_the_date( _x( 'F', 'monthly archives date format' ) ), 'link' => "http://localhost:8889/$year/" . sprintf( '%02d', $month ) . "/" ],
				[ 'title' => get_the_date(), 'link' => get_day_link( $year, $month, $day ) ]
			],
			$breadcrumbs->get()
		);
	}

	public function test_author() {
		$newest_post = get_post( $this->post_ids[0] );
		$author = $newest_post->post_author;
		$this->go_to( get_author_posts_url( $author ) );
		$breadcrumbs = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://localhost:8889/' ],
				[ 'title' => get_the_author_meta( 'user_login', $this->author_id ), 'link' => get_author_posts_url($newest_post->post_author) ],
			],
			$breadcrumbs->get()
		);
	}

	public function test_single() {
		// Post
		$newest_post = get_post( $this->post_ids[0] );
		$categories = get_the_category( $newest_post );
		$this->go_to( get_permalink( $newest_post ) );
		$breadcrumbs = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://localhost:8889/' ],
				[ 'title' => $categories[0]->name, 'link' => get_term_link( $categories[0] ) ],
				[ 'title' => get_the_title( $newest_post ), 'link' => get_permalink($this->post_ids[0]) ],
			],
			$breadcrumbs->get()
		);

		// Custom post
		$custom_post_type_id = $this->factory->post->create( [ 'post_type' => $this->post_type ] );
		$custom_post = get_post( $custom_post_type_id );
		$this->go_to( get_permalink( $custom_post_type_id ) );
		$breadcrumbs = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$post_type_object = get_post_type_object( $custom_post->post_type );
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://localhost:8889/' ],
				[ 'title' => $post_type_object->label, 'link' => get_post_type_archive_link( $custom_post->post_type ) ],
				[ 'title' => get_the_title( $custom_post_type_id ), 'link' => get_permalink($custom_post->ID) ],
			],
			$breadcrumbs->get()
		);
	}

	public function test_post_type_archive() {
		// No posts
		$this->go_to( get_post_type_archive_link( $this->post_type ) );
		$this->assertFalse( get_post_type() );
		$breadcrumbs = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$post_type_object = get_post_type_object( $this->post_type );
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://localhost:8889/' ],
				[ 'title' => $post_type_object->label, 'link' => get_post_type_archive_link($this->post_type) ],
			],
			$breadcrumbs->get()
		);

		// Has posts
		$custom_post_type_id = $this->factory->post->create( [ 'post_type' => $this->post_type ] );
		$this->go_to( get_post_type_archive_link( $this->post_type ) );
		$this->assertNotFalse( get_post_type() );
		$breadcrumbs = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$post_type_object = get_post_type_object( $this->post_type );
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://localhost:8889/' ],
				[ 'title' => $post_type_object->label, 'link' => get_post_type_archive_link($this->post_type) ],
			],
			$breadcrumbs->get()
		);
	}

	public function test_taxonomy() {
		$custom_post_ids = $this->factory->post->create_many( 1, [ 'post_author' => $this->author_id, 'post_type' => $this->post_type ] );

		$term_id = $this->factory->term->create( array( 'taxonomy' => $this->taxonomy ) );
		foreach( $custom_post_ids as $post_id ) {
			wp_set_object_terms( $post_id, get_term( $term_id, $this->taxonomy )->slug, $this->taxonomy );
		}

		$taxonomy = get_taxonomy( $this->taxonomy );
		$term = get_terms( $taxonomy->name )[0];
		$post_type = get_post_type_object( $this->post_type );
		$this->go_to( get_term_link( $term ) );
		$breadcrumbs = new \Inc2734\WP_Breadcrumbs\Bootstrap();
		$this->assertEquals(
			[
				[ 'title' => 'Home', 'link' => 'http://localhost:8889/' ],
				[ 'title' => $post_type->label, 'link' => get_post_type_archive_link( $this->post_type ) ],
				[ 'title' => $term->name, 'link' => get_term_link( $term ) ],
			],
			$breadcrumbs->get()
		);
	}
}
