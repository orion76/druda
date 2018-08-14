<?php

namespace Drupal\entity_price\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Entity price type entity.
 *
 * @ConfigEntityType(
 *   id = "entity_price_type",
 *   label = @Translation("Entity price type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\entity_price\EntityPriceTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\entity_price\Form\EntityPriceTypeForm",
 *       "edit" = "Drupal\entity_price\Form\EntityPriceTypeForm",
 *       "delete" = "Drupal\entity_price\Form\EntityPriceTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\entity_price\EntityPriceTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "entity_price_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "entity_price",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/type-custom/entity_price_type/{entity_price_type}",
 *     "add-form" = "/admin/structure/type-custom/entity_price_type/add",
 *     "edit-form" = "/admin/structure/type-custom/entity_price_type/{entity_price_type}/edit",
 *     "delete-form" = "/admin/structure/type-custom/entity_price_type/{entity_price_type}/delete",
 *     "collection" = "/admin/structure/type-custom/entity_price_type"
 *   }
 * )
 */
class EntityPriceType extends ConfigEntityBundleBase implements EntityPriceTypeInterface {

  /**
   * The Entity price type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Entity price type label.
   *
   * @var string
   */
  protected $label;

}
