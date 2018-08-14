<?php

namespace Drupal\entity_solution\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class EntitySolutionTypeForm.
 */
class EntitySolutionTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $entity_solution_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $entity_solution_type->label(),
      '#description' => $this->t("Label for the Entity solution type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $entity_solution_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\entity_solution\Entity\EntitySolutionType::load',
      ],
      '#disabled' => !$entity_solution_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity_solution_type = $this->entity;
    $status = $entity_solution_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Entity solution type.', [
          '%label' => $entity_solution_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Entity solution type.', [
          '%label' => $entity_solution_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($entity_solution_type->toUrl('collection'));
  }

}
