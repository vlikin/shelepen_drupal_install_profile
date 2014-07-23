<?php

/**
 * @file
 * Contains \Drupal\book\Controller\BookController.
 */

namespace Drupal\test\Controller;

use Drupal\book\BookExport;
use Drupal\book\BookManagerInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller routines for book routes.
 */
class TestController {

  /**
   * Prints a listing of all books.
   *
   * @return array
   *   A render array representing the listing of all books content.
   */
  public function testRender() {
    $output = '';
      
    $core_path = '/var/www/d8/drupal';
    $data_path = $core_path . '/profiles/shelepen/data';
    $site_path = $core_path . '/sites/default';
    $public_path = $site_path . '/files';
    $image_path = $public_path . '/field/image';

    if (!file_exists($image_path)) {
      mkdir($image_path);
    }
    $string = file_get_contents($data_path . '/file_list.json');
    $file_list = json_decode($string, TRUE);
    foreach ($file_list as $file) {
      $from = $data_path . '/files/' . $file['fid'] . '.' . $file['ext'];
      $to = $image_path . '/' . $file['fid'] . '.' . $file['ext'];
      $output .= $from . ' - ' . $to . '<br>';   
    }
    return $output;
  }

}
