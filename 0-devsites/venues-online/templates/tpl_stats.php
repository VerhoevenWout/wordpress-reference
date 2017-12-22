<?php
/**
 * Template Name: Statistics
 *
 * @package oxygen
 */

$actions = array("list", "view", "visit", "email", "phone", "capacity");

$today = getdate();

get_header();

$user_id = get_current_user_id();

if (!$user_id)
{
    $breadcrumbs = array(
        array(
            'title' => __('Log in','captions')
        ),
    );
    // include(locate_template('partials/breadcrumbs.php'));

    echo '<section><div class="row login"><div class="content small-24 medium-12 columns"><h1>' . __('Log in','captions') . '</h1>';

    $args = array(
        'label_username' => __('Username','captions'),
        'label_password' => __('Password','captions'),
        'label_remember' => __('Stay logged in','captions'),
        'label_log_in' => __('Log in','captions'),
        'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
        'remember' => true,
        'echo' => false
    );
    $form = wp_login_form( $args );

    $form = str_replace('<form','<section class="sg-btn-group"><form class="standardform"',$form);
    $form = str_replace('<p class="','<div class="row ',$form);
    $form = str_replace('<label','<div class="small-6 columns"><label',$form);
    $form = str_replace('</label>','</label></div>',$form);
    $form = str_replace('<input type="text"','<div class="small-18 columns"><input type="text"',$form);
    $form = str_replace('<input type="password"','<div class="small-18 columns"><input type="password"',$form);
    $form = str_replace('</p>','</div></div>',$form);
    $form = str_replace('</div></div></div>','</div></div>',$form);

    $form = str_replace('<div class="row login-remember">','<div class="row login-remember"><div class="small-6 columns whitespace">&nbsp;</div>',$form);
    $form = str_replace('<div class="small-6 columns"><label><input name="rememberme"','<div class="small-18 columns"><label><input name="rememberme" type="checkbox" id="rememberme"',$form);
    // <label><input name="rememberme" type="checkbox" id="rememberme" value="forever"> Stay logged in</label>

    $form = str_replace('button-primary','primary btn btn-large',$form);
    $form = str_replace('</form>','</form></section>',$form);

    $form = str_replace('/user-statistics/','/user-statistics/?' . time(),$form);

    echo $form;

    echo "</div></div></section>";
}
else
{
    $stats_view = 1;
    $columns = 4;

    // get_stat_fiches in controller.php
    $fiches = get_fiches('_fiche_user', $user_id);

    $used_fiches = [];

    echo '<div class="row"><div class="small-24 columns stats"><h1>My statistics</h1>';
    echo '<section class="row"><div class="small-24"><div class="stats-period">';

    echo '<div class="row expanded period">';

        echo '<div class="small-12 columns period-from">';
            echo '<label> <strong>';
            echo _e('From', 'captions');
            echo '</strong></label>';

            echo '<div class="period-option"><small>';
            echo _e('Day', 'captions');
            echo '</small><select size="1" id="dayfrom"><option value="0">0</option>';
            for ($x = 1; $x <= 31; $x++) {
                echo '<option value="' . $x . '"';
                if ($x==$param_dayfrom) { echo ' selected'; }
                echo '>' . $x . '</option>';
            } 
            echo '</select>';
            echo '</div>';

            echo '<div class="period-option"><small>';
            echo _e('Month', 'captions');
            echo '</small><select size="1" id="monthfrom"><option value="0">0</option>';
            for ($x = 1; $x <= 12; $x++) {
                echo '<option value="' . $x . '">' . $x . '</option>';
            } 
            echo '</select>';
            echo '</div>';

            echo '<div class="period-option"><small>';
            echo _e('Year', 'captions');
            echo '</small><select size="1" id="yearfrom"><option value="0">0</option>';
            for ($x = date("Y"); $x >= date("Y")-5; $x--) {
                echo '<option value="' . $x . '">' . $x . '</option>';
            } 
            echo '</select>';
            echo '</div>';
        echo '</div>';

       echo '<div class="small-12 columns period-to">';
            echo '<label><strong>';
            echo _e('To', 'captions');
            echo '</strong></label>';

            echo '<div class="period-option"><small>';
            echo _e('Day', 'captions');
            echo '</small><select size="1" id="dayto"><option value="0">0</option>';
            for ($x = 1; $x <= 31; $x++) {
                if ($x == $today['mday']) {
                    echo '<option selected="selected" value="' . $x . '">' . $x . '</option>';

                } else{
                    echo '<option value="' . $x . '">' . $x . '</option>';
                }
            } 
            echo '</select>';
            echo '</div>';

            echo '<div class="period-option"><small>';
            echo _e('Month', 'captions');
            echo '</small><select size="1" id="monthto"><option value="0">0</option>';
            for ($x = 1; $x <= 12; $x++) {
                if ($x == $today['mon']) {
                    echo '<option selected="selected" value="' . $x . '">' . $x . '</option>';

                } else{
                    echo '<option value="' . $x . '">' . $x . '</option>';
                }
            } 
            echo '</select>';
            echo '</div>';

            echo '<div class="period-option"><small>';
            echo _e('Year', 'captions');
            echo '</small><select size="1" id="yearto"><option value="0">0</option>';
            for ($x = date("Y"); $x >= date("Y")-5; $x--) {
                // check if date is equal value
                if ($x == $today['year']) {
                    echo '<option selected="selected" value="' . $x . '">' . $x . '</option>';

                } else{
                    echo '<option value="' . $x . '">' . $x . '</option>';
                }
            } 
            echo '</select>';
            echo '</div>';
        echo '</div>';

        echo '<div class="small-24 columns button-container"><button class="btn primary initStats">' . __('Select','captions') . '</button><button class="btn-clearstats clearStats btn secondary">' . __('Clear','captions') . '</button><a href="';
        echo wp_logout_url( '/' ) . '" class="btn-logout logOut btn secondary">' . __('Logout','captions') . '</a></div>';

    echo '</div></div>';

    echo '</div></section>';

    echo '<section id="fichesanchor" class="fiches" data-types="' . implode(",", $actions) . '" data-companies_title="' . __('Companies','captions') . '">';

    // first loop for fiches with linked fiches
    foreach ($fiches as $fiche)
    {
        $linked_fiches = get_post_meta($fiche->post_id, '_fiche_fiche');
        $used_fiches = array_merge($used_fiches, $linked_fiches);

        if(count($linked_fiches)>0)
        {
            array_push($used_fiches, $fiche->post_id);

            echo '<div class="row expanded featured" data-post_id="' . $fiche->post_id . ',' . implode (',', $linked_fiches) . '">';

            $p = $fiche;

            include(locate_template('templates/partials/fiche-loop.php')); 

            echo '<div class="xmedium-6 small-24 columns companies"></div>';
            echo '<div class="xmedium-12 small-24 columns graph"></div>';
            echo '</div>';
        }
    }

    // second loop for fiches without linked fiches and not linked to fiches in previous loop
    foreach ($fiches as $fiche)
    {
        $linked_fiches = get_post_meta($fiche->post_id, '_fiche_fiche');

        if((count($linked_fiches)==0)&&(!in_array($fiche->post_id, $used_fiches)))
        {
            echo '<div class="row featured" data-post_id="' . $fiche->post_id . '">';

            $p = $fiche;

            include(locate_template('templates/partials/fiche-loop.php'));

            echo '<div class="xmedium-6 small-24 columns companies"></div>';
            echo '<div class="xmedium-12 small-24 columns graph"></div>';
            echo '</div>';
        }
    }

    //var_dump($used_fiches);

    echo '</section>';
    echo '</div></div>';

}

get_footer();

?>