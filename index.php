<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<div class="section-pad text-index">
	<?php if ( ! is_singular() ) : ?><h1><?php echo is_search() ? esc_html__( 'Search results', 'albina' ) : esc_html__( 'Journal', 'albina' ); ?></h1><?php endif; ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'prose' ); ?>>
			<?php if ( is_singular() ) : ?>
				<h1><?php echo esc_html( get_the_title() ); ?></h1>
				<?php the_content(); wp_link_pages(); ?>
			<?php else : ?>
				<h2><a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a></h2>
				<?php the_excerpt(); ?>
			<?php endif; ?>
		</article>
	<?php endwhile; the_posts_pagination(); else : ?>
		<p><?php esc_html_e( 'Nothing found.', 'albina' ); ?></p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
