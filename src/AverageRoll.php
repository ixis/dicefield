<?php
/**
 * @file
 * Contains \Drupal\dicefield\AverageRoll.
 */

namespace Drupal\dicefield;

use Drupal\Component\Utility\SafeMarkup;
use Drupal\Component\Utility\String;
use Drupal\Core\TypedData\DataDefinitionInterface;
use Drupal\Core\TypedData\TypedDataInterface;
use Drupal\Core\TypedData\TypedData;

/**
 * A computed property for an average dice roll.
 */
class AverageRoll extends TypedData {

  /**
   * Cached processed value.
   *
   * @var string|null
   */
  protected $processed = NULL;

  /**
   * Implements \Drupal\Core\TypedData\TypedDataInterface::getValue().
   */
  public function getValue($langcode = NULL) {
    if ($this->processed !== NULL) {
      return $this->processed;
    }

    $item = $this->getParent();

    // The minimum roll is the same as the number of dice, which will occur if
    // all dice come up as a 1. Then apply the modifier.
    $minimum = $item->number + $item->modifier;

    // The maximum roll is the number of sides on each die times the number of
    // dice. Then apply the modifier.
    $maximum = ($item->number * $item->sides) + $item->modifier;

    // Add together the minimum and maximum and divide by two. In cases where we
    // get a fraction, take the lower boundary.
    $this->processed = ($minimum + $maximum) / 2;
    return $this->processed;
  }

  /**
   * Implements \Drupal\Core\TypedData\TypedDataInterface::setValue().
   */
  public function setValue($value, $notify = TRUE) {
    $this->processed = $value;

    // Notify the parent of any changes.
    if ($notify && isset($this->parent)) {
      $this->parent->onChange($this->name);
    }
  }
}
