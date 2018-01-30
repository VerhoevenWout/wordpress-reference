<!-- EXCERPT only show first 86 characters -->
<?php if(get_field('excerpt')): ?>
  <p>
    <?php $excerpt = get_field('excerpt'); if($i == -1 || strlen($excerpt) < 86): echo $excerpt; else: echo substr($excerpt, 0, 86) . '...'; endif; ?>
  	<?php  
		if (get_field('news_excerpt')) {
		  	$excerpt = get_field('news_excerpt');
		  	$excerpt = preg_replace(" ([.*?])",'',$excerpt);
		  	$excerpt = strip_shortcodes($excerpt);
		  	$excerpt = strip_tags($excerpt);
		  	$excerpt = substr($excerpt, 0, 200);
		  	$excerpt = ucfirst($excerpt);
		  	// $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
		  	// $excerpt = trim(preg_replace( '/s+/', ' ', $excerpt));
		  	if (strlen($excerpt) >= 200) {
		  		$excerpt = $excerpt.'...';
		  	}
		}
  	?>
  </p>
<?php endif; ?>
