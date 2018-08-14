<?php

/**
 * @file
 * Contains entity_link.page.inc.
 *
 * Page callback for Entity link entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Entity link templates.
 *
 * Default template: entity_link.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_entity_link(array &$variables) {
  // Fetch EntityLink Entity Object.
  $entity_link = $variables['elements']['#entity_link'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
