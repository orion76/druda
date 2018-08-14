<?php

namespace Drupal\druda_fields\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'title_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "title_formatter",
 *   label = @Translation("Title formatter"),
 *   field_types = {
 *     "text",
 *     "string",
 *     "string_long"
 *   }
 * )
 */
class TitleFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
        // Implement default settings.
        'html_tag' => 'h2',
      ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements['html_tag'] = [
      '#type' => 'textfield',
      '#title' => t('HTML Tag'),
      '#default_value' => $this->getSetting('html_tag'),
    ];

    return $elements + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $settings = $this->getSettings();

    if (!empty($settings['html_tag'])) {
      $summary[] = t('HTML Tag: @html_tag', ['@html_tag' => $settings['html_tag']]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $settings = $this->getSettings();

    $elements = [];

    if (!empty($settings['html_tag'])) {
      foreach ($items as $delta => $item) {
        $elements[$delta] = [
          '#type' => 'html_tag',
          '#tag' => $settings['html_tag'],
          '#value' => $item->value,
        ];
      }
    }
    else {
      foreach ($items as $delta => $item) {
        $elements[$delta] = ['#markup' => $item->value];
      }
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return nl2br(Html::escape($item->value));
  }

}
