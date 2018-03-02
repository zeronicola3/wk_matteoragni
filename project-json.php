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

	<a href="<?php echo $project['url']; ?>">
		<h5 class="timeline-item-title"><?php echo $project['title']; ?></h5>
	</a>
	<div class="timeline-item-img <?php echo $project['slug']; ?>">
		<style>

			.timeline-item-img.<?php echo $project['slug']; ?> {
				background-image: url('<?php echo $project['img_urls']['medium']; ?>');
				background-position: center center;
				background-size: cover;
				background-repeat: no-repeat;
				width: 86%;
				height: 0;
				padding-top: 64%; 
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

<?php } 


function secondary_project_content($project) { ?>

	<h5 class="timeline-project-title"><?php echo $project['title']; ?></h5>
	
<?php } 


function secondary_project_content_without_img($project) {
	echo '<h5 class="timeline-project-title">'. $project['title'] .'</h5>';
}	






			$timeline = parse_json_file();

			foreach ($timeline as $year => $projects) { ?>
				
				<div class="timeline-year-box timeline-year-<?php echo $year ?>">
					
					<h4><?php echo $year; ?></h4>

					<?php
					foreach ($projects as $key => $project) { ?>
						<div class="timeline-item">
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
						</div>

					<?php } ?>

				</div>
			<?php 
			}

        ?>
        </div>
	</div>
</div>
<?php get_footer(); ?>