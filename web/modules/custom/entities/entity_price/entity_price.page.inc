<?php

/**
 * @file
 * Contains entity_price.page.inc.
 *
 * Page callback for Entity price entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Entity price templates.
 *
 * Default template: entity_price.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_entity_price(array &$variables) {
  // Fetch EntityPrice Entity Object.
  $entity_price = $variables['elements']['#entity_price'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
