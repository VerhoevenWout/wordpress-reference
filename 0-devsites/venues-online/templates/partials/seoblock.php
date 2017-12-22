<?php  
	$post_id = get_the_ID();
    $sql = '
        SELECT DISTINCT pm.post_id, p.*, t.language_code 
        FROM wp_posts AS p 
        JOIN wp_icl_translations AS t on p.ID=t.element_id 
        JOIN wp_postmeta AS pm ON p.ID=pm.meta_value 
        WHERE pm.meta_key = "_fiche_seopage" AND pm.post_id = '.$post_id;
    // error_log($sql);
	global $wpdb;
	$result = $wpdb->get_results($sql);

	$lang = ICL_LANGUAGE_CODE;
?>

<?php if($result): ?>
<div class="row expanded">
	<div class="block seo-block columns">
		<ul>
 			<?php foreach ($result as $key=>$seopage): ?>
 				<?php 
					$id		= $seopage->ID;
					$idurl	= '/'.$lang.'/vo/'.$seopage->post_name;
					$postid	= $seopage->post_id;
					$name	= $seopage->post_name;
					$title	= $seopage->post_title;
					$url	= $seopage->guid;
 				?>
 				<li>
					<a href="<?php echo $idurl ?>" title="<?php echo $title ?>">
						<?php echo $title ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>