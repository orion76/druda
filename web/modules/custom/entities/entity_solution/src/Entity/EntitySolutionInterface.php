<?php

namespace Drupal\entity_solution\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Entity solution entities.
 *
 * @ingroup entity_solution
 */
interface EntitySolutionInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Entity solution name.
   *
   * @return string
   *   Name of the Entity solution.
   */
  public function getName();

  /**
   * Sets the Entity solution name.
   *
   * @param string $name
   *   The Entity solution name.
   *
   * @return \Drupal\entity_solution\Entity\EntitySolutionInterface
   *   The called Entity solution entity.
   */
  public function setName($name);

  /**
   * Gets the Entity solution creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Entity solution.
   */
  public function getCreatedTime();

  /**
   * Sets the Entity solution creation timestamp.
   *
   * @param int $timestamp
   *   The Entity solution creation timestamp.
   *
   * @return \Drupal\entity_solution\Entity\EntitySolutionInterface
   *   The called Entity solution entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Entity solution published status indicator.
   *
   * Unpublished Entity solution are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Entity solution is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Entity solution.
   *
   * @param bool $published
   *   TRUE to set this Entity solution to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\entity_solution\Entity\EntitySolutionInterface
   *   The called Entity solution entity.
   */
  public function setPublished($published);

  /**
   * Gets the Entity solution revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Entity solution revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\entity_solution\Entity\EntitySolutionInterface
   *   The called Entity solution entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Entity solution revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Entity solution revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\entity_solution\Entity\EntitySolutionInterface
   *   The called Entity solution entity.
   */
  public function setRevisionUserId($uid);

}
