<?php

namespace Drupal\entity_order\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Entity order entities.
 *
 * @ingroup entity_order
 */
interface EntityOrderInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Entity order name.
   *
   * @return string
   *   Name of the Entity order.
   */
  public function getName();

  /**
   * Sets the Entity order name.
   *
   * @param string $name
   *   The Entity order name.
   *
   * @return \Drupal\entity_order\Entity\EntityOrderInterface
   *   The called Entity order entity.
   */
  public function setName($name);

  /**
   * Gets the Entity order creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Entity order.
   */
  public function getCreatedTime();

  /**
   * Sets the Entity order creation timestamp.
   *
   * @param int $timestamp
   *   The Entity order creation timestamp.
   *
   * @return \Drupal\entity_order\Entity\EntityOrderInterface
   *   The called Entity order entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Entity order published status indicator.
   *
   * Unpublished Entity order are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Entity order is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Entity order.
   *
   * @param bool $published
   *   TRUE to set this Entity order to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\entity_order\Entity\EntityOrderInterface
   *   The called Entity order entity.
   */
  public function setPublished($published);

  /**
   * Gets the Entity order revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Entity order revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\entity_order\Entity\EntityOrderInterface
   *   The called Entity order entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Entity order revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Entity order revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\entity_order\Entity\EntityOrderInterface
   *   The called Entity order entity.
   */
  public function setRevisionUserId($uid);

}
