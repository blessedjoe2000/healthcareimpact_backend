<?php

/**
 * A Contents class containing functions that can be used for generating content particles response
 **/

class HCMS_Contents
{

    public static function format_article_data($article) {
        $acf_image = get_field("article_image", $article->ID);
        $featured_image = get_the_post_thumbnail_url($article->ID, 'full');
        $image_url = $acf_image ?: $featured_image ?: null;

        $acf_image = get_field("authors_image", $article->ID);
        $authors_image = get_the_post_thumbnail_url($article->ID, 'full');
        $authors_image_url = $acf_image ?: $authors_image ?: null;
        
        // Fetch Spotify list
        $spotify_list = array();
        if (have_rows('spotify_list', $article->ID)) {
            while (have_rows('spotify_list', $article->ID)) {
                the_row();
                $spotify_list['song1'] = get_sub_field('song1');
                $spotify_list['song2'] = get_sub_field('song2');
                $spotify_list['song3'] = get_sub_field('song3');
            }
        }
        
        // Fetch YouTube list
        $youtube_list = array();
        if (have_rows('youtube_list', $article->ID)) {
            while (have_rows('youtube_list', $article->ID)) {
                the_row();
                $youtube_list['video1'] = get_sub_field('video1');
                $youtube_list['video2'] = get_sub_field('video2');
                $youtube_list['video3'] = get_sub_field('video3');
            }
        }
        
        return array(
            
            'date' => get_the_date('c', $article),
            'id' => $article->ID,
            'title' => $article->post_title,
            'headline' => get_field('headline', $article->ID),
            'highlights' => get_field('highlights', $article->ID),
            'imageUrl' => $image_url,
            'mainContent' => $article->post_content,
            'author' => $article->author,
            'authors_image' => $authors_image_url,
            'clicks' => get_field('clicks', $article->ID),

        );
    }
   

    // Function to format post data
    public static function format_post_data($post) {
        $featured_image = get_the_post_thumbnail_url($post->ID, 'full');
        $authors_image = get_the_post_thumbnail_url($post->ID, 'full');

        return array(
            'id' => $post->ID,
            'title' => $post->post_title,
            'headline' => get_field('headline', $post->ID),
            'highlights' => get_field('highlights', $post->ID),
            'mainContent' => $post->post_content,
            'excerpt' => get_the_excerpt($post),
            'date' => get_the_date('c', $post),
            'modified' => get_the_modified_date('c', $post),
            'slug' => $post->post_name,
            'image' => $featured_image ?: null,
            'categories' => wp_get_post_categories($post->ID, array('fields' => 'names')),
            'tags' => wp_get_post_tags($post->ID, array('fields' => 'names')),
            'author' => get_field('author', $post->ID),
            'authors_image' => $authors_image ?: null,
            'clicks' => get_field('clicks', $post->ID),
            
            
        );
    }
}
