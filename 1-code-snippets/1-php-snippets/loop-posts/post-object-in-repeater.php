<?php if( have_rows('block_4_favourite_articles_repeater') ): ?>
  <?php while( have_rows('block_4_favourite_articles_repeater') ): the_row(); ?>
       <?php
           $block_4_favourite_article = get_sub_field('block_4_favourite_article');
           $post = $block_4_favourite_article;
           setup_postdata( $post ); 
           $news_image = get_field('news_image');
           $news_category = get_field('news_category');
           $news_readtime = get_field('news_readtime');
       ?>
       <div class="article-big">
           <img src="<?= $news_image['url'] ?>" alt="<?= $news_image['title'] ?>">
           <div class="article-title">
               <h2 class="heading2"><?= the_title(); ?></h2>
               <a href="<?php the_permalink(); ?>" title="" class="heading2">
                   Lees meer
                   <i class="fas fa-angle-double-right"></i>
               </a>
           </div>
           
           <div class="article-footer">
               <span class="subheading"><?= $news_category; ?></span>
               <span class="subheading">| Leestijd: <?= $news_readtime; ?> minuten</span>
           </div>
       </div>
       <?php wp_reset_postdata(); ?>
    <?php endwhile ?>
<?php endif; ?>