<?php


if( stristr( $_SERVER['SERVER_NAME'], "loc" ) || stristr( $_SERVER['SERVER_NAME'], "xip.io" ) ) {
    $statsdb = "venues-online";
} elseif(stristr( $_SERVER['SERVER_NAME'], "exclusivewellnessbe.webhosting.be" ) || stristr( $_SERVER['SERVER_NAME'], "staging.exclusivewellness.be" ) ){
    $statsdb = "venues-online";
} else{
    $statsdb = "venues-online";
}


function get_stats($year = null, $user, $dayfrom = null, $monthfrom = null, $yearfrom = null, $dayto = null, $monthto = null, $yearto = null) {
    global $wpdb;
    global $actions;
    global $statsdb;

    // echo $statsdb;
    
    if(($user>0)||(!$year))
    {
        $sql = "select post_id, concat(" . $wpdb->prefix . "posts.post_title, ' (', upper(t.language_code), ')') as post_title";

        foreach ($actions as $value) {
            $sql .= ", MAX(IF(action = '$value', quantity, 0)) $value";
        }

        $sql .= ", (select count(distinct name) from " . $statsdb . ".companies where ipaddress in (select ipaddress from " . $statsdb . ".actions where (actions.time > '" . $yearfrom . "-" . $monthfrom . "-" . $dayfrom . "' or actions.time = '" . $yearfrom . "-" . $monthfrom . "-" . $dayfrom . "') and (actions.time < '" . $yearto . "-" . $monthto . "-" . $dayto . " 23:59:59' or actions.time = '" . $yearto . "-" . $monthto . "-" . $dayto . " 23:59:59') and actions.post_id = b.post_id and actions.site_id = " . get_current_blog_id() . ")) as companies from (select post_id, action, count(*) as quantity from " . $statsdb . ".actions where site_id = " . get_current_blog_id() . " and (time > '" . $yearfrom . "-" . $monthfrom . "-" . $dayfrom . "' or time = '" . $yearfrom . "-" . $monthfrom . "-" . $dayfrom . "') and (time < '" . $yearto . "-" . $monthto . "-" . $dayto . " 23:59:59' or time = '" . $yearto . "-" . $monthto . "-" . $dayto . " 23:59:59')";

        if($user>0)
        {
            $sql .= " and post_id in (select post_id from " . $wpdb->prefix . "postmeta where meta_key = '_fiche_user' AND meta_value = $user)";
        }

    // security: if user is no administrator, only get data from linked posts
        $user_id = get_current_user_id();
        if (!$user_id)
        {
            if(get_userdata($user_id)->roles[0]!='administrator')
            {
                $sql .= " and post_id in (select post_id from " . $wpdb->prefix . "postmeta where meta_key = '_fiche_user' AND meta_value = $user_id)";
            }
        }

        $sql .= " group by post_id, action order by post_id, action) b join " . $wpdb->prefix . "posts on " . $wpdb->prefix . "posts.ID = b.post_id join " . $wpdb->prefix . "icl_translations AS t on " . $wpdb->prefix . "posts.ID=t.element_id and t.element_type = 'post_fiche' group by b.post_id, " . $wpdb->prefix . "posts.post_title";
    }
    else
    {
        $sql = "select post_id, post_title";
        foreach ($actions as $value) {
            $sql .= ", $value";
        }
        $sql .= ", companies from " . $statsdb . ".report where site_id = " . get_current_blog_id() . " and period = " . $year;

        $user_id = get_current_user_id();
        if (!$user_id)
        {
            if(get_userdata($user_id)->roles[0]!='administrator')
            {
                $sql .= " and post_id in (select post_id from " . $wpdb->prefix . "postmeta where meta_key = '_fiche_user' AND meta_value = $user_id)";
            }
        }

        $sql .= " order by post_title";
    }

    $result = $wpdb->get_results($sql);

    return $result;
}

// function get_stats_by_month($post_id, $yearfrom, $yearto) {
//     global $wpdb;
//     global $actions;
//     global $statsdb;

//     $sql = "select year, month, CASE month when 1 then 'Januari' when 2 then 'Februari' when 3 then 'Maart' when 4 then 'April' when 5 then 'Mei' when 6 then 'Juni' when 7 then 'Juli' when 8 then 'Augustus' when 9 then 'September' when 10 then 'Oktober' when 11 then 'November' when 12 then 'December' END as monthDisplay";

//     foreach ($actions as $value) {
//         $sql .= ", MAX(IF(action = '$value', quantity, 0)) $value";
//     }
    
//     $sql .= ", (select count(distinct name) from " . $statsdb . ".companies where ipaddress in (select ipaddress from " . $statsdb . ".actions where actions.site_id = " . get_current_blog_id() . " and year(actions.time) = b.year and month(actions.time) = b.month and actions.post_id = $post_id)) as companies from (select year(time) as year, month(time) as month, action, count(*) as quantity from " . $statsdb . ".actions where post_id = $post_id and site_id = " . get_current_blog_id();

//     // security: if user is no administrator, only get data from linked posts
//     $user_id = get_current_user_id();
//     if (!$user_id)
//     {
//         if(get_userdata($user_id)->roles[0]!='administrator')
//         {
//             $sql .= " and post_id in (select post_id from " . $wpdb->prefix . "postmeta where meta_key = '_fiche_user' AND meta_value = $user_id)";
//         }
//     }

//     $sql .= " and (year(time) = " . $yearfrom . " or year(time) > " . $yearfrom . ") and (year(time) = " . $yearto . " or year(time) < " . $yearto . ") group by year(time), month(time), action order by month(time), action) b group by b.year, b.month order by b.year, b.month";

