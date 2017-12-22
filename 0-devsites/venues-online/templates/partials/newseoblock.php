<?php 
	$lang = ICL_LANGUAGE_CODE;
	$home = get_page_by_path( 'home' );
	global $translations; 

	$activity_terms = get_terms( array(
	'taxonomy' => 'activiteit',
	'hide_empty' => false,
	) );
?>

<div v-if="!isactive">
<?php if ( !empty(get_field('seo_pages_repeater', $home->ID)) ) : ?>
	<div class="row expanded">
		<div class="block new-seo-block-home columns">
			<div class="row expanded">
				<div class="small-24 medium-8 seo-column">
					<h3><?= $translations[46] ?></h3>
					<ul>
						<?php while(have_rows('seo_pages_bedrijfsevents_repeater', $home->ID)): the_row(); ?>
							<?php 
								$seo_page_activity = $activity_terms[0]->slug;
								$seo_page_type_location = 'all';
								$seo_page_city = get_sub_field('seo_page_city', $home->ID );
								$seo_page_url = '/'.$lang.'/'.$seo_page_activity.'/'.strtolower($seo_page_city).'/';
							?>
							<li>
								<a href="<?php echo $seo_page_url ?>" title="">
									<?= $translations[49] ?> <?php echo ucfirst( $seo_page_city ) ?>
								</a>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
				<div class="small-24 medium-8 seo-column">
					<h3><?= $translations[47] ?></h3>
					<ul>
						<?php while(have_rows('seo_pages_congreslocaties_repeater', $home->ID)): the_row(); ?>
							<?php 
								$seo_page_activity = $activity_terms[1]->slug;
								$seo_page_type_location = 'all';
								$seo_page_city = get_sub_field('seo_page_city', $home->ID );
								$seo_page_url = '/'.$lang.'/'.$seo_page_activity.'/'.strtolower($seo_page_city).'/';
							?>
							<li>
								<a href="<?php echo $seo_page_url ?>" title="">
									<?= $translations[49] ?> <?php echo ucfirst( $seo_page_city ) ?>
								</a>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
				<div class="small-24 medium-8 seo-column">
					<h3><?= $translations[48] ?></h3>
					<ul>
						<?php while(have_rows('seo_pages_vergaderzalen_repeater', $home->ID)): the_row(); ?>
							<?php 
								$seo_page_activity = $activity_terms[2]->slug;
								$seo_page_type_location = 'all';
								$seo_page_city = get_sub_field('seo_page_city', $home->ID );
								$seo_page_url = '/'.$lang.'/'.$seo_page_activity.'/'.strtolower($seo_page_city).'/';
							?>
							<li>
								<a href="<?php echo $seo_page_url ?>" title="">
									<?= $translations[49] ?> <?php echo ucfirst( $seo_page_city ) ?>
								</a>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
</div>

<!-- GENERATED SEO -->
<div v-if="isactive && newSeoLinks != null">
	<div class="row expanded">
		<div class="block new-seo-block columns">
			<ul>
				<li v-for="newSeoLink in newSeoLinks">
					<a v-bind:href="newSeoLink.url" title="newSeoLink.title">
						{{ newSeoLink.title }}
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
