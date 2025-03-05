<?php
/**
 * All of the parameters passed to the function where this file is being required are accessible in this scope:
 *
 * @var array	 $attributes		The block attributes.
 * @var string   $content			The block content.
 * @var WP_Block $block				The block object.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

// Exit if accessed directly.

defined( 'ABSPATH' ) || exit;

/** @var WP_Term[] */
$categories = get_categories( array( 'hide_empty' => false ) );

$posts_per_page = get_option( 'posts_per_page' );

$posts = get_posts( array( 'posts_per_page' => $posts_per_page ) );

?>

<div <?php echo get_block_wrapper_attributes(); ?>>
	<ul class="categories">
		<li>
			<button data-category="" class="active"><?php esc_html_e( 'Toutes les catégories', 'posts-with-categories' ); ?></button>
		</li>
		<?php foreach ( $categories as $category ) : ?>
			<li>
				<button data-category="<?php echo esc_attr( $category->slug ); ?>">
					<?php echo esc_html( $category->name ); ?>
				</button>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php if ( ! empty( $posts ) ) : ?>
		<ol class="posts">
			<?php foreach ( $posts as $post ) : ?>
				<?php
					$categories = get_the_category( $post->ID );
				?>
				<li data-category="<?php echo esc_attr( $categories[0]->slug ); ?>">
					<article>
						<h2>
							<a href="<?php the_permalink( $post ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a>
						</h2>
						<p>
							<?php
							echo sprintf(
								__( "Publié le %s, dans %s.", 'posts-with-categories' ),
								'<strong>' . get_the_date( '', $post ) . '</strong>',
								"<strong>{$categories[0]->name}</strong>"
							);
							?>
						</p>
						<p><?php echo esc_html( get_the_excerpt( $post ) ); ?></p>
						<a href="<?php the_permalink( $post ); ?>">
							<?php esc_html_e( "Lire l'article", 'posts-with-categories' ); ?>
						</a>
					</article>
				</li>
			<?php endforeach; ?>
		</ol>
	<?php else : ?>
		<p><?php esc_html_e( 'Aucun résultat', 'posts-with-categories' ); ?></p>
	<?php endif; ?>
</div>
