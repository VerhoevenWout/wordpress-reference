<?php

$actions = array("list", "view", "visit", "email", "phone", "feat", "capacity");

/** Step 2 (from text above). */
add_action( 'admin_menu', 'stats_menu' );

/** Step 1. */
// function stats_menu() {
// 	add_menu_page('Statistieken', 'Statistieken', 'manage_options', 'stats', 'stats_content');
// }

/** Step 3. */
function stats_content() {
	enqueue_custom_assets();

	global $actions;

	$param_year = date("Y");
	if (isset($_GET["year"])&&is_numeric($_GET["year"])) { $param_year = $_GET["year"]; }

	$param_dayfrom = 1;
	$param_monthfrom = 1;
	$param_yearfrom = date("Y");
	$param_dayto = 31;
	$param_monthto = 12;
	$param_yearto = date("Y");

	if (isset($_GET["dayfrom"])&&is_numeric($_GET["dayfrom"])) { $param_dayfrom = $_GET["dayfrom"]; }
	if (isset($_GET["monthfrom"])&&is_numeric($_GET["monthfrom"])) { $param_monthfrom = $_GET["monthfrom"]; }
	if (isset($_GET["yearfrom"])&&is_numeric($_GET["yearfrom"])) { $param_yearfrom = $_GET["yearfrom"]; }
	if (isset($_GET["dayto"])&&is_numeric($_GET["dayto"])) { $param_dayto = $_GET["dayto"]; }
	if (isset($_GET["monthto"])&&is_numeric($_GET["monthto"])) { $param_monthto = $_GET["monthto"]; }
	if (isset($_GET["yearto"])&&is_numeric($_GET["yearto"])) { $param_yearto = $_GET["yearto"]; }

	$param_user = 0;
	if (isset($_GET["user"])&&is_numeric($_GET["user"])) { $param_user = $_GET["user"]; }

	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	echo '<form name="params" id="params" method="get" action="admin.php" data-types="' . implode(",", $actions) . '">';
	echo '<input type="hidden" name="page" value="stats">';

	echo '<select size="1" name="dayfrom">';
	for ($x = 1; $x <= 31; $x++) {
		echo '<option value="' . $x . '"';
		if ($x==$param_dayfrom) { echo ' selected'; }
		echo '>' . $x;
	} 
	echo '</select>';
	echo '<select size="1" name="monthfrom">';
	for ($x = 1; $x <= 12; $x++) {
		echo '<option value="' . $x . '"';
		if ($x==$param_monthfrom) { echo ' selected'; }
		echo '>' . $x;
	} 
	echo '</select>';
	echo '<select size="1" name="yearfrom">';
	for ($x = date("Y"); $x >= date("Y")-5; $x--) {
		echo '<option value="' . $x . '"';
		if ($x==$param_yearfrom) { echo ' selected'; }
		echo '>' . $x;
	} 
	echo '</select>';
	echo '<select size="1" name="dayto" style="margin-left:10px">';
	for ($x = 1; $x <= 31; $x++) {
		echo '<option value="' . $x . '"';
		if ($x==$param_dayto) { echo ' selected'; }
		echo '>' . $x;
	} 
	echo '</select>';
	echo '<select size="1" name="monthto">';
	for ($x = 1; $x <= 12; $x++) {
		echo '<option value="' . $x . '"';
		if ($x==$param_monthto) { echo ' selected'; }
		echo '>' . $x;
	} 
	echo '</select>';
	echo '<select size="1" name="yearto">';
	for ($x = date("Y"); $x >= date("Y")-5; $x--) {
		echo '<option value="' . $x . '"';
		if ($x==$param_yearto) { echo ' selected'; }
		echo '>' . $x;
	} 
	echo '</select>';
	echo '<select size="1" name="user" style="margin-left:20px;margin-right:20px">';
	echo '<option value="">Alle klanten</option>';

	$args = array(
		'role'         => 'subscriber',
		'orderby'      => 'display_name',
		'order'        => 'ASC'
		);

	$users = get_users( $args );
	foreach ($users as $user) {
		echo '<option value="' . $user->ID . '"';
		if ($user->ID==$param_user) { echo ' selected'; }
		echo '>' . $user->display_name;
	}

	echo '</select>';

	echo '<input type="submit" value="Show" class="button" style="margin-right:5px">';

	echo '<a href="admin-ajax.php?action=ajax_get_csv&year=' . $param_year . '&user=' . $param_user;

	if (isset($_GET["yearto"])&&is_numeric($_GET["yearto"]))
	{
		echo '&dayfrom=' . $param_dayfrom . '&monthfrom=' . $param_monthfrom . '&yearfrom=' . $param_yearfrom . '&dayto=' . $param_dayto . '&monthto=' . $param_monthto . '&yearto=' . $param_yearto;
	}

	echo '" class="download"><i class="fa fa-arrow-circle-o-down"></i></a>';

	echo '</form>';

	// var_dump(get_company_stats(1140170, 0, 0, 0, 1, 1, 2015, 31, 12, 2016));

	if (isset($_GET["yearto"])&&is_numeric($_GET["yearto"]))
	{
		// get custom period list
		$stats = get_stats(null, $param_user, $param_dayfrom, $param_monthfrom, $param_yearfrom, $param_dayto, $param_monthto, $param_yearto);
	}
	else
	{
		// get initial list
		$stats = get_stats($param_year, $param_user);
	}

	echo '<div class="wrap">';
	echo '<div class="table-row table-header">';
	echo '<div class="table-cell">Fiche</div>';
	foreach ($actions as $value) {
		echo '<div class="table-cell">' . $value . '</div>';
	}
	echo '<div class="table-cell">Bedrijven</div>';
	echo '</div>';

	foreach ($stats as $stat) {
		echo '<div class="table-row">';
		echo '<div class="table-cell"><a href="#" class="fiche" data-post_id="' . $stat->post_id . '" data-title="' . $stat->post_title . '">' . $stat->post_title . '</a><a href="admin-ajax.php?action=ajax_get_csv&yearfrom=' . $param_yearfrom . '&yearto=' . $param_yearto . '&user=' . $param_user . '&post_id=' . $stat->post_id . '" class="download"><i class="fa fa-arrow-circle-o-down"></i></a></div>';
		foreach ($actions as $value) {
			echo '<div class="table-cell">' . $stat->$value . '</div>';
		}
		echo '<div class="table-cell"><a href="#" class="fiche-company" data-post_id="' . $stat->post_id . '" data-title="' . $stat->post_title . '" data-day="0" data-month="0" data-year="0">' . $stat->companies . '</a></div>';
		echo '</div>';
	}

	echo '</div>';
}