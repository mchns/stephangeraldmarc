<?php
function spits_preprocess_html(&$vars, $hook) {  
  $viewport = array(
    '#tag' => 'meta', 
    '#attributes' => array(
      'name' => 'viewport', 
      'content' => 'width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0'
    )
  );
  drupal_add_html_head($viewport, 'viewport');
}

function spits_preprocess_page(&$variables) {
  global $base_url;
  
  // Get the entire main menu tree
  $main_menu_tree = menu_tree_all_data('main-menu');

  // Add the rendered output to the $main_menu_expanded variable
  $variables['main_menu_expanded'] = menu_tree_output($main_menu_tree);
  
  $variables['center_content'] = TRUE;
  if(!empty($variables['node'])) {
    $variables['center_content'] = FALSE;
  }
  
  /* 
  <!-- for Google -->
  <meta name="keywords" content="" />  
  <meta name="author" content="" />
  <meta name="copyright" content="" />
  <meta name="application-name" content="" />  
  <!-- for Facebook -->  
  <meta property="og:type" content="article" />  
  
  <!-- for Twitter -->          
  
  */
  
  //<meta property="og:url" content="" />  
  $meta_url = url(current_path(), array('absolute' => TRUE));
  $element = array('#tag' => 'meta', '#attributes' => array('name' => 'og:url', 'content' => $meta_url));
  drupal_add_html_head($element, 'meta_url');
  
  $meta_title = drupal_get_title() . ' | SPITS Design';  
  // <meta name="og:title" content="" />
  $element = array('#tag' => 'meta', '#attributes' => array('name' => 'og:title', 'content' => $meta_title));
  drupal_add_html_head($element, 'og_title');  
  // <meta name="twitter:title" content="" />
  $element = array('#tag' => 'meta', '#attributes' => array('name' => 'twitter:title', 'content' => $meta_title));
  drupal_add_html_head($element, 'twitter_title');
  
  $plain = 'SPITS Design produces a line of high-end furniture that will stand the test of time in every possible way.';
  if(isset($variables['node'])) {    
    if(!empty($variables['node']->body[LANGUAGE_NONE][0]['value'])) {
      $plain = drupal_html_to_text($variables['node']->body[LANGUAGE_NONE][0]['value']);
    }
    else if(!empty($variables['node']->field_textblock[LANGUAGE_NONE][0]['value'])) {
      $fc = entity_load('field_collection_item', array($variables['node']->field_textblock[LANGUAGE_NONE][0]['value']));
      $fc = reset($fc);
      if(!empty($fc->field_text[LANGUAGE_NONE][0]['value'])) {        
        $plain = drupal_html_to_text($fc->field_text[LANGUAGE_NONE][0]['value']);
      }
    }    
  }
  $plain = trim(preg_replace('/\s+/', ' ', $plain));
  $meta_description = truncate_utf8(trim($plain), 155, true, true, 1);
  
  // <meta property="og:description" content="" />
  $element = array('#tag' => 'meta', '#attributes' => array('name' => 'description', 'content' => $meta_description));
  drupal_add_html_head($element, 'meta_description');
  
  //<meta property="og:title" content="" />
  $element = array('#tag' => 'meta', '#attributes' => array('name' => 'og:description', 'content' => $meta_description));
  drupal_add_html_head($element, 'og_description');
  
  //<meta name="twitter:description" content="" />
  $element = array('#tag' => 'meta', '#attributes' => array('name' => 'twitter:description', 'content' => $meta_description));
  drupal_add_html_head($element, 'twitter_description');  
  
  $meta_image = $base_url. '/sites/all/themes/spits/img/default-share-image.jpg';
  if(!empty($variables['node']->field_image[LANGUAGE_NONE][0]['uri'])) {
    $meta_image = file_create_url($variables['node']->field_image[LANGUAGE_NONE][0]['uri']);
  }
  
  // <meta property="og:image" content="" />
  $element = array('#tag' => 'meta', '#attributes' => array('property' => 'og:image', 'content' => $meta_image));
  drupal_add_html_head($element, 'og_image');
  
  // <meta name="twitter:image" content="" />
  $element = array('#tag' => 'meta', '#attributes' => array('property' => 'twitter:image', 'content' => $meta_image));
  drupal_add_html_head($element, 'twitter_image');
  
  // <meta name="twitter:card" content="summary" />
  $element = array('#tag' => 'meta', '#attributes' => array('name' => 'twitter:card', 'content' => 'summary'));
  drupal_add_html_head($element, 'twitter_card');
}

