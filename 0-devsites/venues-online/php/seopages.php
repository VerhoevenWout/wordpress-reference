<?php
add_action( 'admin_menu', 'seopages_bulk' );

function seopages_bulk() {
	add_submenu_page('edit.php?post_type=seopage', 'Bulk insert SEO pages', 'Bulk insert', 'manage_options', 'bulk_seopages', 'bulk_seopages_content');
	add_submenu_page('edit.php?post_type=seopage', 'Bulk delete SEO pages', 'Bulk delete', 'manage_options', 'bulk_seopages_delete', 'bulk_seopages_content');
}

function bulk_seopages_content() {
	global $wpdb;
	enqueue_custom_assets();

	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	$action = 'create';
	if($_GET["page"] == 'bulk_seopages_delete') { $action = 'delete'; }

	if (isset($_POST["keywords"])) {
		$language = $_POST["language"];
		$keywords = $_POST["keywords"];
		$keywords_array = explode("\n", $keywords);

		foreach ($keywords_array as $keyword) {
			if(sqlsave($keyword))
			{
				// get seopage if already exists
				$sql = "select p.id from " . $wpdb->prefix . "posts p join " . $wpdb->prefix . "icl_translations on element_id = p.id where post_type = 'seopage' and post_title = '" . sqlsave($keyword) . "' and element_type = 'post_seopage' and language_code = '" . $language . "' limit 1";
				
				echo $sql;
				$result = $wpdb->get_results($sql);

				if($action == 'create')
				{
					// create seopage if not exists
					if(!$result) {
						$sql = "insert into " . $wpdb->prefix . "posts(post_type, post_title, post_author, post_status, comment_status, ping_status, post_name, post_date, post_date_gmt, post_modified, post_modified_gmt) values('seopage', '" . sqlsave($keyword) . "', " . get_current_user_id() . ", 'publish', 'closed', 'closed', '" . sqlsave($keyword) . "', now(), now(), now(), now())";
						$wpdb->query($sql);

						$sql = "select p.id from " . $wpdb->prefix . "posts p where post_type = 'seopage' and post_title = '" . sqlsave($keyword) . "' order by id desc limit 1";
						$result = $wpdb->get_results($sql);

						$sql = "insert into " . $wpdb->prefix . "icl_translations(trid, element_type, element_id, language_code, source_language_code) select max(trid)+1, 'post_seopage', " . $result[0]->id . ", '" . $language . "', null from " . $wpdb->prefix . "icl_translations";
						$wpdb->query($sql);
					}

					// link seopage to fiches
					if($result) {
						$fiches = $_POST["fiches"];
						$fiches_array = explode(",", $fiches);

						foreach ($fiches_array as $fiche) {
							// check if link already exists
							$sql = "select * from " . $wpdb->prefix . "postmeta where meta_key like '_fiche_seopage' and post_id = " . $fiche . " and meta_value = " . $result[0]->id;
							$link = $wpdb->get_results($sql);

							if(!$link) {
								$sql = "insert into " . $wpdb->prefix . "postmeta(post_id, meta_key, meta_value) values(" . $fiche . ", '_fiche_seopage', " . $result[0]->id . ")";
								$wpdb->query($sql);
							}
						}
					}
				}

				if($action == 'delete')
				{
					if($result) {
						// remove relations with posts
						$sql = "delete from " . $wpdb->prefix . "postmeta where meta_key = '_fiche_seopage' and meta_value = " . $result[0]->id;
						$wpdb->query($sql);

						// remove translation record
						$sql = "delete from " . $wpdb->prefix . "icl_translations where element_type = 'post_seopage' and element_id = " . $result[0]->id . " and language_code = '" . $language . "'";
						$wpdb->query($sql);

						// remove post
						$sql = "delete from " . $wpdb->prefix . "posts where post_type = 'seopage' and id = " . $result[0]->id;
						$wpdb->query($sql);
					}
				}
			}
		}

		if($action <> 'delete')
		{
			echo '<div class="notice notice-success is-dismissible"><p>SEO pages created.</p></div>';
		}
		else
		{
			echo '<div class="notice notice-success is-dismissible"><p>SEO pages deleted.</p></div>';	
		}
	}

	if($action <> 'delete')
	{
		echo '<form name="params" id="params" method="post" action="edit.php?post_type=seopage&page=bulk_seopages">';
	}
	else
	{
		echo '<form name="params" id="params" method="post" action="edit.php?post_type=seopage&page=bulk_seopages_delete">';	
	}
	echo '<input type="hidden" name="language" value="' . explode("-", ICL_LANGUAGE_CODE)[0] . '">';
	echo '<input type="hidden" name="fiches" id="data-fiches" value="">';

	?>

	<table class="form-table meta-table" id="fiches">
		<tbody>
			<tr>
				<th>SEO pages</th>
				<td>
					Enter the keywords (one on every line) in the field below, then click the '<?php echo $action ?>' button.<br>
					<textarea name="keywords"></textarea>
				</td>
			</tr>
			<?php if($action <> 'delete') { ?>
			<tr>
				<th>Gekoppelde fiches</th>
				<td>
					<div id="owned-fiches" class="owned-meta">
						<ul>
					</ul>
				</div>
			</td>
		</tr>
		<tr>
			<th>Fiche toevoegen</th>
			<td>
				<input type="text" class="regular-text search-fiches search-meta" placeholder="Gelieve 3 of meer karakters in te typen..." />
				<i id="loading" class="fa fa-spinner fa-pulse"></i>
				<div class="results-container">
					<div id="result-fiches" class="result-meta"></div>
				</div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<?php 

if($action <> 'delete')
{
	echo '<input type="submit" value="create">';
}
else
{
	echo '<input type="submit" value="delete">';	
}
echo '</form>';
}

function sqlsave($string_in)
{
	return trim(str_replace("'", "''", $string_in));
}