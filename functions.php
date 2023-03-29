<?php

function bootstrapstarter_enqueue_styles() {
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
    $dependencies = array('bootstrap');
    wp_enqueue_style('bootstrapstarter-style', get_stylesheet_uri(), $dependencies);
}

function jquery_enqueued_script() {
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-3.3.1.min.js', array(), '3.3.1');
}

function bootstrapstarter_enqueue_scripts() {
    $dependencies = array('jquery');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', $dependencies, '4.1.1', true);
}

function waterwheel_enqueue_scripts() {
    $dependencies = array('jquery');
    wp_enqueue_script('waterwheel', get_template_directory_uri() . '/js/jquery.waterwheelCarousel.min.js', $dependencies, '2.3.0', true);
}

function string_capitular($word = null) {
    if ($word != null) {
        return substr_replace($word, "<span class='capitular'>{$word[0]}</span>", 0, 1);
    }
    return;
}

function get_breadcrumb() {
    global $post, $wp_query;

    function print_breadcrumb_item($item, $link = null, $active = false) {
        if ($active) {
            echo "<li li class='breadcrumb-item active' aria-current='page'>$item</li>";
        } else {
            echo "<li class='breadcrumb-item'><a href='$link' target='_self' title='$item'>$item</a></li>";
        }
    }

    $home_title = 'Início';

    echo '<nav class="my-1" aria-label="breadcrumb"><ol class="breadcrumb">';
    if (!is_home()) {
        print_breadcrumb_item($home_title, get_home_url(), false);
        if (is_archive() && !is_tax() && !is_category() && !is_tag()) {
            print_breadcrumb_item(post_type_archive_title($prefix, false), null, true);
        } elseif (is_archive() && is_tax() && !is_category() && !is_tag()) {
            $post_type = get_post_type();
            if ($post_type != 'post') {
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
                print_breadcrumb_item($post_type_object->labels->name, $post_type_archive);
            }
            $custom_tax_name = get_queried_object()->name;
            print_breadcrumb_item($custom_tax_name, null, true);
        } elseif (is_single()) {
            $post_type = get_post_type();
            if ($post_type != 'post') {
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
                print_breadcrumb_item($post_type_object->labels->name, $post_type_archive);
            }

            $category = get_the_category();
            if (!empty($category)) {
                $last_category = end(array_values($category));
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
                $cat_parents = explode(',', $get_cat_parents);
                $cat_display = '';
                foreach ($cat_parents as $parents) {
                    print_breadcrumb_item($parents, null, true);
                }
            }
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if (empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                $taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
                $cat_id = $taxonomy_terms[0]->term_id;
                $cat_nicename = $taxonomy_terms[0]->slug;
                $cat_link = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name = $taxonomy_terms[0]->name;
            }
            if (!empty($last_category)) {
                echo $cat_display;
                print_breadcrumb_item(get_the_title(), null, true);
            } elseif (!empty($cat_id)) {
                print_breadcrumb_item($cat_name, $cat_link);
                print_breadcrumb_item(get_the_title(), null, true);
            } else {
                print_breadcrumb_item(get_the_title(), null, true);
            }
        } elseif (is_category()) {
            print_breadcrumb_item(single_cat_title('', false), null, true);
        } elseif (is_page()) {
            if ($post->post_parent) {
                $anc = get_post_ancestors($post->ID);
                $anc = array_reverse($anc);

                if (!isset($parents))
                    $parents = null;
                foreach ($anc as $ancestor) {
                    $parents .= "<li class='breadcrumb-item'><a href='" . get_permalink($ancestor) . "' target='_self' title='" . get_the_title($ancestor) . "'>" . get_the_title($ancestor) . "</a></li>";
                }
                echo $parents;
                print_breadcrumb_item(get_the_title(), null, true);
            } else {
                print_breadcrumb_item(get_the_title(), null, true);
            }
        } elseif (is_tag()) {
            $term_id = get_query_var('tag_id');
            $taxonomy = 'post_tag';
            $args = 'include=' . $term_id;
            $terms = get_terms($taxonomy, $args);
            $get_term_id = $terms[0]->term_id;
            $get_term_slug = $terms[0]->slug;
            $get_term_name = $terms[0]->name;
            print_breadcrumb_item($get_term_name, null, true);
        } elseif (is_day()) {
            print_breadcrumb_item(get_the_time('Y'), get_year_link(get_the_time('Y')));
            print_breadcrumb_item(get_the_time('m'), get_year_link(get_the_time('m')));
            print_breadcrumb_item(get_the_time('j'), null, true);
        } elseif (is_month()) {
            print_breadcrumb_item(get_the_time('Y'), get_year_link(get_the_time('Y')));
            print_breadcrumb_item(get_the_time('m'), null, true);
        } elseif (is_year()) {
            print_breadcrumb_item(get_the_time('Y'), null, true);
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            print_breadcrumb_item($userdata->display_name, null, true);
        } elseif (get_query_var('paged')) {
            print_breadcrumb_item(__('Página') . ' ' . get_query_var('paged'), null, true);
        } elseif (is_search()) {
            print_breadcrumb_item(get_search_query(), null, true);
        } elseif (is_404()) {
            print_breadcrumb_item('Erro 404', null, true);
        }
    } else {
        print_breadcrumb_item($home_title, null, true);
    }
    echo '</ol></nav>';
}

