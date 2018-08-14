<?php

namespace Drupal\druda_common\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class PagesController.
 */
class PagesController extends ControllerBase {

  /**
   * Front.
   *
   * @return array
   *   Return Hello string.
   */
  public function Front() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: Front'),
    ];
  }

}
