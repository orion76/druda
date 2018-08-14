<?php

namespace Drupal\entity_price;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface EntityPriceStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Entity price revision IDs for a specific Entity price.
   *
   * @param \Drupal\entity_price\Entity\EntityPriceInterface $entity
   *   The Entity price entity.
   *
   * @return int[]
   *   Entity price revision IDs (in ascending order).
   */
  public function revisionIds(EntityPriceInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Entity price author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Entity price revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\entity_price\Entity\EntityPriceInterface $entity
   *   The Entity price entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(EntityPriceInterface $entity);

  /**
   * Unsets the language for all Entity price with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
