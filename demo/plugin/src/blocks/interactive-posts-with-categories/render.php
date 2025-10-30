<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

// Exit if accessed directly.

defined( 'ABSPATH' ) || exit;

$context = array(
	'selected' => 'agenda',
	'categories' => array(),
	'posts' => array(),
);

/** @var WP_Term[] */
$categories = get_categories( array( 'hide_empty' => false ) );

foreach ( $categories as $category ) {
	$category_data = array(
		'name' => $category->name,
		'slug' => $category->slug,
	);

	$context['categories'][] = $category_data;
}

$posts_per_page = get_option( 'posts_per_page' );

$posts = get_posts( array( 'posts_per_page' => $posts_per_page ) );

foreach ( $posts as $post ) {
	$post_data = array(
		'category__name' => html_entity_decode( get_the_category( $post->ID )[0]->name ),
		'category__slug' => html_entity_decode( get_the_category( $post->ID )[0]->slug ),
		'permalink' => get_the_permalink( $post ),
		'title' => html_entity_decode( get_the_title( $post ) ),
		'date' => get_the_date( '', $post ),
		'excerpt' => html_entity_decode( get_the_excerpt( $post ) ),
		'visible' => true,
	);

	$context['postsd'][] = $post_data;
}

?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="wpinteractivitydemo-plugin/posts-with-categories"
	data-wp-init="callbacks.init"
	<?php echo wp_interactivity_data_wp_context( $context ); ?>
>
	<ul class="categories">
		<li>
			<button
				data-category=""
				data-wp-class--active="state.isCategoryActive"
				data-wp-on-async--click="actions.selectCategory"
				class="active"
			>
				<?php esc_html_e( 'Toutes les catégories', 'posts-with-categories' ); ?>
			</button>
		</li>
		<template data-wp-each="context.categories">
			<li>
				<button
					data-wp-bind--data-category="context.item.slug"
					data-wp-class--active="state.isCategoryActive"
					data-wp-on-async--click="actions.selectCategory"
					data-wp-text="context.item.name"
				></button>
			</li>
		</template>
	</ul>
	<ol class="posts" data-wp-bind--hidden="!context.posts.length">
		<template data-wp-each="context.posts">
			<li data-wp-bind--data-category="context.item.category__slug" data-wp-bind--hidden="!context.item.visible">
				<article>
					<h2>
						<a data-wp-bind--href="context.item.permalink" data-wp-text="context.item.title"></a>
					</h2>
					<p>
						<?php _e( "Publié le", 'posts-with-categories' ); ?>
						<strong data-wp-text="context.item.date"></strong>,
						<?php _e( "dans", 'posts-with-categories' ); ?>
						<strong data-wp-text="context.item.category__name"></strong>
					</p>
					<p data-wp-text="context.item.excerpt"></p>
					<a data-wp-bind--href="context.item.permalink">
						<?php esc_html_e( "Lire l'article", 'posts-with-categories' ); ?>
					</a>
				</article>
			</li>
		</template>
	</ol>
	<p data-wp-bind--hidden="context.posts.length">
		<?php esc_html_e( 'Aucun résultat', 'posts-with-categories' ); ?>
	</p>
</div>
<!-- <pre>
	<?php var_dump($context); ?>
</pre> -->
