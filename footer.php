<?php defined( 'ABSPATH' ) || exit; ?>
</main>
<footer class="site-footer">
	<a href="<?php echo esc_url( albina_home_url() ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
	<span>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?></span>
	<a href="#main"><?php esc_html_e( 'Back to top', 'albina' ); ?> <span aria-hidden="true">↑</span></a>
</footer>
<?php wp_footer(); ?>
</body>
</html>
