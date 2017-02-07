<?php
/**
 * League Table
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version     1.4
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
$defaults = array(
    'team_position_wrapper' => false,
    'competitions' => "",
    'show_horizontal' => 0,
    'tid' => "",
    'id' => get_the_ID(),
    'number' => -1,
    'columns' => null,
    'highlight' => null,
    'show_full_table_link' => false,
    'show_team_logo' => get_option('sportspress_table_show_logos', 'yes') == 'yes' ? true : false,
    'link_posts' => get_option('sportspress_link_teams', 'no') == 'yes' ? true : false,
    'sortable' => false,
    'scrollable' => get_option('sportspress_enable_scrollable_tables', 'yes') == 'yes' ? true : false,
    'responsive' => get_option('sportspress_enable_responsive_tables', 'yes') == 'yes' ? true : false,
    'paginated' => get_option('sportspress_table_paginated', 'yes') == 'yes' ? true : false,
    'rows' => 50,
);

extract($defaults, EXTR_SKIP);

$td_class = "";
$output = "";
$div_id = "";
global $wpdb;

$tids = explode(',', $tid);

if (!isset($highlight))
    $highlight = get_post_meta($id, 'sp_highlight', true);

$output .= '<div class="sp-table-wrapper' . ( $scrollable ? ' sp-scrollable-table-wrapper' : '' ) . '">';

$output .= '<table class="sp-league-table sp-data-table' . ( $responsive ? ' sp-responsive-table' : '' ) . ( $sortable ? ' sp-sortable-table' : '' ) . ( $paginated ? ' sp-paginated-table' : '' ) . '" data-sp-rows="' . $rows . '">' . '<thead>';

$table = new SP_League_Table($id);


$spmb = new SP_Meta_Box_Team_Columns();

$data = $table->data();
krsort($data);
// The first row should be column 
$labels = $data[0];

$count = 0;
// Remove the first row to leave us with the actual data
unset($data[0]);
$all_array = array();
$class = array('blue-head', 'green-head', 'yellow-head', 'red-head');

foreach ($tids as $t):
    foreach ($data as $team_id => $row):
        if ($t == $team_id) {
            $name = sp_array_value($row, 'name', null);
            $all_array[$name]['team_id'] = $t;
            $all_array[$name]['class'] = $class[$count];
            $count++;
        }
    endforeach;
endforeach;

if ($columns === null)
    $columns = get_post_meta($id, 'sp_columns', true);
$terms = get_the_terms($t, 'sp_league');
if ($terms):
    $leagues = array();
    foreach ($terms as $term):
        $leagues[] = $term->name;
    endforeach;
endif;

$season_id = $div_id;

if ($terms):
    foreach ($terms as $v):
        $league_id = $v->term_id;

        foreach ($tids as $res):
            $s = new SP_Team($res);
            list( $columns, $data, $placeholders ) = $s->columns($league_id);
            foreach ($data as $div_id => $div_stats):
                if ($div_id > 0):
                    foreach ($columns as $key => $value):
                        $point = sp_array_value(sp_array_value($data, $div_id, array()), $key, 0);
                        $ps[$v->name][] = intval($point);
                    endforeach;
                endif;
            endforeach;
        endforeach;
    endforeach;
endif;
$c = 0;

foreach ($all_array as $b => $name):
    $totalpoints = 0;
    if (isset($ps))
        foreach ($ps as $com => $points):
            $all_array[$b]['points'][$com] = $points[$c];
            $totalpoints+=$points[$c];
        endforeach;
    $c++;
    $all_array[$b]['totalpoints'] = $totalpoints;
endforeach;

if ($show_horizontal == 1) {
    $output .= '<thead><tr>';
    $output .= '<th class="data-name text-center league-header">Competition</th>';
    foreach ($all_array as $b => $c):
        $output .= '<th class="data-name text-center league-header ' . $c['class'] . '">' . $b . '</th>';
    endforeach;
    $output.='</tr>';
    $output.='</thead>';
    $output.='<tbody>';
    if (isset($ps))
        foreach ($ps as $comp => $points):
            $pageDetail = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . 'posts where post_title="Competition"'); //get page with name Competition
            $permalink = get_page_link($pageDetail[0]->ID);
            $permalink = rtrim($permalink, "/") . "?competition=";
            $comp = '<a href="' . $permalink . $comp . "&leaguetbl=" . $id . "&tid=" . $tid . '">' . $comp . '</a>';
            $output.='<tr>';
            $output .= '<td class="main-col">' . $comp . '</td>';
            foreach ($points as $p)
                $output .= '<td>' . $p . '</td>';
            $output.='</tr>';
        endforeach;

    $output .= '<tr>';
    $output .= '<td class="main-col total-points">TOTAL POINTS</td>';
    foreach ($all_array as $s) {
        $output .= '<td class="total-points">' . $s['totalpoints'] . '</td>';
    }
    $output .= '</tr>';
    $output .= '</tbody>' . '</table>';
    $output .= '</div>';
} else {
    $output .= '<th class="data-name text-center black-head' . $name_class . $td_class . '">Teams</th>';
    $output .= '<th class="data-name text-center black-head' . $name_class . $td_class . '">Points</th>';
    $output .= '<th class="data-name text-center black-head' . $name_class . $td_class . '">Position</th>';
    $output .='</thead>';
    $output .='<tbody>';
    $output .= '</tr>';

    $points_arr = array();
    foreach ($all_array as $key => $row) {
        $pageTitle = isset($_GET['competition']) ? $_GET['competition'] : get_the_title();
        $points_arr[$key] = $row['points'][$pageTitle];
    }

    array_multisort($points_arr, SORT_DESC, $all_array);
    $position = 1;

    foreach ($all_array as $key => $v):
        $pageTitle = isset($_GET['competition']) ? $_GET['competition'] : get_the_title();
        $output .= '<tr>';
        $output .= '<td class="text-center class1 ' . $v['class'] . '"><span class="visible-xs"></span><span class="hidden-xs">' . $key . '</span></td>';
        $output.= '<td class="text-center' . $td_class . '">' . $v['points'][$pageTitle] . '</td>';
        $output.= '<td class="text-center' . $td_class . '"># ' . $position . '</td>';
        $output .= '</tr>';
        $position++;
    endforeach;
    $output .='</tbody>';
    /* if ( $link_posts ):
      $permalink = get_post_permalink( $team_id );
      $name = '<a href="' . $permalink . '">' . $name . '</a>';
      endif;
      $output .= '<th class="data-name text-center '. $name_class . $td_class. $class .'">' . $name . '</th>'; */
}
$output .= '</table>';

