<?php

namespace Drupal\entity_link\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Entity link entities.
 *
 * @ingroup entity_link
 */
interface EntityLinkInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Entity link name.
   *
   * @return string
   *   Name of the Entity link.
   */
  public function getName();

  /**
   * Sets the Entity link name.
   *
   * @param string $name
   *   The Entity link name.
   *
   * @return \Drupal\entity_link\Entity\EntityLinkInterface
   *   The called Entity link entity.
   */
  public function setName($name);

  /**
   * Gets the Entity link creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Entity link.
   */
  public function getCreatedTime();

  /**
   * Sets the Entity link creation timestamp.
   *
   * @param int $timestamp
   *   The Entity link creation timestamp.
   *
   * @return \Drupal\entity_link\Entity\EntityLinkInterface
   *   The called Entity link entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Entity link published status indicator.
   *
   * Unpublished Entity link are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Entity link is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Entity link.
   *
   * @param bool $published
   *   TRUE to set this Entity link to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\entity_link\Entity\EntityLinkInterface
   *   The called Entity link entity.
   */
  public function setPublished($published);

  /**
   * Gets the Entity link revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Entity link revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\entity_link\Entity\EntityLinkInterface
   *   The called Entity link entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Entity link revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Entity link revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\entity_link\Entity\EntityLinkInterface
   *   The called Entity link entity.
   */
  public function setRevisionUserId($uid);

}
