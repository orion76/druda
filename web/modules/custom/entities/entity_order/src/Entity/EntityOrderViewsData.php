<?php

namespace Drupal\entity_order\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Entity order entities.
 */
class EntityOrderViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
