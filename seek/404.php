<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Seek
 */

get_header();
?>



	<section class="twp-not-found">
		<div class="container">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'seek' ); ?></h1>
			</header><!-- .page-header -->
			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'seek' ); ?></p>

				<?php
				get_search_form();

				?>
			</div><!-- .page-content -->
		</div>

	</section><!-- .error-404 -->

	

<?php
get_footer();
