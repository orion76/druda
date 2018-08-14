<?php

namespace Drupal\entity_link;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Entity link entity.
 *
 * @see \Drupal\entity_link\Entity\EntityLink.
 */
class EntityLinkAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\entity_link\Entity\EntityLinkInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished entity link entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published entity link entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit entity link entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete entity link entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add entity link entities');
  }

}
