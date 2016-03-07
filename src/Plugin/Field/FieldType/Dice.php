<?php

/**
 * @file
 * Contains \Drupal\dicefield\Plugin\Field\FieldType\Dice.
 */

namespace Drupal\dicefield\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'dice' field type.
 *
 * @FieldType (
 *   id = "dice",
 *   label = @Translation("Dice"),
 *   description = @Translation("Stores a dice roll such as 1d6 or 2d8+3."),
 *   default_widget = "dice",
 *   default_formatter = "dice"
 * )
 */
class Dice extends FieldItemBase {
  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'number' => array(
          'type' => 'int',
          'unsigned' => TRUE,
          'not null' => FALSE,
        ),
        'sides' => array(
          'type' => 'int',
          'unsigned' => TRUE,
          'not null' => TRUE,
        ),
        'modifier' => array(
          'type' => 'int',
          'not null' => TRUE,
          'default' => 0,
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value1 = $this->get('number')->getValue();
    $value2 = $this->get('sides')->getValue();
    $value3 = $this->get('modifier')->getValue();
    return empty($value1) && empty($value2) && empty($value3);
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Add our properties.
    $properties['number'] = DataDefinition::create('integer')
      ->setLabel(t('Number'))
      ->setDescription(t('The number of dice'));

    $properties['sides'] = DataDefinition::create('integer')
      ->setLabel(t('Sides'))
      ->setDescription(t('The number of sides on each die'));

    $properties['modifier'] = DataDefinition::create('integer')
      ->setLabel(t('Modifier'))
      ->setDescription(t('The modifier to be applied after the roll'));

    $properties['average'] = DataDefinition::create('float')
      ->setLabel(t('Average'))
      ->setDescription(t('The average roll produced by this dice setup'))
      ->setComputed(TRUE)
      ->setClass('\Drupal\dicefield\AverageRoll');

    return $properties;
  }
}
