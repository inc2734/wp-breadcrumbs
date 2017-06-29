# WP Breadcrumbs

[![Build Status](https://travis-ci.org/inc2734/wp-breadcrumbs.svg?branch=master)](https://travis-ci.org/inc2734/wp-breadcrumbs)
[![Latest Stable Version](https://poser.pugx.org/inc2734/wp-breadcrumbs/v/stable)](https://packagist.org/packages/inc2734/wp-breadcrumbs)
[![License](https://poser.pugx.org/inc2734/wp-breadcrumbs/license)](https://packagist.org/packages/inc2734/wp-breadcrumbs)

## Install
```
$ composer require inc2734/wp-breadcrumbs
```

## How to use
```
<?php
// When Using composer auto loader
// $breadcrumbs = new Inc2734\WP_Breadcrumbs\Breadcrumbs();

// When not Using composer auto loader
include_once( get_theme_file_path( '/vendor/inc2734/wp-breadcrumbs/src/wp-breadcrumbs.php' ) );
$breadcrumbs = new Inc2734_WP_Breadcrumbs();
$items = $breadcrumbs->get();
?>
<div class="c-breadcrumbs">
	<div class="container">
		<ol class="c-breadcrumbs__list" itemscope itemtype="http://schema.org/BreadcrumbList">
			<?php foreach ( $items as $key => $item ) : ?>
			<li class="c-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<?php if ( empty( $item['link'] ) ) : ?>
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