function spits_menu_tree($variables) {
  return '<div class="mp-level"><a class="mp-back" href="#">back</a><ul class="menu">' . $variables['tree'] . '</ul></div>';
}


/*
* remove form-text class
* remove text type if its html5
* add placeholder in html5
*/
function spits_textfield($variables) {
  $classes = array('form-control');
  $element = $variables['element'];
  $element['#size'] = '30';

  //is this element requred then lest add the required element into the input
   $required = !empty($element['#required']) ? ' required' : '';

  //dont need to set type in html5 its default so lets remove it because we can
  $element['#attributes']['type'] = 'text';

  //placeholder
  if (!empty($element['#title']) AND theme_get_setting('mothership_classes_form_placeholder_label') ) {
    $element['#attributes']['placeholder'] =  $element['#title'];
  }


  element_set_attributes($element, array('id', 'name', 'value', 'size', 'maxlength'));

  //remove the form-text class
  if(!theme_get_setting('mothership_classes_form_input')){
    $classes[] = 'form-text';
  }
  _form_set_class($element, $classes);
  $extra = '';
  if ($element['#autocomplete_path'] && drupal_valid_path($element['#autocomplete_path'])) {
    drupal_add_library('system', 'drupal.autocomplete');
    $element['#attributes']['class'][] = 'form-autocomplete';

    $attributes = array();
    $attributes['type'] = 'hidden';
    $attributes['id'] = $element['#attributes']['id'] . '-autocomplete';
    $attributes['value'] = url($element['#autocomplete_path'], array('absolute' => TRUE));
    $attributes['disabled'] = 'disabled';
    $attributes['class'][] = 'autocomplete';
    $extra = '<input' . drupal_attributes($attributes) . $required .' />';
  }

  $output = '<div class="input-wrapper"><input' . drupal_attributes($element['#attributes']) . $required . ' /></div>';

  return $output . $extra;
}

function spits_password($variables) {
  $classes = array('form-control');
  $element = $variables['element'];
  $element['#size'] = '30';
  $element['#attributes']['type'] = 'password';

  element_set_attributes($element, array('id', 'name', 'size', 'maxlength'));
//  element_set_attributes($element, array('id', 'name',  'maxlength'));
  if(!theme_get_setting('mothership_classes_form_input')){
    $classes[] = 'form-text';
  }

  _form_set_class($element, $classes);

  //html5 plceholder love ? //substr(,0, 20);
  if (!empty($element['#description']) AND theme_get_setting('mothership_classes_form_placeholder_description') ) {
    $element['#attributes']['placeholder'] = $element['#description'];
  }

  if (!empty($element['#title']) AND theme_get_setting('mothership_classes_form_placeholder_label')) {
    $element['#attributes']['placeholder'] = $element['#title'];
  }




  if($variables['element']['#id'] == "edit-pass-pass1"){
     return '<input' . drupal_attributes($element['#attributes']) . ' /><small>'. t('Enter a password').'</small>' ;
  }elseif($variables['element']['#id'] == "edit-pass-pass2"){
     return '<input' . drupal_attributes($element['#attributes']) . ' /><small>'. t('Repeat the password').'</small>' ;
  }else{
    return '<input' . drupal_attributes($element['#attributes']) . ' />' ;
  }

}


/**
 * Theme function to render an email component.
 */
function spits_webform_email($variables) {
  $element = $variables['element'];

  // This IF statement is mostly in place to allow our tests to set type="text"
  // because SimpleTest does not support type="email".
  if (!isset($element['#attributes']['type'])) {
    $element['#attributes']['type'] = 'email';
  }

  // Convert properties to attributes on the element if set.
  foreach (array('id', 'name', 'value', 'size') as $property) {
    if (isset($element['#' . $property]) && $element['#' . $property] !== '') {
      $element['#attributes'][$property] = $element['#' . $property];
    }
  }
  _form_set_class($element, array('form-text', 'form-email', 'form-control'));

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

function spits_button($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'submit';
  element_set_attributes($element, array('id', 'name', 'value'));

  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  $element['#attributes']['class'][] = 'btn';
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}
?>