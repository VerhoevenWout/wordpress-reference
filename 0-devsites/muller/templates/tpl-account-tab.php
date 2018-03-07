<?php
global $muller;

// Template name: account-tab

/*
	Variables to load {
		WP / page
		menus / account-menu
		userhelper / loginbar / loginbar
	}
*/

get_header(); 
?>

<div class="row">
	<main class='columns small-12'>
		<header class='row'>
			<div class='columns small-12 breadcrumb'>
				<?= $muller->breadcrumb;?>
			</div>
			<div class='columns small-12 banner'>
				<div class='row intro transparent'>
					<div class='columns small-12 medium-9'>
						<?= $muller->loginbar;?>
						<?= $muller->menus['account-menu'];?>
					</div>
				</div>
			</div>
		</header>
		<section class='row'>
			<div id='profile' class='columns small-12 medium-9'>
				<?php the_content(); ?>
		</section>
	</main>
</div>

<?php 
get_footer(); 
?>