<div class="row">
	<?php if (!empty(get_field('sponsor_repeater', $home->ID))):
	while(have_rows('sponsor_repeater', $home->ID)): the_row(); ?>
			<div class="sponsor-image-container">
				<img class="sponsor-image" src="<?php echo the_sub_field('sponsor_image'); ?>" alt="">
			</div>
    <?php endwhile;
	endif; ?>
</div>


<!-- Correct way -->
<?php if(!empty($tips_en_tricks_post_repeater)): ?>
	<?php $i=0; ?>
    <?php foreach ($tips_en_tricks_post_repeater as $key => $post): ?>
        <?php 
            $post_id = $post['tips_en_tricks_post']->ID;
            $news_image = get_field('news_image', $post_id);
            $news_category = ucfirst(get_the_category()[0]->name, $post_id);
            $news_readtime = get_field('news_readtime', $post_id);
         ?>

         <div class="article-small">
             <img src="<?= $news_image['url'] ?>" alt="<?= $news_image['title'] ?>">
             <div class="article-title">
                 <h2 class="heading2"><?= get_the_title($post_id); ?></h2>
                 <a href="<?php get_the_permalink($post_id); ?>" title="" class="heading2">
                     Lees meer
                     <i class="fas fa-angle-double-right"></i>
                 </a>
             </div>
             
             <div class="article-footer">
                 <?php if($news_category): ?>
                     <span class="subheading green"><?= $news_category; ?></span>
                     <span>|</span>
                 <?php endif; ?>
                 <span class="subheading">Leestijd: <?= $news_readtime; ?> minuten</span>
             </div>
         </div>
         <?php $i++; if($i==3) break; ?>
    <?php endforeach; ?>
<?php else: ?>
	<!-- code -->
<?php endif; ?>
