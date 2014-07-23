<?php
/**
 * @file bxSlider Formatter. Contains Drupal\bxslider\Plugin\Field\FieldFormatter.
 */

namespace Drupal\bxslider\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'bxslider' formatter.
 *
 * @FieldFormatter(
 *   id = "bxslider",
 *   label = @Translation("bxSlider"),
 *   field_types = {
 *     "image"
 *   },
 *   settings = {
 *     "image_style" = "",
 *     "slide_width" = 200,
 *     "min_slides" = 2,
 *     "max_slides" = 4,
 *     "slide_margin" = 0,
 *     "pager" = 1
 *   }
 * )
 */
class BxsliderFormatter extends FormatterBase { 
  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, array &$form_state) {
    $element = array();
    $image_styles = image_style_options(FALSE);
    $element['image_style'] = array(
      '#title' => t('Image style'),
      '#type' => 'select',
      '#default_value' => $this->getSetting('image_style'),
      '#empty_option' => t('None (original image)'),
      '#options' => $image_styles,
    );
    $element['slide_width'] = array(
      '#title' => t('Slide width'),
      '#type' => 'number',
      '#default_value' => $this->getSetting('slide_width'),
      '#min' => 1,
      '#required' => TRUE,
    );
    $element['min_slides'] = array(
      '#title' => t('Min slides'),
      '#type' => 'number',
      '#default_value' => $this->getSetting('min_slides'),
      '#min' => 1,
      '#required' => TRUE,
    );
    $element['max_slides'] = array(
      '#title' => t('Max slides'),
      '#type' => 'number',
      '#default_value' => $this->getSetting('max_slides'),
      '#min' => 1,
      '#required' => TRUE,
    );
    $element['slide_margin'] = array(
      '#title' => t('Slide margin'),
      '#type' => 'number',
      '#default_value' => $this->getSetting('slide_margin'),
      '#min' => 0,
      '#required' => TRUE,
    );
    $element['pager'] = array(
      '#title' => t('Slide margin'),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('pager'),
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $ukey = substr(sha1(time() . 'bxslider'), 0, 5);
    $elements = array();
    foreach ($items as $delta => $item) {
      if ($item->entity) {
        $image_uri = $item->entity->getFileUri();
        $uri = array(
          'path' => file_create_url($image_uri),
          'options' => array(),
        );
        $elements[$delta] = array(
          '#theme' => 'image_formatter',
          '#item' => $item->getValue(TRUE),
          '#image_style' => $this->getSetting('image_style'),
          //'#path' => isset($uri) ? $uri : '',
        );
      }
    }

    $settings = array (
      'slideWidth' => $this->getSetting('slide_width'),
      'minSlides' => $this->getSetting('min_slides'),
      'maxSlides' => $this->getSetting('max_slides'),
      'slideMargin' => $this->getSetting('slide_margin'),
      'pager' => $this->getSetting('pager'),
    );
    $source = _bxslider_get_render_source($elements, $settings, $ukey);

    return array($source);
  }
}
