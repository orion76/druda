<?php

namespace Drupal\entity_price;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\entity_price\Entity\EntityPriceInterface;

/**
 * Defines the storage handler class for Entity price entities.
 *
 * This extends the base storage class, adding required special handling for
 * Entity price entities.
 *
 * @ingroup entity_price
 */
class EntityPriceStorage extends SqlContentEntityStorage implements EntityPriceStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(EntityPriceInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {entity_price_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {entity_price_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(EntityPriceInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {entity_price_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('entity_price_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
