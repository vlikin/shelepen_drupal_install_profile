<?php

/**
 * @file
 * Contains \Drupal\test\ImportData.
 */

namespace Drupal\test;


/**
 * Controller routines for book routes.
 */
class ImportData {
  private $core_path = NULL;
  private $data_path = NULL;
  private $site_path = NULL;
  private $public_path = NULL;
  private $image_path = NULL;

  function __construct() {
    $this->core_path = '/var/www/d8/drupal';
    $this->data_path = $this->core_path . '/profiles/shelepen/data';
    $this->site_path = $this->core_path . '/sites/default';
    $this->public_path = $this->site_path . '/files';
    $this->image_path = $this->public_path . '/field/image';
  } 

  private function ImportFiles() {
    $output = '';
    system('rm -rf ' . $this->image_path);
    if (!file_exists($this->image_path)) {
      $r = mkdir($this->image_path,  0777, true);
      $output .= $this->image_path . ' - '. $r . ' created. <br>';
    }
    $string = file_get_contents($this->data_path . '/file_list.json');
    $file_list = json_decode($string, TRUE);
    foreach ($file_list as $file) {
      $from = $this->data_path . '/files/' . $file['fid'] . '.' . $file['ext'];
      // Create a new file entity.
      $file = entity_create('file', array(
        'uid' => 1,
        'filename' => $file['fid'] . '.' . $file['ext'],
        'uri' => 'public://field/image/' . $file['fid'] . '.' . $file['ext'],
        'filemime' => 'image/' . $file['ext'],
        'created' => 1,
        'changed' => 1,
        'status' => FILE_STATUS_PERMANENT,
      ));
      copy($from, $file->getFileUri());
      $output .= $from . ' - ' . $file->getFileUri() . '<br>';

      // Save it, inserting a new record.
      $file->save();
    }
    
    return $output;
  }
}