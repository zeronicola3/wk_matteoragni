<?php 
/**
 * Template Name: Timeline
 *
 */

get_header(); ?>

<div id="contenuti">
	<div class="wrapper">
		<div class="wp_content">

<?php

function primary_project_content($project, $lazy) { ?>


	<?php 
		get_post($project['cliente']);
	?>

	<a class="timeline-title-box <?php echo $project['type']; ?>" data-title="<?php echo $project['slug']; ?>">
		<h5 class="timeline-item-title title-image-page"><?php echo $project['title']; ?></h5>
	</a>
	<a href="<?php echo $project['url']; ?>" class="timeline-item <?php echo $project['slug']; ?> ">
		<div class="timeline-item-img <?php echo $project['slug']; if($lazy){ ?> lazy" data-src="<?php echo $project['img_urls']['medium']; }?>">
			<?php 
			if(!$lazy){ ?>
				<style>

					.timeline-item-img.<?php echo $project['slug']; ?> {
						background-image: url('<?php echo $project['img_urls']['medium']; ?>');
					}
				</style>
			<?php } ?>
		</div>
		<div class="timeline-item-description">
			<h4 class="project-title"><?php echo $project['title']; ?></h4>
			<?php if($project['description'] != ""){ ?>
				<span class="project-client"><?php echo $project['description']; ?></span>
			<?php 
			}
			if($project['clienti'][0]['title'] != ""){ ?>
				<span class="project-client"><?php echo $project['clienti'][0]['title']; ?></span><br>
			<?php } ?>
			<span class="project-client"><?php echo $project['year']; ?></span>

		</div>
	</a>

<?php } 


function secondary_project_content($project, $lazy) { ?>
	
	<a class="timeline-title-box <?php echo $project['type']; ?>" data-title="<?php echo $project['slug']; ?>">
		<h5 class="timeline-item-title title-image"><?php echo $project['title']; ?></h5>
	</a>
	<a class="timeline-item <?php echo $project['slug']; ?>">
		<div class="timeline-item-img <?php echo $project['slug']; if($lazy){?> lazy" data-src="<?php echo $project['img_urls']['medium']; }?>">

			<?php 
			if(!$lazy){ ?>
				<style>

					.timeline-item-img.<?php echo $project['slug']; ?> {
						background-image: url('<?php echo $project['img_urls']['medium']; ?>');
					}
				</style>
			<?php } ?>
			
		</div>
		<div class="timeline-item-description">
			<h4 class="project-title"><?php echo $project['title']; ?></h4>
			<?php if($project['description'] != ""){ ?>
				<span class="project-client"><?php echo $project['description']; ?></span>
			<?php 
			}
			if($project['clienti'][0]['title'] != ""){ ?>
				<span class="project-client"><?php echo $project['clienti'][0]['title']; ?></span><br>
			<?php } ?>
			<span class="project-client"><?php echo $project['year']; ?></span>
		</div>
	</a>
	
<?php } 


function secondary_project_content_without_img($project) {
	echo '
	<a class="timeline-title-box '. $project['type'] .'">
		<h5 class="timeline-item-title only-title">'. $project['title'] .'</h5>
	</a>';
}	

?>
		<div class="timeline-block">
<?php
			$timeline = parse_json_file();
			$number = 0;

			foreach ($timeline as $year => $projects) { ?>
				
				<div class="timeline-year-box timeline-year-<?php echo $year; if($number<=1){ echo " active"; $number++;} ?> ">
					
					<h4><?php echo $year; ?></h4>

					<?php
					$attiva_lazy = true;
					if($number<=1){
						$attiva_lazy = false;
					}

					foreach ($projects as $key => $project) { ?>
						<?php
						if($project['is_secondary']) {
							// Check per progetti 
							if($project['img_urls'] == "") { 
								secondary_project_content_without_img($project);
							} else { 
								secondary_project_content($project, $attiva_lazy);
							} 
						} else {
							primary_project_content($project, $attiva_lazy);
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