function register_my_menu() {
    register_nav_menu('menu-principal', __('Menu principal'));
}

function page_navi($before = '', $after = '') {
    global $wpdb, $wp_query;
    $request = $wp_query->request;
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $paged = intval(get_query_var('paged'));
    $numposts = $wp_query->found_posts;
    $max_page = $wp_query->max_num_pages;
    if ($numposts <= $posts_per_page) {
        return;
    }
    if (empty($paged) || $paged == 0) {
        $paged = 1;
    }
    $pages_to_show = 5;
    $pages_to_show_minus_1 = $pages_to_show - 1;
    $half_page_start = floor($pages_to_show_minus_1 / 2);
    $half_page_end = ceil($pages_to_show_minus_1 / 2);
    $start_page = $paged - $half_page_start;
    if ($start_page <= 0) {
        $start_page = 1;
    }
    $end_page = $paged + $half_page_end;
    if (($end_page - $start_page) != $pages_to_show_minus_1) {
        $end_page = $start_page + $pages_to_show_minus_1;
    }
    if ($end_page > $max_page) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = $max_page;
    }
    if ($start_page <= 0) {
        $start_page = 1;
    }

    echo $before . '<ul class="pagination">' . "";
    if ($paged > 1) {
        $first_page_text = "<<";
        echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link() . '" title="Primeiro">' . $first_page_text . '</a></li>';
    }

    $prevposts = get_previous_posts_link('<');
    if ($prevposts) {
        echo '<li class="page-item">' . $prevposts . '</li>';
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $paged) {
            echo '<li class="page-item active disabled"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
            echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
        }
    }
    $nextposts = next_posts_link('>');
    if ($nextposts) {
        echo '<li class="page-item">' . $nextposts . '</li>';
    }

    if ($end_page < $max_page) {
        $last_page_text = ">>";
        echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($max_page) . '" title="Úlitmo">' . $last_page_text . '</a></li>';
    }
    echo '</ul>' . $after . "";
}

function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function wpb_track_post_views($post_id) {
    if (!is_single())
        return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    wpb_set_post_views($post_id);
}

function posts_link_attributes() {
    return 'class="page-link"';
}

add_action('rest_api_init', 'mobile_api_get_all_posts');

function mobile_api_get_all_posts() {
    register_rest_route('mobile/v1', '/posts', array(
        'methods' => 'GET',
        'callback' => 'mobile_all_posts_callback'
    ));
}

function mobile_all_posts_callback($request) {
    $posts_data = array();
    $paged = $request->get_param('page');
    $paged = ( isset($paged) || !( empty($paged) ) ) ? $paged : 1;
    $posts = get_posts(array(
        'paged' => $paged,
        'posts_per_page' => 5,
        'post_type' => 'post',
            )
    );


// Loop through the posts and push the desired data to the array we've initialized earlier in the form of an object
    foreach ($posts as $post) {

        $id = $post->ID;
        $post_thumbnail = ( has_post_thumbnail($id) ) ? get_the_post_thumbnail_url($id) : "https://gazetadaprovincia.jor.br/wp-content/themes/gazetadaprovincia/img/sem-imagem.jpg";

        $posts_data[] = (object) array(
                    'id' => $id,
                    'titulo' => $post->post_title,
                    'lead' => $post->post_excerpt,
                    'link' => $post->guid,
                    'imagem_url' => $post_thumbnail,
                    'autor' => get_the_author_meta('display_name',$post->post_author),
                    'categorias' => get_the_category($id),
        );
    }
    return $posts_data;
}

add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');
add_action('wp_head', 'wpb_track_post_views');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
add_action('init', 'register_my_menu');
add_filter('string_capitular', 'string_capitular');
add_action('wp_enqueue_scripts', 'jquery_enqueued_script');
add_action('wp_enqueue_scripts', 'bootstrapstarter_enqueue_styles');
add_action('wp_enqueue_scripts', 'bootstrapstarter_enqueue_scripts');
add_action('wp_enqueue_scripts', 'waterwheel_enqueue_scripts');

add_theme_support('post-thumbnails');

require get_template_directory() . '/bootstrap-navwalker.php';
