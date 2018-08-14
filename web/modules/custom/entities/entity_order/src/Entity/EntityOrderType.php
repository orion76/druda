<?php

namespace Drupal\entity_order\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Entity order type entity.
 *
 * @ConfigEntityType(
 *   id = "entity_order_type",
 *   label = @Translation("Entity order type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\entity_order\EntityOrderTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\entity_order\Form\EntityOrderTypeForm",
 *       "edit" = "Drupal\entity_order\Form\EntityOrderTypeForm",
 *       "delete" = "Drupal\entity_order\Form\EntityOrderTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\entity_order\EntityOrderTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "entity_order_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "entity_order",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/entity_order_type/{entity_order_type}",
 *     "add-form" = "/admin/structure/entity_order_type/add",
 *     "edit-form" = "/admin/structure/entity_order_type/{entity_order_type}/edit",
 *     "delete-form" = "/admin/structure/entity_order_type/{entity_order_type}/delete",
 *     "collection" = "/admin/structure/entity_order_type"
 *   }
 * )
 */
class EntityOrderType extends ConfigEntityBundleBase implements EntityOrderTypeInterface {

  /**
   * The Entity order type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Entity order type label.
   *
   * @var string
   */
  protected $label;

}
