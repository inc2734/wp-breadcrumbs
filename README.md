# WP Breadcrumbs

![CI](https://github.com/inc2734/wp-breadcrumbs/workflows/CI/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/inc2734/wp-breadcrumbs/v/stable)](https://packagist.org/packages/inc2734/wp-breadcrumbs)
[![License](https://poser.pugx.org/inc2734/wp-breadcrumbs/license)](https://packagist.org/packages/inc2734/wp-breadcrumbs)

## Install

```bash
composer require inc2734/wp-breadcrumbs
```

## How to use

```php
<?php
$breadcrumbs = new Inc2734\WP_Breadcrumbs\Bootstrap();
$items = $breadcrumbs->get();
?>
<div class="c-breadcrumbs">
	<div class="container">
		<ol class="c-breadcrumbs__list" itemscope itemtype="http://schema.org/BreadcrumbList">
			<?php foreach ( $items as $key => $item ) : ?>
				<li class="c-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<?php if ( empty($item['link']) ) : ?>
						<span itemscope itemtype="http://schema.org/Thing" itemprop="item">
							<span itemprop="name"><?php echo esc_html( $item['title'] ); ?></span>
						</span>
					<?php else : ?>
						<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="<?php echo esc_url( $item['link'] ); ?>">
							<span itemprop="name"><?php echo esc_html( $item['title'] ); ?></span>
						</a>
					<?php endif; ?>
					<meta itemprop="position" content="<?php echo esc_attr( $key + 1 ); ?>" />
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</div>
```

## Filters

Some filters are available if you need to change `wp-breadcrumbs` behavior.

```php
/**
 * Filter items
 */
add_filter(
	'inc2734_wp_breadcrumbs',
	function( $items ) {
		// Do something here
		return $items;
	}
);
```

```php
/**
 * Add link attribute for the last item (default: true)
 */
add_filter( 'inc2734_wp_breadcrumbs_remove_last_link', '__return_false' );
```

```php
/**
 * Change the taxonomy used in the breadcrumb (default: first taxonomy attached)
 */
add_filter(
	'inc2734_wp_breadcrumbs_main_taxonomy',
	function( $first_post_type_taxonomy, $taxonomies, $post_type_object ) {
		// Logic to set the primary taxonomy of your post type if it has multiple ones
		if ( 'product' === $post_type_object->name ) {
			return 'my_main_product_taxonomy';
		}
		return $first_post_type_taxonomy;
	},
	10,
	3
);
```

```php
/**
 * If a post (post, CPT, etc.) has more than one term, this filter provides a way to set the main term
 */
add_filter(
	'inc2734_wp_breadcrumbs_main_term',
	function( $main_term, $terms, $taxonomy, $post_id ) {
		// Example with the SEO Framework plugin
		$tsf_main_term = get_post_meta( $post_id, sprintf( '_primary_term_%s', $taxonomy ), true );
		return $tsf_main_term ? get_term( $tsf_main_term ) : $main_term;
	},
	10,
	3
);
```
