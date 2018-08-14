<?php

namespace Drupal\entity_order;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface EntityOrderStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Entity order revision IDs for a specific Entity order.
   *
   * @param \Drupal\entity_order\Entity\EntityOrderInterface $entity
   *   The Entity order entity.
   *
   * @return int[]
   *   Entity order revision IDs (in ascending order).
   */
  public function revisionIds(EntityOrderInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Entity order author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Entity order revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\entity_order\Entity\EntityOrderInterface $entity
   *   The Entity order entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(EntityOrderInterface $entity);

  /**
   * Unsets the language for all Entity order with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
