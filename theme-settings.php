<?php  

function pluralsite_form_system_theme_settings_alter(&$form, $form_state) {
	$form['breadcrumb_delimiter'] = array(
		'#type' => 'textfield', 
		'#title' => t('Breadcrumb Delimiter'), 
		'#size' => 4, 
		'#default_value' => theme_get_setting('breadcrumb_delimiter'),

	);

	$form['use_twitter'] = array(
		'#type' => 'checkbox',
		'#title' => t('Use twitter for site slogan'),
		'#default_value' => theme_get_setting('use_twitter'),
	);

	$form['twitter_search_term'] = array(
		'#type' => 'textfield', 
		'#title' => t('Twitter Search Term'), 
		'#default_value' => theme_get_setting('twitter_search_term'),
	);	
}