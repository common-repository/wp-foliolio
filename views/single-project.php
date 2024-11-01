<?php
/**
 * The Template for displaying all single Projects.
 *
 */
 ?>

<?php get_header(); ?>

<?php get_sidebar(); ?>
	
		<div id="main-inner">

				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<?php
					$project = WPFO_Project::getProject(get_the_ID());
				?>
			
				<div class="article" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h3 class="left"><?php the_title(); ?></h3>
					<a href="/projects" class="right">&larr; Back to Projects</a>
					<div class="clear"></div>
					<div class="project-info">
						<div class="project-bar">
							<?php 
								if ( has_post_thumbnail()) {
									$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
									echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
									echo get_the_post_thumbnail($post->ID, 'large'); 
									echo '</a>';
								} else {
									echo '<img src="/img/noimage.png" alt="No featured image" />';
								}
							?>
							<div class="project-attr">
								<strong>Project Information:</strong>
								<p><strong>Name:</strong> <a href="<?php echo $project->getURL(); ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></p>
								<p><strong>Client:</strong> <a href="<?php echo $project->getClurl(); ?>" title="<?php echo $project->getClient(); ?>" target="_blank"><?php echo $project->getClient(); ?></a></p>
								<p><strong>Client Sector:</strong> <?php echo $project->getClsec(); ?></p>
								<p><strong>Date:</strong> <?php echo $project->getDate(); ?></p>
								<p><strong>Type of Work:</strong> <?php echo $project->getPunp(); ?></p>
							</div>
							<div class="project-platforms">
								<?php the_terms( $post->ID, 'platform', '<strong>Project Tags:</strong><ul><li>', '</li><li>', '</li></ul>' ); ?>
							</div>
						</div>
						<div class="project-description">
							<?php the_content(); ?>
						</div>	
					</div>	
				</div><!-- #post-## -->
				
				<?php endwhile; // end of the loop. ?>
				
				<div id="nav">
                    <div id="navleft"><?php previous_post_link('%link', 'Previous article'); ?></div>
                    <div id="navright"><?php next_post_link('%link', 'Next article'); ?></div>
                </div>

			<?php comments_template(); ?>
			
		</div><!-- #main-innter -->

<?php get_footer(); ?>
