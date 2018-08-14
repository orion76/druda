<?php

namespace Drupal\entity_link\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Entity link type entity.
 *
 * @ConfigEntityType(
 *   id = "entity_link_type",
 *   label = @Translation("Entity link type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\entity_link\EntityLinkTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\entity_link\Form\EntityLinkTypeForm",
 *       "edit" = "Drupal\entity_link\Form\EntityLinkTypeForm",
 *       "delete" = "Drupal\entity_link\Form\EntityLinkTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\entity_link\EntityLinkTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "entity_link_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "entity_link",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/entity_link_type/{entity_link_type}",
 *     "add-form" = "/admin/structure/entity_link_type/add",
 *     "edit-form" = "/admin/structure/entity_link_type/{entity_link_type}/edit",
 *     "delete-form" = "/admin/structure/entity_link_type/{entity_link_type}/delete",
 *     "collection" = "/admin/structure/entity_link_type"
 *   }
 * )
 */
class EntityLinkType extends ConfigEntityBundleBase implements EntityLinkTypeInterface {

  /**
   * The Entity link type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Entity link type label.
   *
   * @var string
   */
  protected $label;

}
