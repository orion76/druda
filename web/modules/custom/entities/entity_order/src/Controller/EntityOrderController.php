<?php

namespace Drupal\entity_order\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\entity_order\Entity\EntityOrderInterface;

/**
 * Class EntityOrderController.
 *
 *  Returns responses for Entity order routes.
 */
class EntityOrderController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Entity order  revision.
   *
   * @param int $entity_order_revision
   *   The Entity order  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($entity_order_revision) {
    $entity_order = $this->entityManager()->getStorage('entity_order')->loadRevision($entity_order_revision);
    $view_builder = $this->entityManager()->getViewBuilder('entity_order');

    return $view_builder->view($entity_order);
  }

  /**
   * Page title callback for a Entity order  revision.
   *
   * @param int $entity_order_revision
   *   The Entity order  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($entity_order_revision) {
    $entity_order = $this->entityManager()->getStorage('entity_order')->loadRevision($entity_order_revision);
    return $this->t('Revision of %title from %date', ['%title' => $entity_order->label(), '%date' => format_date($entity_order->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Entity order .
   *
   * @param \Drupal\entity_order\Entity\EntityOrderInterface $entity_order
   *   A Entity order  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(EntityOrderInterface $entity_order) {
    $account = $this->currentUser();
    $langcode = $entity_order->language()->getId();
    $langname = $entity_order->language()->getName();
    $languages = $entity_order->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $entity_order_storage = $this->entityManager()->getStorage('entity_order');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $entity_order->label()]) : $this->t('Revisions for %title', ['%title' => $entity_order->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all entity order revisions") || $account->hasPermission('administer entity order entities')));
    $delete_permission = (($account->hasPermission("delete all entity order revisions") || $account->hasPermission('administer entity order entities')));

    $rows = [];

    $vids = $entity_order_storage->revisionIds($entity_order);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\entity_order\EntityOrderInterface $revision */
      $revision = $entity_order_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $entity_order->getRevisionId()) {
          $link = $this->l($date, new Url('entity.entity_order.revision', ['entity_order' => $entity_order->id(), 'entity_order_revision' => $vid]));
        }
        else {
          $link = $entity_order->link($date);
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
              Url::fromRoute('entity.entity_order.translation_revert', ['entity_order' => $entity_order->id(), 'entity_order_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.entity_order.revision_revert', ['entity_order' => $entity_order->id(), 'entity_order_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.entity_order.revision_delete', ['entity_order' => $entity_order->id(), 'entity_order_revision' => $vid]),
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

    $build['entity_order_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
