<?php

namespace Drupal\entity_order\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class EntityOrderTypeForm.
 */
class EntityOrderTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $entity_order_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $entity_order_type->label(),
      '#description' => $this->t("Label for the Entity order type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $entity_order_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\entity_order\Entity\EntityOrderType::load',
      ],
      '#disabled' => !$entity_order_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity_order_type = $this->entity;
    $status = $entity_order_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Entity order type.', [
          '%label' => $entity_order_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Entity order type.', [
          '%label' => $entity_order_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($entity_order_type->toUrl('collection'));
  }

}
