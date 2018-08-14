<?php

namespace Drupal\entity_solution\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\entity_solution\Entity\EntitySolutionInterface;

/**
 * Class EntitySolutionController.
 *
 *  Returns responses for Entity solution routes.
 */
class EntitySolutionController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Entity solution  revision.
   *
   * @param int $entity_solution_revision
   *   The Entity solution  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($entity_solution_revision) {
    $entity_solution = $this->entityManager()->getStorage('entity_solution')->loadRevision($entity_solution_revision);
    $view_builder = $this->entityManager()->getViewBuilder('entity_solution');

    return $view_builder->view($entity_solution);
  }

  /**
   * Page title callback for a Entity solution  revision.
   *
   * @param int $entity_solution_revision
   *   The Entity solution  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($entity_solution_revision) {
    $entity_solution = $this->entityManager()->getStorage('entity_solution')->loadRevision($entity_solution_revision);
    return $this->t('Revision of %title from %date', ['%title' => $entity_solution->label(), '%date' => format_date($entity_solution->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Entity solution .
   *
   * @param \Drupal\entity_solution\Entity\EntitySolutionInterface $entity_solution
   *   A Entity solution  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(EntitySolutionInterface $entity_solution) {
    $account = $this->currentUser();
    $langcode = $entity_solution->language()->getId();
    $langname = $entity_solution->language()->getName();
    $languages = $entity_solution->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $entity_solution_storage = $this->entityManager()->getStorage('entity_solution');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $entity_solution->label()]) : $this->t('Revisions for %title', ['%title' => $entity_solution->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all entity solution revisions") || $account->hasPermission('administer entity solution entities')));
    $delete_permission = (($account->hasPermission("delete all entity solution revisions") || $account->hasPermission('administer entity solution entities')));

    $rows = [];

    $vids = $entity_solution_storage->revisionIds($entity_solution);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\entity_solution\EntitySolutionInterface $revision */
      $revision = $entity_solution_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $entity_solution->getRevisionId()) {
          $link = $this->l($date, new Url('entity.entity_solution.revision', ['entity_solution' => $entity_solution->id(), 'entity_solution_revision' => $vid]));
        }
        else {
          $link = $entity_solution->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.entity_solution.translation_revert', ['entity_solution' => $entity_solution->id(), 'entity_solution_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.entity_solution.revision_revert', ['entity_solution' => $entity_solution->id(), 'entity_solution_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.entity_solution.revision_delete', ['entity_solution' => $entity_solution->id(), 'entity_solution_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['entity_solution_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
