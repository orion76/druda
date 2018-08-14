<?php

namespace Drupal\entity_price;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Entity price entity.
 *
 * @see \Drupal\entity_price\Entity\EntityPrice.
 */
class EntityPriceAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\entity_price\Entity\EntityPriceInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished entity price entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published entity price entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit entity price entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete entity price entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add entity price entities');
  }

}
