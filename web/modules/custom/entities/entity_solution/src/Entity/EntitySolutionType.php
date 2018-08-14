<?php

namespace Drupal\entity_solution\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the Entity solution type entity.
 *
 * @ConfigEntityType(
 *   id = "entity_solution_type",
 *   label = @Translation("Entity solution type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\entity_solution\EntitySolutionTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\entity_solution\Form\EntitySolutionTypeForm",
 *       "edit" = "Drupal\entity_solution\Form\EntitySolutionTypeForm",
 *       "delete" = "Drupal\entity_solution\Form\EntitySolutionTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\entity_solution\EntitySolutionTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "entity_solution_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "entity_solution",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/entity_solution_type/{entity_solution_type}",
 *     "add-form" = "/admin/structure/entity_solution_type/add",
 *     "edit-form" = "/admin/structure/entity_solution_type/{entity_solution_type}/edit",
 *     "delete-form" = "/admin/structure/entity_solution_type/{entity_solution_type}/delete",
 *     "collection" = "/admin/structure/entity_solution_type"
 *   }
 * )
 */
class EntitySolutionType extends ConfigEntityBundleBase implements EntitySolutionTypeInterface
{

    /**
     * The Entity solution type ID.
     *
     * @var string
     */
    protected $id;

    /**
     * The Entity solution type label.
     *
     * @var string
     */
    protected $label;

    /**
     * {@inheritdoc}
     *
     * Define the field properties here.
     *
     * Field name, type and size determine the table structure.
     *
     * In addition, we can define how the field and its content can be manipulated
     * in the GUI. The behaviour of the widgets used can be determined here.
     */
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
    {

// Standard field, used as unique if primary index.
//        $fields['id'] = BaseFieldDefinition::create('integer')
//            ->setLabel(t('ID'))
//            ->setDescription(t('The ID of the Term entity.'))
//            ->setReadOnly(TRUE);

// Standard field, unique outside of the scope of the current project.
//        $fields['uuid'] = BaseFieldDefinition::create('uuid')
//            ->setLabel(t('UUID'))
//            ->setDescription(t('The UUID of the Contact entity.'))
//            ->setReadOnly(TRUE);

// Name field for the contact.
// We set display options for the view as well as the form.
// Users with correct privileges can change the view and edit configuration.
//        $fields['pl'] = BaseFieldDefinition::create('string')
//            ->setLabel(t('Polish'))
//            ->setDescription(t('Polish version.'))
//            ->setSettings(array(
//                'default_value' => '',
//                'max_length' => 255,
//                'text_processing' => 0,
//            ))
//            ->setDisplayOptions('view', array(
//                'label' => 'above',
//                'type' => 'string',
//                'weight' => -6,
//            ))
//            ->setDisplayOptions('form', array(
//                'type' => 'string_textfield',
//                'weight' => -6,
//            ))
//            ->setDisplayConfigurable('form', TRUE)
//            ->setDisplayConfigurable('view', TRUE);
//
//        $fields['en'] = BaseFieldDefinition::create('string')
//            ->setLabel(t('English'))
//            ->setDescription(t('English version.'))
//            ->setSettings(array(
//                'default_value' => '',
//                'max_length' => 255,
//                'text_processing' => 0,
//            ))
//            ->setDisplayOptions('view', array(
//                'label' => 'above',
//                'type' => 'string',
//                'weight' => -4,
//            ))
//            ->setDisplayOptions('form', array(
//                'type' => 'string_textfield',
//                'weight' => -4,
//            ))
//            ->setDisplayConfigurable('form', TRUE)
//            ->setDisplayConfigurable('view', TRUE);

// Owner field of the contact.
// Entity reference field, holds the reference to the user object.
// The view shows the user name field of the user.
// The form presents a auto complete field for the user name.
        $fields['price'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('Price'))
            ->setDescription(t('Solution price.'))
            ->setSetting('target_type', 'entity_price')
            ->setSetting('handler', 'default')
            ->setSetting('handler_settings',
                [
                    'target_bundles' => [
                        'default' => 'default'
                    ],
                    'auto_create' => TRUE,
                ]
            )
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'author',
                'weight' => -3,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'entity_reference_autocomplete',
                'settings' => array(
                    'match_operator' => 'CONTAINS',
                    'size' => 60,
                    'placeholder' => '',
                ),
                'weight' => -3,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

//        $fields['created'] = BaseFieldDefinition::create('created')
//            ->setLabel(t('Created'))
//            ->setDescription(t('The time that the entity was created.'));
//
//        $fields['changed'] = BaseFieldDefinition::create('changed')
//            ->setLabel(t('Changed'))
//            ->setDescription(t('The time that the entity was last edited.'));

        return $fields;
    }

}
