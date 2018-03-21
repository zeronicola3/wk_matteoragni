<?php 
/**
 * Template Name: Json Project
 *
 */

update_projects_json();

get_header(); ?>

<div id="contenuti">
	<div class="wrapper">
		<div class="wp_content">

<?php

function primary_project_content($project) { ?>


	<?php 
		get_post($project['cliente']);
	?>

	<a class="timeline-title-box" data-title="<?php echo $project['slug']; ?>">
		<h5 class="timeline-item-title"><?php echo $project['title']; ?></h5>
	</a>
	<a href="<?php echo $project['url']; ?>" class="timeline-item <?php echo $project['slug']; ?> ">
		<div class="timeline-item-img <?php echo $project['slug']; ?>">
			<style>

				.timeline-item-img.<?php echo $project['slug']; ?> {
					background-image: url('<?php echo $project['img_urls']['medium']; ?>');
				}

				@media (min-width: 768px) {  
	                .timeline-item-img.<?php echo $project['slug']; ?> {
						background-image: url('<?php echo $project['img_urls']['large']; ?>');
					}
	            }
	            
			</style>
		</div>
		<div class="timeline-item-description">
			<h4 class="project-title"><?php echo $project['title']; ?></h4>
			<span class="project-client"><?php echo $project['description']; ?></span>
			<span class="project-client"><?php echo $project['year']; ?></span>
			<span class="project-client"><?php echo $project['clienti'][0]['title']; ?></span>
		</div>
	</a>

<?php } 


function secondary_project_content($project) { ?>
	
	<a class="timeline-title-box" data-title="<?php echo $project['slug']; ?>">
		<h5 class="timeline-item-title"><?php echo $project['title']; ?></h5>
	</a>
	<a href="<?php echo $project['url']; ?>" class="timeline-item <?php echo $project['slug']; ?>">
		<div class="timeline-item-img <?php echo $project['slug']; ?>">
			<style>

				.timeline-item-img.<?php echo $project['slug']; ?> {
					background-image: url('<?php echo $project['img_urls']['medium']; ?>');
				}

				@media (min-width: 768px) {  
	                .timeline-item-img .<?php echo $project['slug']; ?> {
						background-image: url('<?php echo $project['img_urls']['large']; ?>');
					}
	            }
	            
			</style>
		</div>
		<div class="timeline-item-description">
			<h4 class="project-title"><?php echo $project['title']; ?></h4>
			<span class="project-client"><?php echo $project['description']; ?></span>
			<span class="project-client"><?php echo $project['year']; ?></span>
		</div>
	</a>
	
<?php } 


function secondary_project_content_without_img($project) {
	echo '<h5 class="timeline-item-title">'. $project['title'] .'</h5>';
}	

?>
		<div class="timeline-block">
<?php
			$timeline = parse_json_file();
			$number = 0;

			foreach ($timeline as $year => $projects) { ?>
				
				<div class="timeline-year-box timeline-year-<?php echo $year; if($number==0){ echo " active"; $number++;} ?> ">
					
					<h4><?php echo $year; ?></h4>

					<?php
					foreach ($projects as $key => $project) { ?>
						
						<?php

						if($project['is_secondary']) {
							// Check per progetti 
							if($project['img_urls'] == "") { 
								secondary_project_content_without_img($project);
							} else { 
								secondary_project_content($project);
							} 
						} else {
							primary_project_content($project);
						}
						?>

					<?php } ?>

				</div>
			<?php 
			}

        ?>
    	</div>
        </div>
	</div>
</div>
<?php get_footer(); ?>