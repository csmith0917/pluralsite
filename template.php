<?php

/*
* @file 
* template.php file for pluralsite theme.
*
* Implement preprocess functions and alter hooks in this file
*/

/*
* preprocess function for page.tpl.php
*/

// prints all the hooks on the page, and shows the order they are printed in
// function pluralsite_preprocess(&$variables, $hook){
// 	// static $i;
// 	// kpr($i .' '. $hook);
// 	// $i++;

// 	if ($hook == 'page'){
// 		static $i;
// 		kpr($i .' '. $hook);
// 		$i++;
// 	}
// }

function pluralsite_preprocess_page(&$variables, $hook){

	$slogans = array(
		t('This is a new slogan 1'),
		t('This is a new slogan 2'),
		t('This is a new slogan 3'),
		t('This is a new slogan 4'),
		t('This is a new slogan 5'),
		t('This is a new slogan 6'),
		t('This is a new slogan 7'),
		t('This is a new slogan 8'),

	);

	$slogan = $slogans[array_rand($slogans)];
	$variables['site_slogan'] = $slogan;

	// $use_twitter = theme_get_setting('use_twitter');

	// if ($use_twitter) {
	// 	if ($cache = cache_get('pluralsite_tweets')) {
	// 		$data = $cache -> $data;
	// 	} else {
	// 		$query = theme_get_setting('twitter_search_term');
	// 		$query = drupal_encode_path($query);

	// 		$response = drupal_http_request('https://twitter.com/search?q=' . $query);
	// 		aerosmith&src=typd
	// 		if ($response -> code == 200) {
	// 			$data = json_decode($response->data);
	// 			cache_set('pluralsite_tweets', $data, 'cache', 300);
	// 		}
	// 	}
	// 	$tweet = $data->results[array_rand($data->results)];
	// 	$variables['site_slogan'] = check_plain(html_entity_decode($tweet -> text));
	// }
	
	// Add new variables to page.tpl for footer
	if ($variables['logged_in']) {
		$variables['footer_message']  = t('Welcome @username, Lullabot love\'s you.', array('@username' => $variables['user']->name));
	} else {
		$variables['footer_message']  = t('Lullabot loves you');
	}
	
	// add css to front page
	if ($variables['is_front'] === TRUE) {
		drupal_add_css(path_to_theme().'/css/front.css',  array('group'=>CSS_THEME, 'weight'=>10));
	}
	
}

function pluralsite_preprocess_node(&$variables){
	if ($variables['type'] == 'article') {
		$node = $variables['node'];
		//kpr($node);

		$variables['submitted_day'] = format_date($node->created, 'custom', 'j');		
		$variables['submitted_month'] = format_date($node->created, 'custom', 'M');	
		$variables['submitted_year'] = format_date($node->created, 'custom', 'Y');

	}

	if ($variables['type']=='page') {
		
		$today = strtolower(date('l'));
		$variables['theme_hook_suggestions'][] = 'node__'.$today;
		//kpr($variables);
	}
}


function pluralsite_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

    $delimiter = theme_get_setting('breadcrumb_delimiter');
    $title = drupal_get_title();
    $output .= '<div class="breadcrumb">' . implode($delimiter, $breadcrumb) . $delimiter . $title .'</div>';
    return $output;
  }
}

// function pluralsite_field__field_tags($variables) {
//   $output = '';

//   // Render the items.
//   $output .= '<div class="article-tags"' . $variables['content_attributes'] . '><ul>';
//   foreach ($variables['items'] as $delta => $item) {
//     $output .= '<li>' . drupal_render($item) . '</li>';
//   }
//   $output .= '</ul></div>';

//   // Render the top-level DIV.
//   //$output = '<div class="' . $variables['classes'] . '"' . $variables['attributes'] . '>' . $output . '</div>';

//   return $output;
// }

function pluralsite_field__field_tags($variables) {
  $output = '';
  $links = array();
  foreach ($variables['items'] as $delta => $item) {
  	$item['#options']['attributes'] += $variables['item_attributes_array'][$delta];
  	$links[] = drupal_render($item);
  }
  $output .= implode(', ', $links);

  return $output;
}


//change theme_username()
function pluralsite_preprocess_username(&$variables){
	$account = user_load($variables['account']->uid);
	
	if (isset($account->field_real_name[LANGUAGE_NONE][0]['safe_value'])) {
		$variables['name'] = $account->field_real_name[LANGUAGE_NONE][0]['safe_value'];
	}
}


function pluralsite_css_alter(&$css){
	unset($css['modules/system/system.menus.css']);
}


function pluralsite_page_alter(&$page) {
	//kpr($page);
	if (arg(0) == 'node' && is_numeric(arg(1))) {
		$nid = arg(1);
		if (isset($page['content']['system_main']['nodes'][$nid]['field_image'])) {
			$image = $page['content']['system_main']['nodes'][$nid]['field_image'];
			array_unshift($page['sidebar_first'], array('image' => $image ));
			unset($page['content']['system_main']['nodes'][$nid]['field_image']);
		}
	}


}


function pluralsite_form_alter(&$form, &$form_state, $form_id){
	dsm($form_id);
}


