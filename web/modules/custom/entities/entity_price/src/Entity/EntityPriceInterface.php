<?php

namespace Drupal\entity_price\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Entity price entities.
 *
 * @ingroup entity_price
 */
interface EntityPriceInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Entity price name.
   *
   * @return string
   *   Name of the Entity price.
   */
  public function getName();

  /**
   * Sets the Entity price name.
   *
   * @param string $name
   *   The Entity price name.
   *
   * @return \Drupal\entity_price\Entity\EntityPriceInterface
   *   The called Entity price entity.
   */
  public function setName($name);

  /**
   * Gets the Entity price creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Entity price.
   */
  public function getCreatedTime();

  /**
   * Sets the Entity price creation timestamp.
   *
   * @param int $timestamp
   *   The Entity price creation timestamp.
   *
   * @return \Drupal\entity_price\Entity\EntityPriceInterface
   *   The called Entity price entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Entity price published status indicator.
   *
   * Unpublished Entity price are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Entity price is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Entity price.
   *
   * @param bool $published
   *   TRUE to set this Entity price to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\entity_price\Entity\EntityPriceInterface
   *   The called Entity price entity.
   */
  public function setPublished($published);

  /**
   * Gets the Entity price revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Entity price revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\entity_price\Entity\EntityPriceInterface
   *   The called Entity price entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Entity price revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Entity price revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\entity_price\Entity\EntityPriceInterface
   *   The called Entity price entity.
   */
  public function setRevisionUserId($uid);

}