//     $result = $wpdb->get_results($sql);

//     return $result;
// }

function get_stats_by_day($post_id, $year, $month, $dayfrom = null, $monthfrom = null, $yearfrom = null, $dayto = null, $monthto = null, $yearto = null) {
    global $wpdb;
    global $actions;
    global $statsdb;

    $post_id = save_post_id($post_id);

    $sql = "select case WEEKDAY(CONCAT($year,'-',month,'-',day)) when 0 then 'Maandag' when 1 then 'Dinsdag' when 2 then 'Woensdag' when 3 then 'Donderdag' when 4 then 'Vrijdag' when 5 then 'Zaterdag' when 6 then 'Zondag' end as dayDisplay, day, month, CASE month when 1 then 'Januari' when 2 then 'Februari' when 3 then 'Maart' when 4 then 'April' when 5 then 'Mei' when 6 then 'Juni' when 7 then 'Juli' when 8 then 'Augustus' when 9 then 'September' when 10 then 'Oktober' when 11 then 'November' when 12 then 'December' END as monthDisplay, year";

    foreach ($actions as $value) {
        $sql .= ", MAX(IF(action = '$value', quantity, 0)) $value";
    }
    
    $sql .= ", (select count(distinct name) from companies where ipaddress in (select ipaddress from actions where actions.site_id = " . get_current_blog_id() . " and year(actions.time) = b.year and month(actions.time) = b.month and day(actions.time) = b.day and actions.post_id in (" . $post_id . "))) as companies from (select day(time) as day, month(time) as month, year(time) as year, action, count(*) as quantity from actions where post_id in (" . $post_id . ") and site_id = " . get_current_blog_id();

    // security: if user is no administrator, only get data from linked posts
    $user_id = get_current_user_id();
    if (!$user_id)
    {
        if(get_userdata($user_id)->roles[0]!='administrator')
        {
            $sql .= " and post_id in (select post_id from " . $wpdb->prefix . "postmeta where meta_key = '_fiche_user' AND meta_value = $user_id)";
        }
    }

    if(($year==0)&&($yearto))
    {
        $sql .= " and (time > '" . $yearfrom . "-" . $monthfrom . "-" . $dayfrom . "' or time = '" . $yearfrom . "-" . $monthfrom . "-" . $dayfrom . "') and (time < '" . $yearto . "-" . $monthto . "-" . $dayto . " 23:59:59' or time = '" . $yearto . "-" . $monthto . "-" . $dayto . " 23:59:59')";
    }
    else
    {
        $sql .= " and year(time) = $year and month(time) = $month";
    }
    $sql .= " group by day(time), month(time), year(time), action order by day(time), month(time), year(time), action) b group by b.day, b.month, b.year order by b.year, b.month, b.day";

    // var_dump($sql);

    $result = $wpdb->get_results($sql);

    return $result;
}

function get_company_stats($post_id, $year, $month, $day, $dayfrom = null, $monthfrom = null, $yearfrom = null, $dayto = null, $monthto = null, $yearto = null) {
    global $wpdb;
    global $actions;
    global $statsdb;

    $post_id = save_post_id($post_id);
    
    $sql = "select name, ipaddress";

    foreach ($actions as $value) {
        $sql .= ", MAX(IF(action = '$value', quantity, 0)) $value";
    }

    $sql .= " from (select companies.name, companies.ipaddress, actions.action, count(*) as quantity from actions join companies on companies.ipaddress = actions.ipaddress where";

    if(($year==0)&&($yearto))
    {
        $sql .= " (time > '" . $yearfrom . "-" . $monthfrom . "-" . $dayfrom . "' or time = '" . $yearfrom . "-" . $monthfrom . "-" . $dayfrom . "') and (time < '" . $yearto . "-" . $monthto . "-" . $dayto . " 23:59:59' or time = '" . $yearto . "-" . $monthto . "-" . $dayto . " 23:59:59')";
    }
    else
    {
        $sql .= " year(actions.time) = $year";

        if($month>0)
        {
            $sql .= " and month(actions.time) = $month";
        }

        if($day>0)
        {
            $sql .= " and day(actions.time) = $day";
        }
    }

    $sql .= " and actions.post_id in (" . $post_id . ") and actions.site_id = " . get_current_blog_id();

    // security: if user is no administrator, only get data from linked posts
    $user_id = get_current_user_id();
    if (!$user_id)
    {
        if(get_userdata($user_id)->roles[0]!='administrator')
        {
            $sql .= " and post_id in (select post_id from " . $wpdb->prefix . "postmeta where meta_key = '_fiche_user' AND meta_value = $user_id)";
        }
    }

    $sql .= " and companies.hidden = 0 group by companies.name, actions.action ) b group by b.name, b.ipaddress order by b.name, b.ipaddress";

    $result = $wpdb->get_results($sql);

    return $result;
}

function save_post_id($post_id)
{
    $post_ids_out = '';

    if (strpos($post_id, ",")) {
        $post_ids = explode(",", $post_id);

        foreach ($post_ids as $single_post_id) {
            if(is_numeric($single_post_id)) {
                if($post_ids_out!='') { $post_ids_out .= ','; }
                $post_ids_out .= $single_post_id;
            }
        }
    }
    else {
        if(is_numeric($post_id)) {
            $post_ids_out .= $post_id;
        }
    }

    if($post_ids_out=='')
    {
        $post_ids_out = '0';
    }

    return $post_ids_out;
}