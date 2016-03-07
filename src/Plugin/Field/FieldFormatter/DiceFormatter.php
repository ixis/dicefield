<?php
/**
 * @file
 * Contains \Drupal\dicefield\Plugin\Field\FieldFormatter\DiceFormatter.
 */

namespace Drupal\dicefield\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'dice' formatter.
 *
 * @FieldFormatter (
 *   id = "dice",
 *   label = @Translation("Dice"),
 *   field_types = {
 *     "dice"
 *   }
 * )
 */
class DiceFormatter extends FormatterBase {
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode = NULL) {
    $elements = array();

    foreach ($items as $delta => $item) {
      if ($item->sides == 1) {
        // If we are using a 1-sided die (occasionally sees use), just write "1"
        // instead of "1d1" which looks silly.
        $markup = $item->number * $item->sides;
      }
      else {
        $markup = $item->number . 'd' . $item->sides;
      }

      // Add the modifier if necessary.
      if (!empty($item->modifier)) {
        $sign = $item->modifier > 0 ? '+' : '-';
        $markup .= $sign . $item->modifier;
      }

      $elements[$delta] = array(
        '#type' => 'markup',
        '#markup' => $markup,
      );
    }

    return $elements;
  }
}
