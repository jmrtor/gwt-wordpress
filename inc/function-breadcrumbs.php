<?php
/**
 * GWT Breadcrumbs
 */
function gwt_wp_breadcrumb() {
	global $post;
	$option = get_option('govph_options');

	if($option['govph_breadcrumbs_enable'] != 'true'){
		return false;
	}
	$separator = $option['govph_breadcrumbs_separator'] ? $option['govph_breadcrumbs_separator'] : ' � ';
	$separator_block = '<span class="separator">'.$separator.'</span>';

	
	if (!is_home()) {
		echo '<ul class="breadcrumbs">';
		if($option['govph_breadcrumbs_show_home'] == 'true'){
			echo '<li>You are here:</li>';
			echo '<li><a class="pathway" href="';
			echo get_option('home');
			echo '">';
			echo 'Home';
			echo '</a></li>';
			//echo '</a>'.$separator_block.'</li>';
		} else {
			echo '<li>You are here:</li>';
		}
		
	} else {
		if($option['govph_breadcrumbs_show_home'] == 'true'){
			echo '<ul class="breadcrumbs">';
			echo '<li>You are here:</li>';
			echo '<li><a class="pathway" href="';
			echo get_option('home');
			echo '">';
			echo 'Home';
			echo '</a></li>';
		}
	}

	if (is_category() || is_single()) {
		echo '<li>';
		if(is_category()){
			single_cat_title();
		}

		if (is_single()) {
			the_category('</li><li> ');
			echo $separator_block.'<li>';
			the_title();
			echo '</li>';
		}
		echo '</li>';
	} elseif (is_page()) {
		if($post->post_parent){
			$anc = get_post_ancestors( $post->ID );
			$title = get_the_title();
			foreach ( $anc as $ancestor ) {
				$output = '<li><a class="pathway" href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li>';
			}
			echo $output;
			echo '<li><span class="current">'.get_the_title().'</span></li>';
			//echo '<strong title="'.$title.'"> '.$title.'</strong>';
		} else {
			echo '<li><span class="current"> '.get_the_title().'</span></li>';
		}
	}
  
	if (is_archive()) {
		if (is_day()) {echo "<li>"; the_time('F jS, Y'); echo '</li>';}
		elseif (is_month()) {echo "<li>"; the_time('F Y'); echo '</li>';}
		elseif (is_year()) {echo "<li>"; the_time('Y'); echo '</li>';}
		elseif (is_author()) {echo "<li>Author Archive"; echo '</li>';}
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo '</li>';}
		elseif (is_search()) {echo "<li>Search Results"; echo '</li>';}
	}
	echo '</ul>';
  
	return true;
}