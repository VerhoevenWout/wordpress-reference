<?php /* Template Name: Team */ ?>
<?php get_header(); ?>
	<main role="main" class="team_page">
		<?php
		if(have_posts()):
		while (have_posts()) : the_post();?>
		<div class="container">
			<div class="row">
				<div class="col-md-12 entry main-content">

					<select id="team-select">
						<option value="all">All</option>
						<?php $field = get_field_object('job_title');
						$choices = $field['choices'];
						foreach($choices as $choice):?>
							<option value="<?php echo $choice; ?>"><?php echo $choice; ?></option>
						<?php endforeach;?>
					</select>

					<?php $args = array(
						'post_type' => 'team',
						'post_status' => 'publish',
						'posts_per_page'=> '8',
						'paged' => $paged,
						'order' => 'asc',
						'orderby' => 'menu_order',
						'meta_key' => 'job_title',
						// 'meta_value' => 'Neurologist',
					);
					$loop = new WP_Query( $args );
					if( $loop->have_posts() ): ?>
						<?php $i = 1; while( $loop->have_posts() ): $loop->the_post(); global $post; ?>



						<a class="popup-team" href="#team-modal-<?php echo $i; ?>">
							<div class="single-team-member-container">
								<?php $photo = get_field('photo'); ?>
								<div class="top-image">
									<div class="photograph" style="background: url('<?php echo $photo; ?>') no-repeat center/cover; "></div>
								</div>
								<div class="bottom-text">
									<h3 class="title"><?php the_title(); ?></h3>
									<div class="job-title"><p><?php the_field('job_title') ?></p>
									</div>
								</div>
							</div>
						</a>

						<div id="team-modal-<?php echo $i; ?>" class="team-modal white-popup-block mfp-hide">
							<div class="popup-modal-dismiss"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/close.png"/></div>
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-4">
										<div class="photograph" style=" background: url(http://recognition.clients.twkmedia.eu/wp-content/uploads/2017/06/emer_043.jpg) no-repeat center/cover; "></div>
									</div>
									<div class="col-md-8">
										<h3 class="title"><?php the_title(); ?></h3>
										<div class="job-title"><p><?php the_field('job_title') ?></p>
										</div>

										<div class="bio"><h3>Bio</h3><?php the_field('full_bio') ?></div>
										<div class="education"><h3>Education</h3><?php the_field('education') ?></div>
										<div class="video"><p><?php the_field('video') ?></p></div>
									</div>
								</div>
							</div>
						</div>
						<?php $i++; endwhile; ?>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>



				</div>
				<div class="col-md-3 ">
					<?php include( locate_template( 'templates/parts/side_menu.php' ) ); ?>
				</div>
			</div>
		</div>
		<?php
		endwhile;
		endif;?>
	</main>
<?php get_footer(); ?>


<script type="text/javascript">
  jQuery(document).ready(function($){
    console.log('ready');
    $('.popup-team').magnificPopup({
      type: 'inline',
      preloader: false,
      focus: '#username',
      modal: true
    });
    $(document).on('click', '*:not( .team-modal ) .popup-modal-dismiss', function (e) {
      e.preventDefault();
      $.magnificPopup.close();
    });
  });
</script>
