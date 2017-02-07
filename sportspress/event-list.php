<?php
/**
 * Event List
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version     1.5
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

$defaults = array(
    'id' => null,
    'status' => 'default',
    'date' => 'default',
    'date_from' => 'default',
    'date_to' => 'default',
    'number' => -1,
    'show_team_logo' => get_option('sportspress_event_list_show_logos', 'no') == 'yes' ? true : false,
    'link_teams' => get_option('sportspress_link_teams', 'no') == 'yes' ? true : false,
    'link_venues' => get_option('sportspress_link_venues', 'yes') == 'yes' ? true : false,
    'sortable' => get_option('sportspress_enable_sortable_tables', 'yes') == 'yes' ? true : false,
    'scrollable' => get_option('sportspress_enable_scrollable_tables', 'yes') == 'yes' ? true : false,
    'responsive' => get_option('sportspress_enable_responsive_tables', 'yes') == 'yes' ? true : false,
    'paginated' => get_option('sportspress_event_list_paginated', 'yes') == 'yes' ? true : false,
    'rows' => get_option('sportspress_event_list_rows', 10),
    'order' => 'default',
    'columns' => null,
    'show_all_events_link' => false,
    'caption' => 'Fixtures & Results test'
);

extract($defaults, EXTR_SKIP);

$calendar = new SP_Calendar($id);
if ($status != 'default')
    $calendar->status = $status;
if ($date != 'default')
    $calendar->date = $date;
if ($date_from != 'default')
    $calendar->from = $date_from;
if ($date_to != 'default')
    $calendar->to = $date_to;
if ($order != 'default')
    $calendar->order = $order;
$data = $calendar->data();
$usecolumns = $calendar->columns;
$title_format = get_option('sportspress_event_list_title_format', 'title');
$time_format = get_option('sportspress_event_list_time_format', 'combined');

if (isset($columns)):
    if (is_array($columns))
        $usecolumns = $columns;
    else
        $usecolumns = explode(',', $columns);
endif;

if ($id) {
    echo '<h4 class="sp-table-caption yellow-head">' . $caption . '</h4>';
}
?>
<div class="sp-template sp-template-event-list" >
    <div class="sp-table-wrapper<?php if ($scrollable) { ?> sp-scrollable-table-wrapper<?php } ?>">
        <table class="sp-event-blocks sp-data-table sp-paginated-table sp-data-table<?php if ($responsive) { ?> sp-responsive-table<?php } if ($paginated) { ?> sp-paginated-table<?php } if ($sortable) { ?> sp-sortable-table<?php } ?>" data-sp-rows="<?php echo $rows; ?>">
            <tbody
            <?php
            $i = 0;
            if (is_numeric($number) && $number > 0)
                $limit = $number;
            foreach ($data as $event):
                if (isset($limit) && $i >= $limit)
                    continue;

                $teams = get_post_meta($event->ID, 'sp_team');
                $video = get_post_meta($event->ID, 'sp_video', true);

                $main_results = sp_get_main_results($event);

                $teams_output = '';
                $teams_array = array();
                $team_logos = array();

                if ($teams):
                    foreach ($teams as $team):
                        $name = get_the_title($team);
                        if ($name):

                            if ($show_team_logo):
                                $name = sp_get_logo($team, 'mini') . ' ' . $name;
                                $team_logos[] = sp_get_logo($team, array(90, 90));
//                                    echo '<pre>';print_r($team_logos);echo '</pre>';
                            endif;

                            if ($link_teams):
                                $team_output = '<a href="' . get_post_permalink($team) . '">' . $name . '</a>';
                            else:
                                $team_output = $name;
                            endif;

                            $team_result = sp_array_value($main_results, $team, null);

                            if ($team_result != null):
                                if ($usecolumns != null && !in_array('time', $usecolumns)):
                                    $team_output .= ' (' . $team_result . ')';
                                endif;
                            endif;

                            $teams_array[] = $team_output;

                            $teams_output .= $team_output . '<br>';
                        endif;
                    endforeach;
                else:
                    $teams_output .= '&mdash;';
                endif;

                echo '<tr class="sp-row sp-post' . ( $i % 2 == 0 ? ' alternate' : '' ) . '"><td>';
                echo '<h5 class="event-date">' . get_post_time(get_option('date_format'), false, $event, true) . '</h5>';
                switch ($title_format) {
                    case 'homeaway':
                        if (sp_column_active($usecolumns, 'event')) {
                            $team = array_shift($teams_array);
                            echo '<h5 class="data-home">' . $team . '</h5>';

                            if ('combined' == $time_format && sp_column_active($usecolumns, 'time')) {
                                echo '<h5 class="event-time">';
                                if (!empty($main_results)):
                                    echo implode(' - ', $main_results);
                                else:
                                    echo sp_get_time($event);
                                endif;
                                echo '</h5>';
                            } elseif (in_array($time_format, array('separate', 'results')) && sp_column_active($usecolumns, 'results')) {
                                echo '<h5 class="event-results">';
                                if (!empty($main_results)):
                                    echo implode(' - ', $main_results);
                                else:
                                    echo '-';
                                endif;
                                echo '</h5>';
                            }

                            $team = array_shift($teams_array);
                            echo '<td class="data-away">' . $team . '</td>';

                            if (in_array($time_format, array('separate', 'time')) && sp_column_active($usecolumns, 'time')) {
                                echo '<h5 class="evetn-time">';
                                echo sp_get_time($event);
                                echo '</h5>';
                            }
                        }
                        break;

                    default:
                        if (sp_column_active($usecolumns, 'event')) {
                            if ($title_format == 'teams')
                                echo '<h4 class="event-title data-teams">' . $teams_output . '</h4>';
                            else
                                echo "<div class='logo-odd'>" . $team_logos[0] . "</div>";
                            echo $main_results[0] > $main_results[1] ? "<label class='green-head'>WON</label>" : "<label class='red-head'>LOST</label>";
                            echo "<div class='logo-even'>" . $team_logos[1] . "</div>";
                            echo $main_results[1] > $main_results[0] ? "<label class='green-head'>WON</label>" : "<label class='red-head'>LOST</label>";
                            echo "<h4 class='event-title'><a href='" . get_permalink($event->ID) . "'>" . $event->post_title . "</a></h4>";
                        }

                        switch ($time_format) {
                            case 'separate':
                                if (sp_column_active($usecolumns, 'time')) {
                                    echo '<h4 class="event-time">';
                                    echo sp_get_time($event);
                                    echo '</h4>';
                                }
                                if (sp_column_active($usecolumns, 'results')) {
                                    echo '<h4 class="event-results">';
                                    if (!empty($main_results)):
                                        echo implode(' - ', $main_results);
                                    else:
                                        echo '-';
                                    endif;
                                    echo '</h4>';
                                }
                                break;
                            case 'time':
                                if (sp_column_active($usecolumns, 'time')) {
                                    echo '<h4 class="event-time">';
                                    echo sp_get_time($event);
                                    echo '</h4>';
                                }
                                break;
                            case 'results':
                                if (sp_column_active($usecolumns, 'results')) {
                                    echo '<h4 class="event-results">';
                                    if (!empty($main_results)):
                                        echo implode(' - ', $main_results);
                                    else:
                                        echo '-';
                                    endif;
                                    echo '</h4>';
                                }
                                break;
                            /* default:
                              if (sp_column_active($usecolumns, 'time')) {
                              echo '<h4 class="event-time">';
                              if (!empty($main_results)):
                              echo implode(' - ', $main_results);
                              else:
                              echo  sp_get_time($event);
                              endif;
                              echo '</h4>';
                              } */
                        }
                }

                if (sp_column_active($usecolumns, 'league')):
                    echo '<h5 class="event-league">';
                    $leagues = get_the_terms($event->ID, 'sp_league');
                    if ($leagues): foreach ($leagues as $league):
                            echo $league->name;
                        endforeach;
                    endif;
                    echo '</h5>';
                endif;

                if (sp_column_active($usecolumns, 'season')):
                    echo '<h5 class="event-season">';
                    $seasons = get_the_terms($event->ID, 'sp_season');
                    if ($seasons): foreach ($seasons as $season):
                            echo $season->name;
                        endforeach;
                    endif;
                    echo '</h5>';
                endif;

                if (sp_column_active($usecolumns, 'venue')):
                    echo '<h5 class="event-venue">';
                    if ($link_venues):
                        the_terms($event->ID, 'sp_venue');
                    else:
                        $venues = get_the_terms($event->ID, 'sp_venue');
                        if ($venues): foreach ($venues as $venue):
                                echo $venue->name;
                            endforeach;
                        endif;
                    endif;
                    echo '</h5>';
                endif;

                if (sp_column_active($usecolumns, 'article')):
                    echo '<h6 class="event-article">
								<a href="' . get_permalink($event->ID) . '">';

                    if ($video):
                        echo '<div class="dashicons dashicons-video-alt"></div>';
                    elseif (has_post_thumbnail($event->ID)):
                        echo '<div class="dashicons dashicons-camera"></div>';
                    endif;
                    if ($event->post_content !== null):
                        if ($event->post_status == 'publish'):
                            _e('Recap', 'sportspress');
                        else:
                            _e('Preview', 'sportspress');
                        endif;
                    endif;

                    echo '</a>
							</td>';
                endif;

                echo '</h6></tr>';

                $i++;
            endforeach;
            ?>
        </tbody>
    </table>
</div>
<?php
if ($id && $show_all_events_link)
    echo '<a class="sp-calendar-link sp-view-all-link" href="' . get_permalink($id) . '">' . __('View all events', 'sportspress') . '</a>';
?>
</div>