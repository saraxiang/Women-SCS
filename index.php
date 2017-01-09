<?php get_header(); ?>

<main>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="container">
			<h2><?php the_title() ?></h2>
			<h5>Hardcoded Details</h5>
			<p><?php the_content() ?></p>        
	<?php endwhile; else : ?>

		<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>

	<?php endif; ?>
</main>

<?php get_footer(); ?>