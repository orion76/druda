<?php

namespace Drupal\entity_solution;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Entity solution entity.
 *
 * @see \Drupal\entity_solution\Entity\EntitySolution.
 */
class EntitySolutionAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\entity_solution\Entity\EntitySolutionInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished entity solution entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published entity solution entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit entity solution entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete entity solution entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add entity solution entities');
  }

}
