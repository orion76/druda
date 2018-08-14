<?php

namespace Drupal\entity_link;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface EntityLinkStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Entity link revision IDs for a specific Entity link.
   *
   * @param \Drupal\entity_link\Entity\EntityLinkInterface $entity
   *   The Entity link entity.
   *
   * @return int[]
   *   Entity link revision IDs (in ascending order).
   */
  public function revisionIds(EntityLinkInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Entity link author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Entity link revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\entity_link\Entity\EntityLinkInterface $entity
   *   The Entity link entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(EntityLinkInterface $entity);

  /**
   * Unsets the language for all Entity link with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
