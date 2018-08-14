<?php

namespace Drupal\entity_order\Entity;

use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\entity_solution\Entity\EntitySolution;
use Drupal\user\UserInterface;

/**
 * Defines the Entity order entity.
 *
 * @ingroup entity_order
 *
 * @ContentEntityType(
 *   id = "entity_order",
 *   label = @Translation("Entity order"),
 *   bundle_label = @Translation("Entity order type"),
 *   handlers = {
 *     "storage" = "Drupal\entity_order\EntityOrderStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\entity_order\EntityOrderListBuilder",
 *     "views_data" = "Drupal\entity_order\Entity\EntityOrderViewsData",
 *     "translation" = "Drupal\entity_order\EntityOrderTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\entity_order\Form\EntityOrderForm",
 *       "add" = "Drupal\entity_order\Form\EntityOrderForm",
 *       "edit" = "Drupal\entity_order\Form\EntityOrderForm",
 *       "delete" = "Drupal\entity_order\Form\EntityOrderDeleteForm",
 *     },
 *     "access" = "Drupal\entity_order\EntityOrderAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\entity_order\EntityOrderHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "entity_order",
 *   data_table = "entity_order_field_data",
 *   revision_table = "entity_order_revision",
 *   revision_data_table = "entity_order_field_revision",
 *   translatable = TRUE,
 *   admin_permission = "administer entity order entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/entity_order/{entity_order}",
 *     "add-page" = "/solution-order/add",
 *     "add-form" = "/solution-order/add/{entity_order_type}",
 *     "edit-form" = "/solution-order/{entity_order}/edit",
 *     "delete-form" = "/solution-order/{entity_order}/delete",
 *     "version-history" =
 *   "/admin/structure/entity_order/{entity_order}/revisions",
 *     "revision" =
 *   "/admin/structure/entity_order/{entity_order}/revisions/{entity_order_revision}/view",
 *     "revision_revert" =
 *   "/admin/structure/entity_order/{entity_order}/revisions/{entity_order_revision}/revert",
 *     "revision_delete" =
 *   "/admin/structure/entity_order/{entity_order}/revisions/{entity_order_revision}/delete",
 *     "translation_revert" =
 *   "/admin/structure/entity_order/{entity_order}/revisions/{entity_order_revision}/revert/{langcode}",
 *     "collection" = "/admin/structure/entity_order",
 *   },
 *   bundle_entity_type = "entity_order_type",
 *   field_ui_base_route = "entity.entity_order_type.edit_form"
 * )
 */
class EntityOrder extends RevisionableContentEntityBase implements EntityOrderInterface {

  use EntityChangedTrait;

  const PRODUCT_QUERY = 'product-id';

  var $productId;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function urlRouteParameters($rel) {
    $uri_route_parameters = parent::urlRouteParameters($rel);

    if ($rel === 'revision_revert' && $this instanceof RevisionableInterface) {
      $uri_route_parameters[$this->getEntityTypeId() . '_revision'] = $this->getRevisionId();
    }
    elseif ($rel === 'revision_delete' && $this instanceof RevisionableInterface) {
      $uri_route_parameters[$this->getEntityTypeId() . '_revision'] = $this->getRevisionId();
    }

    return $uri_route_parameters;
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);

    foreach (array_keys($this->getTranslationLanguages()) as $langcode) {
      $translation = $this->getTranslation($langcode);

      // If no owner has been set explicitly, make the anonymous user the owner.
      if (!$translation->getOwner()) {
        $translation->setOwnerId(0);
      }
    }

    // If no revision author has been set explicitly, make the entity_order owner the
    // revision author.
    if (!$this->getRevisionUser()) {
      $this->setRevisionUserId($this->getOwnerId());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);


    $fields['order_product'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Product'))
      ->setDescription(t('The product for order'))
      ->setSetting('target_type', 'entity_solution')
      ->setSetting('handler', 'default')
      ->setDefaultValueCallback(static::class . '::getProductId')
//      ->setDisplayOptions('form', [
//        'type' => 'entity_reference_autocomplete',
//        'weight' => 5,
//        'settings' => [
//          'match_operator' => 'CONTAINS',
//          'size' => '60',
//          'autocomplete_type' => 'tags',
//          'placeholder' => '',
//        ],
//      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'entity_reference_entity_view',
      ])
//      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Entity order entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
//      ->setDisplayOptions('form', [
//        'type' => 'entity_reference_autocomplete',
//        'weight' => 5,
//        'settings' => [
//          'match_operator' => 'CONTAINS',
//          'size' => '60',
//          'autocomplete_type' => 'tags',
//          'placeholder' => '',
//        ],
//      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Entity order entity.'))
      ->setRevisionable(TRUE)
      ->setDefaultValueCallback(static::class . '::getOrderTitle')
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Entity order is published.'))
      ->setRevisionable(TRUE)
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);


    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['revision_translation_affected'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Revision translation affected'))
      ->setDescription(t('Indicates if the last edit of a translation belongs to current revision.'))
      ->setReadOnly(TRUE)
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    return $fields;
  }

  public static function getProductId() {
    return [self::getProduct()->id()];
  }

  public static function getProduct() {
    return EntitySolution::load(\Drupal::request()->get(self::PRODUCT_QUERY));
  }

  public static function getOrderTitle() {
    return [self::getProduct()->get('name')->value];
  }
}
