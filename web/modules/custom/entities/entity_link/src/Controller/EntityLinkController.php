<?php

namespace Drupal\entity_link\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\entity_link\Entity\EntityLinkInterface;

/**
 * Class EntityLinkController.
 *
 *  Returns responses for Entity link routes.
 */
class EntityLinkController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Entity link  revision.
   *
   * @param int $entity_link_revision
   *   The Entity link  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($entity_link_revision) {
    $entity_link = $this->entityManager()->getStorage('entity_link')->loadRevision($entity_link_revision);
    $view_builder = $this->entityManager()->getViewBuilder('entity_link');

    return $view_builder->view($entity_link);
  }

  /**
   * Page title callback for a Entity link  revision.
   *
   * @param int $entity_link_revision
   *   The Entity link  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($entity_link_revision) {
    $entity_link = $this->entityManager()->getStorage('entity_link')->loadRevision($entity_link_revision);
    return $this->t('Revision of %title from %date', ['%title' => $entity_link->label(), '%date' => format_date($entity_link->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Entity link .
   *
   * @param \Drupal\entity_link\Entity\EntityLinkInterface $entity_link
   *   A Entity link  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(EntityLinkInterface $entity_link) {
    $account = $this->currentUser();
    $langcode = $entity_link->language()->getId();
    $langname = $entity_link->language()->getName();
    $languages = $entity_link->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $entity_link_storage = $this->entityManager()->getStorage('entity_link');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $entity_link->label()]) : $this->t('Revisions for %title', ['%title' => $entity_link->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all entity link revisions") || $account->hasPermission('administer entity link entities')));
    $delete_permission = (($account->hasPermission("delete all entity link revisions") || $account->hasPermission('administer entity link entities')));

    $rows = [];

    $vids = $entity_link_storage->revisionIds($entity_link);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\entity_link\EntityLinkInterface $revision */
      $revision = $entity_link_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $entity_link->getRevisionId()) {
          $link = $this->l($date, new Url('entity.entity_link.revision', ['entity_link' => $entity_link->id(), 'entity_link_revision' => $vid]));
        }
        else {
          $link = $entity_link->link($date);
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
              Url::fromRoute('entity.entity_link.translation_revert', ['entity_link' => $entity_link->id(), 'entity_link_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.entity_link.revision_revert', ['entity_link' => $entity_link->id(), 'entity_link_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.entity_link.revision_delete', ['entity_link' => $entity_link->id(), 'entity_link_revision' => $vid]),
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

    $build['entity_link_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
