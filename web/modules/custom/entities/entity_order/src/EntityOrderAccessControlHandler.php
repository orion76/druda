<?php

namespace Drupal\entity_order;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Access controller for the Entity order entity.
 *
 * @see \Drupal\entity_order\Entity\EntityOrder.
 */
class EntityOrderAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\entity_order\Entity\EntityOrderInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished entity order entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published entity order entities') ||
          $this->accountIsCustomer($entity, $operation, $account);

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit entity order entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete entity order entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  protected function accountIsCustomer(EntityInterface $entity, $operation, AccountInterface $account) {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add entity order entities');
  }

}
