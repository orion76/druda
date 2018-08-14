<?php

/**
 * @file
 * Contains entity_order.page.inc.
 *
 * Page callback for Entity order entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Entity order templates.
 *
 * Default template: entity_order.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_entity_order(array &$variables) {
  // Fetch EntityOrder Entity Object.
  $entity_order = $variables['elements']['#entity_order'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
