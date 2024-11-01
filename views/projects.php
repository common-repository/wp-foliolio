<?php
/**
 * Template Name: Projects Page
 * The template for displaying all projects.
 *
 */

get_header();
get_sidebar() ;
?>
		<ul class="mcol">
			<?php $loop = new WP_Query( array( 'post_type' => 'project', 'posts_per_page' => 10,
			'orderby' => 'meta_value', 'order' => 'DESC' ) ); ?>
				
			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<?php
				$project = WPFO_Project::getProject(get_the_ID());
			?>
			
			<li class="article">
					<a href="<?php echo get_permalink();?>">
						<?php 
							if(has_post_thumbnail()) {
								the_post_thumbnail();
							} else {
								echo '<img src="/img/noimage.png" alt="No image found"/>';
							}
						?>
					</a>
					<div class="postmetadata">
                        Posted: <?php the_time(__('F jS, Y', 'kubrick')) ?>&nbsp;&#721;&nbsp;
                        <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments'), '', __('Comments Closed') ); ?><br />
						Project: <a href="<?php echo $project->getURL(); ?>" target="_blank"><?php the_title(); ?></a><br />
						Client: <?php echo $project->getClient(); ?>
                    </div>
			</li>
		
			<?php endwhile; ?>
			
			
			
			<div class="projectsclear"></div>
		</ul>
		
		<div id="nav">
			<div id="navleft"><?php next_posts_link(__('Previous&nbsp;')) ?></div>
            <div id="navright"><?php previous_posts_link(__('Next&nbsp;')) ?></div>
        </div>	
<?php get_footer(); ?>
