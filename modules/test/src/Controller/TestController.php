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
    $data_import = new ImportData();
    $output = $data_import->ImportFiles();
    return $output;
  }

}
