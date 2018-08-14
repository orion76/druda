<?php

/**
 * @file
 * Contains entity_solution.page.inc.
 *
 * Page callback for Entity solution entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Entity solution templates.
 *
 * Default template: entity_solution.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_entity_solution(array &$variables) {
  // Fetch EntitySolution Entity Object.
  $entity_solution = $variables['elements']['#entity_solution'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
