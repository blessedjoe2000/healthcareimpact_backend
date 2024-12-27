<?php
ini_set('error_reporting', E_STRICT);
ini_set('memory_limit', -1);

// Import the HCMS_Contents class
require_once __DIR__ . '/../helpers/contents.php';

function register_routes() {

    // Route for fetching all posts
    register_rest_route('healthcare/v1', '/posts', array(
        'methods' => 'GET',
        'callback' => 'get_all_posts',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('healthcare/v1', '/articles', array(
        'methods' => 'GET',
        'callback' => 'get_all_articles',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('healthcare/v1', '/articles/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_single_article',
        'permission_callback' => '__return_true'
    ));
    

    register_rest_route('healthcare/v1', '/articles', array(
        'methods' => 'POST',
        'callback' => 'create_article',
        'permission_callback' => 'is_user_logged_in'
    ));

    register_rest_route('healthcare/v1', '/articles/(?P<id>\d+)', array(
        'methods' => 'PUT',
        'callback' => 'update_article',
        'permission_callback' => '__return_true'
    ));

   

    error_log('Routes registered successfully');
}
add_action('rest_api_init', 'register_routes');


// Function to fetch all posts
function get_all_posts($request) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $request->get_param('per_page') ?: -1,
        'paged' => $request->get_param('page') ?: 1,
        'orderby' => $request->get_param('orderby') ?: 'date',
        'order' => $request->get_param('order') ?: 'DESC',
    );

    if ($request->get_param('search')) {
        $args['s'] = sanitize_text_field($request->get_param('search'));
    }

    if ($request->get_param('category')) {
        $args['category_name'] = sanitize_text_field($request->get_param('category'));
    }

    $posts = get_posts($args);
    $data = array_map([HCMS_Contents::class, 'format_post_data'], $posts);
    return new WP_REST_Response($data, 200);
}


// FUNCTION TO FETCH ALL ARTICLES
function get_all_articles($request) {
    $args = array(
        'post_type' => 'articles',
        'posts_per_page' => $request->get_param('per_page') ?: -1,
        'paged' => $request->get_param('page') ?: 1,
    );
    if ($request->get_param('name')) {
        $args['s'] = sanitize_text_field($request->get_param('name'));
    }
    if ($request->get_param('category')) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => sanitize_text_field($request->get_param('category')),
            ),
        );
    }
    $articles = get_posts($args);
    $data = array_map([HCMS_Contents::class, 'format_article_data'], $articles);
    return new WP_REST_Response($data, 200);
}
/* GET SINGLE ARTICLE START */
/* GET SINGLE ARTICLE BY ID */
function get_single_article($request) {
    $article_id = (int) $request['id'];
    error_log("Fetching article with ID: " . $article_id);
    $article = get_post($article_id);
    error_log("Article post: " . print_r($article, true));
    if (empty($article) || $article->post_type !== 'articles') {
        error_log("Article not found or incorrect post type");
        return new WP_Error('no_article', 'Article not found', array('status' => 404));
    }
    $formatted_data = HCMS_Contents::format_article_data($article);
    error_log("Formatted article data: " . print_r($formatted_data, true));
    return new WP_REST_Response($formatted_data, 200);
}
/* GET SINGLE ARTICLE END */


function create_article($request) {
    // (existing code...)
    $article = get_post($article_id);
    return new WP_REST_Response(HCMS_Contents::format_article_data($article), 201);
}


function update_article($request) {
    $article_id = (int) $request['id'];
    $article = get_post($article_id);

    if (!$article || $article->post_type !== 'articles') {
        return new WP_Error('no_article', 'Article not found', array('status' => 404));
    }

    // Get the current clicks count, default to 0 if not set
    $current_clicks = (int) get_post_meta($article_id, 'clicks', true);

    // Increment the click count
    $new_clicks = $current_clicks + 1;

    // Update or add the meta field
    $update_result = update_post_meta($article_id, 'clicks', $new_clicks);

    if (!$update_result) {
        return new WP_Error('update_failed', 'Failed to update clicks', array('status' => 500));
    }

    // Log for debugging
    error_log("Updated clicks for article ID $article_id: $new_clicks");

    // Return the updated data
    $updated_article = get_post($article_id);
    $formatted_data = HCMS_Contents::format_article_data($updated_article);

    return new WP_REST_Response($formatted_data, 200);
}