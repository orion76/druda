<?php

namespace Drupal\entity_solution\Plugin\Field\FieldType;

use Drupal\Core\TypedData\Exception\MissingDataException;
use Drupal\Core\Url;
use Drupal\entity_order\Entity\EntityOrder;
use Drupal\link\Plugin\Field\FieldType\LinkItem;

/**
 * Plugin implementation of the 'solution_order_button' field type.
 *
 * @FieldType(
 *   id = "solution_order_button",
 *   label = @Translation("Solution order button field type"),
 *   description = @Translation("Button for order Solution") * ),
 *   default_formatter = "uri_link",
 *   list_class =
 *   "\Drupal\entity_solution\Plugin\Field\FieldType\SolutionOrderButtonItemList",
 *   constraints = {"LinkType" = {}, "LinkAccess" = {}, "LinkExternalProtocols"
 *   = {}, "LinkNotExistingInternal" = {}}
 */
class SolutionOrderButtonFieldType extends LinkItem {

  /**
   * Whether or not the value has been calculated.
   *
   * @var bool
   */
  protected $isCalculated = FALSE;

  /**
   * {@inheritdoc}
   */
  public function __get($name) {
    $this->ensureCalculated();
    return parent::__get($name);
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $this->ensureCalculated();
    return parent::isEmpty();
  }

  /**
   * {@inheritdoc}
   */
  public function getValue() {
    $this->ensureCalculated();
    return parent::getValue();
  }

  /**
   * Calculates the value of the field and sets it.
   *
   */
  protected function ensureCalculated() {
    if (!$this->isCalculated) {
      $entity = $this->getEntity();
      if (!$entity->isNew()) {
        // Some custom code that retrieves the current company.
        try {
          /**
           * @var $product \Drupal\Core\Entity\Entity
           */
          $product = $this->getEntity();

          $url = Url::fromRoute('entity.entity_order.add_form',
            ['entity_order_type' => $product->bundle()],
            [
              'query' => [
                EntityOrder::PRODUCT_QUERY => $product->id(),
                'destination' => \Drupal::destination()->get(),
              ],
            ]);
          $uri = $url->toUriString();

          $value = [
            'uri' => $uri,
            'title' => t('To order'),
          ];
          $this->setValue($value);
          $this->isCalculated = TRUE;
        } catch (MissingDataException $e) {
        }
      }
    }
  }


}
