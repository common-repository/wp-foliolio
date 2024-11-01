<?php
/**
 * Template Name: Platforms Page
 * This is the template used to display a list of projects grouped by the platform(s) assigned to them.
 *
 */

get_header(); 
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>

		<div id="container" class="one-column">
			<div id="content" role="main">
				<h1>Projects</h1>
				
				<h3 class="left">Completed using <?php echo $term->name; ?></h3>
				<p class="right"><a href="/projects">&larr; Back to all Projects</a></p>
				<div class="clear"></div>
				
			<?php if (have_posts()) : ?>

			<?php 
				$sortOptions = array('meta_key' => 'folio-date', 'orderby' => 'meta_value', 'order' => 'DESC');
				$newQueryArgs = array_merge($wp->query_vars, $sortOptions);
				$newQuery = new WP_Query($newQueryArgs);
			?>
			
			<?php while ( $newQuery->have_posts() ) : $newQuery->the_post(); ?>

			<?php $project = WPFO_Project::getProject(get_the_ID()); ?>
			
				<div class="entry-project">
<!-- 					<a href="<?php echo $project->getURL(); ?>" target="_blank"><?php echo $project->getURL(); ?></a> -->
<!-- 					<p><?php echo $project->getClient(); ?></p> -->
					<a href="<?php echo get_permalink();?>">
						<?php 
							if(has_post_thumbnail()) {
								the_post_thumbnail();
							} else {
								echo '<img src="/img/noimage.png" alt="No image found" />';
							}
						?>
					</a>
				</div>
			<?php endwhile; ?>
				<div class="clear"></div>
			<?php else: ?>
				<h4>No Projects Found</h4>
			<?php endif;?>
			</div><!-- #content -->
			
		</div><!-- #container -->

<?php get_footer(); ?>
