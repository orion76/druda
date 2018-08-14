<?php

namespace Drupal\entity_link;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\entity_link\Entity\EntityLinkInterface;

/**
 * Defines the storage handler class for Entity link entities.
 *
 * This extends the base storage class, adding required special handling for
 * Entity link entities.
 *
 * @ingroup entity_link
 */
class EntityLinkStorage extends SqlContentEntityStorage implements EntityLinkStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(EntityLinkInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {entity_link_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {entity_link_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(EntityLinkInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {entity_link_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('entity_link_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
