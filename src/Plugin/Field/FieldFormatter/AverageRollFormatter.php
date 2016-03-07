<?php
/**
 * @file
 * Contains \Drupal\dicefield\Plugin\Field\FieldFormatter\AverageRollFormatter.
 */

namespace Drupal\dicefield\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'average_roll' formatter.
 *
 * @FieldFormatter (
 *   id = "average_roll",
 *   label = @Translation("Average roll"),
 *   field_types = {
 *     "dice"
 *   }
 * )
 */
class AverageRollFormatter extends FormatterBase {
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode = NULL) {
    $elements = array();

    foreach ($items as $delta => $item) {
      $elements[$delta] = array(
        '#type' => 'markup',
        '#markup' => $item->average,
      );
    }

    return $elements;
  }
}
