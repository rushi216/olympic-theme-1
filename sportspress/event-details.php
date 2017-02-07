<?php
/**
 * Event Details
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version     1.4
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
if (get_option('sportspress_event_show_details', 'yes') === 'no')
    return;

if (!isset($id))
    $id = get_the_ID();

$scrollable = get_option('sportspress_enable_scrollable_tables', 'yes') == 'yes' ? true : false;
$date = get_the_time(get_option('date_format'), $id);
$time = get_the_time(get_option('time_format'), $id);

$data = array(__('Date', 'sportspress') => $date, __('Time', 'sportspress') => $time);

$taxonomies = apply_filters('sportspress_event_taxonomies', array('sp_league' => null, 'sp_season' => null));

foreach ($taxonomies as $taxonomy => $post_type):
    $terms = get_the_terms($id, $taxonomy);
    if ($terms):
        $obj = get_taxonomy($taxonomy);
        $term = array_shift($terms);
        $data[$obj->labels->singular_name] = $term->name;
    endif;
endforeach;
?>
<div class="sp-template sp-template-event-details">

    <div class="sp-table-wrapper<?php if ($scrollable) { ?> sp-scrollable-table-wrapper height<?php } ?>">
        <h4 class="sp-table-caption margin-top text-center"><?php _e('Next match', 'sportspress'); ?></h4>
        <table class="sp-event-details sp-data-table">

            <tbody>
                <tr><td><h4 class="event-title bold-text"><a href="http://localhost/wordpress/event/293/">
                            </a></h4></td></tr>
                <tr class="odd">
<?php $i = 0;
foreach ($data as $value): ?>
                        <td><?php echo $value; ?></td>
                    </tr>
    <?php $i++;
endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

