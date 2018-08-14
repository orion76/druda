<?php

namespace Drupal\entity_solution;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface EntitySolutionStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Entity solution revision IDs for a specific Entity solution.
   *
   * @param \Drupal\entity_solution\Entity\EntitySolutionInterface $entity
   *   The Entity solution entity.
   *
   * @return int[]
   *   Entity solution revision IDs (in ascending order).
   */
  public function revisionIds(EntitySolutionInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Entity solution author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Entity solution revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\entity_solution\Entity\EntitySolutionInterface $entity
   *   The Entity solution entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(EntitySolutionInterface $entity);

  /**
   * Unsets the language for all Entity solution with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