$output .= '</div>';
/* if ( $show_full_table_link )
  $output .= '<a class="sp-league-table-link sp-view-all-link" href="' . get_permalink( $id ) . '">' . __( 'View full table', 'sportspress' ) . '</a>'; */


if (!$team_position_wrapper) {
    ?>
    <div class="sp-template sp-template-league-table">
        <?php echo $output; ?>
    </div>
    <?php
} else {
    $points_arr = array();
    foreach ($all_array as $key => $row) {
        $points_arr[$key] = $row['totalpoints'];
    }
    array_multisort($points_arr, SORT_DESC, $all_array);
    $output = '<div class="row">';
    $position = 1;
    foreach ($all_array as $key => $v):
        $output.= '<div class="col-lg-3 col-md-3 col-sm-3 text-center padding-zero">
                        <h1 class="number">#' . $position . '</h1>
                        <h3 class="points">Pts:' . $v['totalpoints'] . '</h3>
                            <div class="img-1 block-div ' . $v['class'] . '">';
        $output.=sp_get_logo($v['team_id'], 'medium');
        $output.='<h2>' . $key . '</h2>';
        $output.= //<div class="title">View more <i class="fa fa-caret-right"></i></div>
                '</div>
                    </div>';
        $position++;
    endforeach;
    $output.='</div>';
    echo $output;
}
?>

