<?php

namespace Drupal\entity_solution;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\entity_solution\Entity\EntitySolutionInterface;

/**
 * Defines the storage handler class for Entity solution entities.
 *
 * This extends the base storage class, adding required special handling for
 * Entity solution entities.
 *
 * @ingroup entity_solution
 */
class EntitySolutionStorage extends SqlContentEntityStorage implements EntitySolutionStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(EntitySolutionInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {entity_solution_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {entity_solution_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(EntitySolutionInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {entity_solution_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('entity_solution_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
