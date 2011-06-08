<?php

/*
  Plugin Name: Show Theme File
  Description: Displays the theme file used to render the current page.
  Author: Dan LaManna
  Author URI: http://danlamanna.com
  Version: 0.0.1
 */

function getThemeFile() {
    global $wp_query;
    global $post;

    $themeDir = TEMPLATEPATH;
    $themeFile = '';

    if (is_home()) {
        if (file_exists($themeDir . '/' . 'home.php')) {
            $themeFile = 'home.php';
        }

        return $themeFile;
    }

    if (is_front_page()) {
        if (file_exists($themeDir . '/' . 'front-page.php')) {
            $themeFile = 'front-page.php';
        }

        return $themeFile;
    }

    if (is_404()) {
        if (file_exists($themeDir . '/' . '404.php')) {
            $themeFile = '404.php';
        }

        return $themeFile;
    }

    if (is_search()) {
        if (file_exists($themeDir . '/' . 'search.php')) {
            $themeFile = 'search.php';
        }

        return $themeFile;
    }


    if (is_date()) {
        if (file_exists($themeDir . '/' . 'date.php')) {
            $themeFile = 'date.php';
        } elseif (file_exists($themeDir . '/' . 'archive.php')) {
            $themeFile = 'archive.php';
        }

        return $themeFile;
    }

    if (is_author()) {
        $authorNiceName = $wp_query->queried_object->user_nicename;
        $authorID = $wp_query->queried_object->ID;

        if (file_exists($themeDir . '/' . 'author-' . $authorNiceName . '.php')) {
            $themeFile = 'author-' . $authorNiceName . '.php';
        } elseif (file_exists($themeDir . '/' . 'author-' . $authorID . '.php')) {
            $themeFile = 'author-' . $authorID . '.php';
        } elseif (file_exists($themeDir . '/' . 'author.php')) {
            $themeFile = 'author.php';
        } elseif (file_exists($themeDir . '/' . 'archive.php')) {
            $themeFile = 'archive.php';
        }

        return $themeFile;
    }

    if (is_category()) {
        $theCategory = get_category(get_query_var('cat'));

        $theSlug = $theCategory->slug;
        $theID = $theCategory->cat_ID;

        if (file_exists($themeDir . '/' . 'category-' . $theSlug . '.php')) {
            $themeFile = 'category-' . $theSlug . '.php';
        } elseif (file_exists($themeDir . '/' . 'category-' . $theID . '.php')) {
            $themeFile = 'category-' . $theID . '.php';
        } elseif (file_exists($themeDir . '/' . 'category.php')) {
            $themeFile = 'category.php';
        } elseif (file_exists($themeDir . '/' . 'archive.php')) {
            $themeFile = 'archive.php';
        }

        return $themeFile;
    }


    if (is_tag()) {
        $tagInfo = get_query_var('tag_id');
        $theTag = get_tag($tagInfo);

        $theSlug = $theTag->slug;
        $theID = $theTag->tag_id;

        if (file_exists($themeDir . '/' . 'tag-' . $theSlug . '.php')) {
            $themeFile = 'tag-' . $theSlug . '.php';
        } elseif (file_exists($themeDir . '/' . 'tag-' . $theID . '.php')) {
            $themeFile = 'tag-' . $theID . '.php';
        } elseif (file_exists($themeDir . '/' . 'tag.php')) {
            $themeFile = 'tag.php';
        } elseif (file_exists($themeDir . '/' . 'tag.php')) {
            $themeFile = 'archive.php';
        }

        return $themeFile;
    }

    if (is_archive()) {
        $thePostID = $wp_query->post->ID;
        $thePostType = get_post_type($thePostID);

        if (file_exists($themeDir . '/' . 'archive-' . $thePostType . '.php')) {
            $themeFile = 'archive-' . $thePostType . '.php';
        } elseif (file_exists($themeDir . '/' . 'archive.php')) {
            $themeFile = 'archive.php';
        }

        return $themeFile;
    }

    if (is_single()) {
        $thePostID = $wp_query->post->ID;
        $thePostType = get_post_type($thePostID);

        if (file_exists($themeDir . '/' . 'single-' . $thePostType . '.php')) {
            $themeFile = 'single-' . $thePostType . '.php';
        } elseif (file_exists($themeDir . '/' . 'single.php')) {
            $themeFile = 'single.php';
        }
    }

    if (is_attachment()) {
        $thePostID = $wp_query->post->ID;

        $mimeType = get_post_mime_type($thePostID);

        if (file_exists($themeDir . '/' . $mimeType . '.php')) {
            $themeFile = $mimeType . '.php';
        } elseif (file_exists($themeDir . '/' . 'attachment.php')) {
            $themeFile = 'attachment.php';
        } elseif (file_exists($themeDir . '/' . 'single.php')) {
            $themeFile = 'single.php';
        }

        return $themeFile;
    }

    if (is_page()) {
        $thePost = get_post($post->ID, 'OBJECT');
        $thePostID = $thePost->ID;
        $thePostSlug = $thePost->post_name;

        $specificThemeFile = get_post_meta($thePostID, '_wp_page_template', true);

        if (($specificThemeFile != 'default') && (file_exists($themeDir . '/' . $specificThemeFile))) {
            $themeFile = $specificThemeFile;
        } elseif (file_exists($themeDir . '/' . 'page-' . $thePostSlug . '.php')) {
            $themeFile = 'page-' . $thePostSlug . '.php';
        } elseif (file_exists($themeDir . '/' . 'page-' . $thePostID . '.php')) {
            $themeFile = 'page-' . $thePostID . '.php';
        } elseif (file_exists($themeDir . '/' . 'page.php')) {
            $themeFile = 'page.php';
        }

        return $themeFile;
    }

    return false;
}

function outputThemeFilename() {
    echo '<div id="showtheme" style="position: absolute; z-index: 9999; padding: 1em; background: white; color: black; opacity: 0.8; border: dotted 2px #999;">';
    echo (getThemeFile()) ? getThemeFile() : 'Unknown theme file';
    echo '</div>';
    return;
}

add_action('wp_head', 'outputThemeFilename');