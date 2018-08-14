<?php

namespace Drupal\entity_solution\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Entity solution entities.
 */
class EntitySolutionViewsData extends EntityViewsData {

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
