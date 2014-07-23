<?php
/**
 * @file
 * Contains Drupal\spage\Plugin\Field\FieldFormatter;.
 */
 
namespace Drupal\spage\Plugin\Field\FieldFormatter;
 
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'spage' formatter.
 *
 * @FieldFormatter(
 *   id = "spage",
 *   label = @Translation("SPage"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class SpageFormatter extends FormatterBase { 
  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, array &$form_state) {
    $element = array();

    $element['trim_length'] = array(
      '#title' => t('Trim length'),
      '#type' => 'number',
      '#default_value' => $this->getSetting('trim_length'),
      '#min' => 1,
      '#required' => TRUE,
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();
    foreach ($items as $delta => $item) {
      $values = $item->getValue();
      $node = node_load($values['target_id']);
      $type_array = $node->field_type->getValue();
      $type = $type_array[0]['value'];
      $image_items = $node->field_image->getValue(TRUE);
      $body = field_view_field($node, 'body');
      $title = field_view_field($node, 'title');
      $body['#label_display'] = 'hidden';
      if (in_array($type, array('image_left', 'image_right'))) {
        $data = array (
          '#theme' => 'spage_article_image_side',
          '#label' => $title,
          'image' => array (
            '#theme' => 'image_formatter',
            '#item' => $image_items[0],
            '#image_style' => 'screen_2',
          ),
          'body' => $body,
        );
      }
      elseif ($type == 'image') {
        $data = array(
          '#theme' => 'image_formatter',
          '#item' => $image_items[0],
          '#image_style' => 'screen_1',
        );
      }
      elseif ($type == 'gallery') {
        $settings = array(
          'slideWidth' => 240,
          'maxSlides' => 4,
          'pager' => FALSE,
        );
        $items = array();
        foreach ($image_items as $image_item) {
          $items[] = array(
            '#theme' => 'image_formatter',
            '#item' => $image_item,
            '#image_style' => 'screen_4',
          );
        }
        $data = _bxslider_get_render_source($items, $settings);
      }
      elseif ($type == 'text') {
        $data = $body;
      }
      $elements[$delta] = array(
         '#theme' => 'spage_article_wrapper',
         '#type' => $type,
         '#title' => $title,
         'data' => $data,
      );
    }

    return $elements;
  }
}
