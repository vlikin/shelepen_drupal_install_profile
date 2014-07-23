<?php
/**
 * @file Contains helpers.
 */

/**
 * Prepares a renderable array ro theme bxslider.
 */
function _bxslider_get_render_source($items, $settings, $ukey='ukey') {
  $source = array (
    '#theme' => 'bxslider_wrapper',
    'items' => $items,
    '#ukey' => $ukey,
    '#attached' => array (
      'library' => array (
        array('bxslider', 'bxslider'),
      ),
      'js' => array (
        array (
          'data' => drupal_get_path('module', 'bxslider') . '/js/script.js',
          'type' => 'file',
        ),
        array (
          'data' => array (
            'bxslider' => array (
              'formatter' => array (
                $ukey => $settings,
              ),
            ),
          ),
          'type' => 'setting',
        ),
      ),
    ),
  );
  
  return $source;
}