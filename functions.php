<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */
/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if (version_compare($GLOBALS['wp_version'], '4.7-alpha', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
    return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
     * If you're building a theme based on Twenty Seventeen, use a find and replace
     * to change 'twentyseventeen' to the name of your theme in all the template files.
     */
    load_theme_textdomain('twentyseventeen');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    add_image_size('twentyseventeen-featured-image', 2000, 1200, true);

    add_image_size('twentyseventeen-thumbnail-avatar', 100, 100, true);

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus(array(
        'top' => __('Top Menu', 'twentyseventeen'),
        'social' => __('Social Links Menu', 'twentyseventeen'),
    ));

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    /*
     * Enable support for Post Formats.
     *
     * See: https://codex.wordpress.org/Post_Formats
     */
    add_theme_support('post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
    ));

    // Add theme support for Custom Logo.
    add_theme_support('custom-logo', array(
        'width' => 250,
        'height' => 250,
        'flex-width' => true,
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, and column width.
     */
    add_editor_style(array('assets/css/editor-style.css', twentyseventeen_fonts_url()));

    add_theme_support('starter-content', array(
        'widgets' => array(
            'sidebar-1' => array(
                'text_business_info',
                'search',
                'text_about',
            ),
            'sidebar-2' => array(
                'text_business_info',
            ),
            'sidebar-3' => array(
                'text_about',
                'search',
            ),
        ),
        'posts' => array(
            'home',
            'about' => array(
                'thumbnail' => '{{image-sandwich}}',
            ),
            'contact' => array(
                'thumbnail' => '{{image-espresso}}',
            ),
            'blog' => array(
                'thumbnail' => '{{image-coffee}}',
            ),
            'homepage-section' => array(
                'thumbnail' => '{{image-espresso}}',
            ),
        ),
        'attachments' => array(
            'image-espresso' => array(
                'post_title' => _x('Espresso', 'Theme starter content', 'twentyseventeen'),
                'file' => 'assets/images/espresso.jpg',
            ),
            'image-sandwich' => array(
                'post_title' => _x('Sandwich', 'Theme starter content', 'twentyseventeen'),
                'file' => 'assets/images/sandwich.jpg',
            ),
            'image-coffee' => array(
                'post_title' => _x('Coffee', 'Theme starter content', 'twentyseventeen'),
                'file' => 'assets/images/coffee.jpg',
            ),
        ),
        'options' => array(
            'show_on_front' => 'page',
            'page_on_front' => '{{home}}',
            'page_for_posts' => '{{blog}}',
        ),
        'theme_mods' => array(
            'panel_1' => '{{homepage-section}}',
            'panel_2' => '{{about}}',
            'panel_3' => '{{blog}}',
            'panel_4' => '{{contact}}',
        ),
        'nav_menus' => array(
            'top' => array(
                'name' => __('Top Menu', 'twentyseventeen'),
                'items' => array(
                    'page_home',
                    'page_about',
                    'page_blog',
                    'page_contact',
                ),
            ),
            'social' => array(
                'name' => __('Social Links Menu', 'twentyseventeen'),
                'items' => array(
                    'link_yelp',
                    'link_facebook',
                    'link_twitter',
                    'link_instagram',
                    'link_email',
                ),
            ),
        ),
    ));
}

add_action('after_setup_theme', 'twentyseventeen_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

    $content_width = 700;

    if (twentyseventeen_is_frontpage()) {
        $content_width = 1120;
    }

    /**
     * Filter Twenty Seventeen content width of the theme.
     *
     * @since Twenty Seventeen 1.0
     *
     * @param $content_width integer
     */
    $GLOBALS['content_width'] = apply_filters('twentyseventeen_content_width', $content_width);
}

add_action('after_setup_theme', 'twentyseventeen_content_width', 0);

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
    $fonts_url = '';

    /**
     * Translators: If there are characters in your language that are not
     * supported by Libre Franklin, translate this to 'off'. Do not translate
     * into your own language.
     */
    $libre_franklin = _x('on', 'Libre Franklin font: on or off', 'twentyseventeen');

    if ('off' !== $libre_franklin) {
        $font_families = array();

        $font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

        $query_args = array(
            'family' => urlencode(implode('|', $font_families)),
            'subset' => urlencode('latin,latin-ext'),
        );

        $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    }

    return esc_url_raw($fonts_url);
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints($urls, $relation_type) {
    if (wp_style_is('twentyseventeen-fonts', 'queue') && 'preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }

    return $urls;
}

add_filter('wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'twentyseventeen'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'twentyseventeen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Footer 1', 'twentyseventeen'),
        'id' => 'sidebar-2',
        'description' => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Footer 2', 'twentyseventeen'),
        'id' => 'sidebar-3',
        'description' => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'twentyseventeen_widgets_init');

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more($link) {
    if (is_admin()) {
        return $link;
    }

    $link = sprintf('<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>', esc_url(get_permalink(get_the_ID())),
            /* translators: %s: Name of current post */ sprintf(__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen'), get_the_title(get_the_ID()))
    );
    return ' &hellip; ' . $link;
}

add_filter('excerpt_more', 'twentyseventeen_excerpt_more');

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

add_action('wp_head', 'twentyseventeen_javascript_detection', 0);

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", get_bloginfo('pingback_url'));
    }
}

add_action('wp_head', 'twentyseventeen_pingback_header');

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap() {
    if ('custom' !== get_theme_mod('colorscheme') && !is_customize_preview()) {
        return;
    }

    require_once( get_parent_theme_file_path('/inc/color-patterns.php') );
    $hue = absint(get_theme_mod('colorscheme_hue', 250));
    ?>
    <style type="text/css" id="custom-theme-colors" <?php if (is_customize_preview()) {
        echo 'data-hue="' . $hue . '"';
    } ?>>
        <?php echo twentyseventeen_custom_colors_css(); ?>
    </style>
<?php
}

add_action('wp_head', 'twentyseventeen_colors_css_wrap');

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts() {
    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style('twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null);

    // Theme stylesheet.
    wp_enqueue_style('twentyseventeen-style', get_stylesheet_uri());

    // Load the dark colorscheme.
    if ('dark' === get_theme_mod('colorscheme', 'light') || is_customize_preview()) {
        wp_enqueue_style('twentyseventeen-colors-dark', get_theme_file_uri('/assets/css/colors-dark.css'), array('twentyseventeen-style'), '1.0');
    }

    // Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
    if (is_customize_preview()) {
        wp_enqueue_style('twentyseventeen-ie9', get_theme_file_uri('/assets/css/ie9.css'), array('twentyseventeen-style'), '1.0');
        wp_style_add_data('twentyseventeen-ie9', 'conditional', 'IE 9');
    }

    // Load the Internet Explorer 8 specific stylesheet.
    wp_enqueue_style('twentyseventeen-ie8', get_theme_file_uri('/assets/css/ie8.css'), array('twentyseventeen-style'), '1.0');
    wp_style_add_data('twentyseventeen-ie8', 'conditional', 'lt IE 9');

    // Load the html5 shiv.
    wp_enqueue_script('html5', get_theme_file_uri('/assets/js/html5.js'), array(), '3.7.3');
    wp_script_add_data('html5', 'conditional', 'lt IE 9');

    wp_enqueue_script('twentyseventeen-skip-link-focus-fix', get_theme_file_uri('/assets/js/skip-link-focus-fix.js'), array(), '1.0', true);

    $twentyseventeen_l10n = array(
        'quote' => twentyseventeen_get_svg(array('icon' => 'quote-right')),
    );

    if (has_nav_menu('top')) {
        wp_enqueue_script('twentyseventeen-navigation', get_theme_file_uri('/assets/js/navigation.js'), array(), '1.0', true);
        $twentyseventeen_l10n['expand'] = __('Expand child menu', 'twentyseventeen');
        $twentyseventeen_l10n['collapse'] = __('Collapse child menu', 'twentyseventeen');
        $twentyseventeen_l10n['icon'] = twentyseventeen_get_svg(array('icon' => 'angle-down', 'fallback' => true));
    }

    wp_enqueue_script('twentyseventeen-global', get_theme_file_uri('/assets/js/global.js'), array('jquery'), '1.0', true);

    wp_enqueue_script('jquery-scrollto', get_theme_file_uri('/assets/js/jquery.scrollTo.js'), array('jquery'), '2.1.2', true);

    wp_localize_script('twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'twentyseventeen_scripts');

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr($sizes, $size) {
    $width = $size[0];

    if (740 <= $width) {
        $sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
    }

    if (is_active_sidebar('sidebar-1') || is_archive() || is_search() || is_home() || is_page()) {
        if (!( is_page() && 'one-column' === get_theme_mod('page_options') ) && 767 <= $width) {
            $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
        }
    }

    return $sizes;
}

add_filter('wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2);

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag($html, $header, $attr) {
    if (isset($attr['sizes'])) {
        $html = str_replace($attr['sizes'], '100vw', $html);
    }
    return $html;
}

add_filter('get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentyseventeen_post_thumbnail_sizes_attr($attr, $attachment, $size) {
    if (is_archive() || is_search() || is_home()) {
        $attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
    } else {
        $attr['sizes'] = '100vw';
    }

    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3);

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template($template) {
    return is_home() ? '' : $template;
}

add_filter('frontpage_template', 'twentyseventeen_front_page_template');

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path('/inc/custom-header.php');

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path('/inc/template-tags.php');

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path('/inc/template-functions.php');

/**
 * Customizer additions.
 */
require get_parent_theme_file_path('/inc/customizer.php');

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path('/inc/icon-functions.php');

function myContent() {
    global $wpdb, $page, $more, $preview, $pages, $multipage;
    $more_link_text = null;
    $strip_teaser = false;


    $post = get_post();

    if (null === $more_link_text) {
        $more_link_text = sprintf(
                '<span aria-label="%1$s">%2$s</span>', sprintf(
                        /* translators: %s: Name of current post */
                        __('Continue reading %s'), the_title_attribute(array('echo' => false))
                ), __('(more&hellip;)')
        );
    }

    $output = '';
    $has_teaser = false;

    // If post password required and it doesn't match the cookie.
    if (post_password_required($post))
        return get_the_password_form($post);

    if ($page > count($pages)) // if the requested page doesn't exist
        $page = count($pages); // give them the highest numbered page that DOES exist

    $content = $pages[$page - 1];
    if (preg_match('/<!--more(.*?)?-->/', $content, $matches)) {
        $content = explode($matches[0], $content, 2);
        if (!empty($matches[1]) && !empty($more_link_text))
            $more_link_text = strip_tags(wp_kses_no_null(trim($matches[1])));

        $has_teaser = true;
    } else {
        $content = array($content);
    }

    if (false !== strpos($post->post_content, '<!--noteaser-->') && (!$multipage || $page == 1 ))
        $strip_teaser = true;

    $teaser = $content[0];
    $rule = array();
    $query = array();

    if (isset($_GET['tid']) && isset($_GET['competition'])) {
        $tids = explode(",", $_GET['tid']);
        foreach ($tids as $teams) {
            // returns players of each teams       
            $query[] = $wpdb->get_results('SELECT pm. * , p.post_title, t.name
												FROM  ' . $wpdb->prefix . 'postmeta AS pm
												JOIN  ' . $wpdb->prefix . 'posts AS p ON pm.post_id = p.ID
												JOIN ' . $wpdb->prefix . 'term_relationships AS tr ON pm.post_id = tr.object_id
												JOIN ' . $wpdb->prefix . 'terms AS t ON tr.term_taxonomy_id = t.term_id
												WHERE  `meta_value` =' . $teams . '
												AND  `meta_key` =  "sp_current_team"
												AND t.name =  "' . $_GET['competition'] . '"
												ORDER BY  `meta_value` ASC');

            $terms = get_the_terms($teams, 'sp_league');     // returns the competition's object           
            foreach ($terms as $t) {
                if ($_GET['competition'] == $t->name) {
                    $rule = $t->description;
                    $taxo_img = taxonomy_image_plugin_get_associations();  // returns the image's post_id of the competition
                    //$ruleimg = $wpdb->get_results('select guid from wp_posts where ID = '.$taxo_img[$t->term_id]);                       
                    $ruleimg = wp_get_single_post($taxo_img[$t->term_id]);
                    break;
                }
            }
        }
    }


    /*
     * for podium to get winner's name and their team name
     */
    $teamDetail = array();
    $winner = array();

    if ($terms) {
        foreach ($terms as $v):
            $league_id = $v->term_id;
            foreach ($tids as $res):
                $s = new SP_Team($res);
                list( $columns, $data, $placeholders ) = $s->columns($league_id);
                foreach ($data as $div_id => $div_stats):
                    if ($div_id > 0):
                        foreach ($columns as $key => $value):
                            $point = sp_array_value(sp_array_value($data, $div_id, array()), $key, 0);
                            $ps[$v->name][$res] = intval($point);
                        endforeach;
                    endif;
                endforeach;
                $teamDetail[$s->ID] = $s->post->post_title;
            endforeach;
        endforeach;

        foreach ($ps as $key => $point) {
            if ($key == $_GET['competition']) {
                arsort($point);
                $count = 1;
                foreach ($point as $k => $p) {
                    if ($p > 0) {
                        foreach ($query as $q) {
                            if ($count <= 3) {
                                if ($k == $q[0]->meta_value) {
                                    $winner[$count]['winner'] = $q[0]->post_title;
                                }
                                $winner[$count]['team'] = $teamDetail[$k];
                            }
                        }
                    }
                    $count++;
                }
            }
        }
    }

    /*
     * Hightest records
     */
    if (isset($_GET['competition'])) {
        $record = $wpdb->get_results('SELECT MAX( pm.meta_value ) , pm. * ,p.post_title, t.name
										FROM  ' . $wpdb->prefix . 'postmeta AS pm
										JOIN  ' . $wpdb->prefix . 'posts AS p ON pm.post_id = p.ID
										JOIN ' . $wpdb->prefix . 'term_relationships AS tr ON pm.post_id = tr.object_id
										JOIN ' . $wpdb->prefix . 'terms AS t ON tr.term_taxonomy_id = t.term_id
										WHERE  `meta_key` =  "high_score"
										AND t.name =  "' . $_GET['competition'] . '"');
    }
    /*
     * for competition 
     */
    if (isset($post) && isset($_GET['competition'])) {
        $teaser = str_replace('[$$###COMP###$$]', $_GET['competition'], $teaser);

        if (isset($_GET['leaguetbl'])) {
            $teaser = str_replace('[$$###LEAGUETABLE###$$]', $_GET['leaguetbl'], $teaser);
        }
        if (isset($_GET['tid'])) {
            $teaser = str_replace('[$$###TID###$$]', $_GET['tid'], $teaser);
        }
        if (isset($rule)) {
            $teaser = str_replace('[$$###RULES###$$]', $rule, $teaser);
        }
        if (isset($ruleimg)) {
            $teaser = str_replace('[$$###RULESIMG###$$]', $ruleimg->guid, $teaser);
        }
        if (isset($winner) && isset($winner[1]['winner'])) {
            $teaser = str_replace('[$$###WINNER1###$$]', $winner[1]['winner'], $teaser);
        } else {
            $teaser = str_replace('[$$###WINNER1###$$]', '', $teaser);
        }

        if (isset($winner) && isset($winner[2]['winner'])) {
            $teaser = str_replace('[$$###WINNER2###$$]', $winner[2]['winner'], $teaser);
        } else {
            $teaser = str_replace('[$$###WINNER2###$$]', '', $teaser);
        }

        if (isset($winner) && isset($winner[3]['winner'])) {
            $teaser = str_replace('[$$###WINNER3###$$]', $winner[3]['winner'], $teaser);
        } else {
            $teaser = str_replace('[$$###WINNER3###$$]', '', $teaser);
        }

        if (isset($winner) && isset($winner[1]['team'])) {
            $teaser = str_replace('[$$###WINNER1TEAM###$$]', $winner[1]['team'], $teaser);
        } else {
            $teaser = str_replace('[$$###WINNER1TEAM###$$]', "", $teaser);
        }
        if (isset($winner) && isset($winner[2]['team'])) {
            $teaser = str_replace('[$$###WINNER2TEAM###$$]', $winner[2]['team'], $teaser);
        } else {
            $teaser = str_replace('[$$###WINNER2TEAM###$$]', "", $teaser);
        }
        if (isset($winner) && isset($winner[3]['team'])) {
            $teaser = str_replace('[$$###WINNER3TEAM###$$]', $winner[3]['team'], $teaser);
        } else {
            $teaser = str_replace('[$$###WINNER3TEAM###$$]', "", $teaser);
        }

        if ($record && $record[0]->meta_value != NULL) {
            $recordWinner = $record[0]->post_title;
            $score = $record[0]->meta_value;
            $t = $wpdb->get_results("SELECT p.post_title FROM " . $wpdb->prefix . "postmeta AS pm 
                    JOIN " . $wpdb->prefix . "posts AS p ON pm.meta_value = p.ID WHERE pm.meta_key =  'sp_team' AND pm.post_id =" . $record[0]->post_id);
            $recorddiv = '<div class="container-fluid table-content text-center pd-30" style="color:#fff;font-size:40px">
                                HIGHEST RECORD
                                <div>
                                <h2 style="color:#fff"> ' . $recordWinner . ' (' . $t[0]->post_title . ') - ' . $score . '</h2></div></div>';
            $teaser = str_replace('[$$###RECORDWINNER###$$]', $recorddiv, $teaser);
        } else {
            $teaser = str_replace('[$$###RECORDWINNER###$$]', '', $teaser);
        }
        // for rule image position
        $position = get_post_meta($post->ID, 'position'); //$wpdb->get_results('select meta_value from wp_postmeta where post_id ='.$post->ID. ' and meta_key = "position"');            
        if (isset($position) && $position[0] == 'right') {
            $teaser = str_replace('[$$##IMGPOS##$$]', 'right', $teaser);
        } else {
            $teaser = str_replace('[$$##IMGPOS##$$]', 'left', $teaser);
        }
    }


    if ($more && $strip_teaser && $has_teaser)
        $teaser = '';

    $output .= $teaser;
    if (count($content) > 1) {
        if ($more) {
            $output .= '<span id="more-' . $post->ID . '"></span>' . $content[1];
        } else {
            if (!empty($more_link_text))

            /**
             * Filters the Read More link text.
             *
             * @since 2.8.0
             *
             * @param string $more_link_element Read More link element.
             * @param string $more_link_text    Read More text.
             */
                $output .= apply_filters('the_content_more_link', ' <a href="' . get_permalink() . "#more-{$post->ID}\" class=\"more-link\">$more_link_text</a>", $more_link_text);
            $output = force_balance_tags($output);
        }
    }

    if ($preview) // Preview fix for JavaScript bug with foreign languages.
        $output = preg_replace_callback('/\%u([0-9A-F]{4})/', '_convert_urlencoded_to_entities', $output);


    remove_filter('the_content', 'myContent', 1);
    $output = str_replace(']]>', ']]&gt;', $output);
    return $output;
}

add_filter('the_content', 'myContent', 1);

/*
 * rename events name to olympic events
 */

function rename_header_to_logo($translated, $original, $domain) {
    $strings = array(
        'Events' => 'Olympic Events',
    );

    if (isset($strings[$original]) && is_admin()) {
        $translations = &get_translations_for_domain($domain);
        $translated = $translations->translate($strings[$original]);
    }
    return $translated;
}

add_filter('gettext', 'rename_header_to_logo', 10, 3);
