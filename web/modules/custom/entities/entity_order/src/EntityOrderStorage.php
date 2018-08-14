<?php

namespace Drupal\entity_order;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\entity_order\Entity\EntityOrderInterface;

/**
 * Defines the storage handler class for Entity order entities.
 *
 * This extends the base storage class, adding required special handling for
 * Entity order entities.
 *
 * @ingroup entity_order
 */
class EntityOrderStorage extends SqlContentEntityStorage implements EntityOrderStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(EntityOrderInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {entity_order_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {entity_order_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(EntityOrderInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {entity_order_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('entity_order_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
