<?php

namespace Drupal\entity_price\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\entity_price\Entity\EntityPriceInterface;

/**
 * Class EntityPriceController.
 *
 *  Returns responses for Entity price routes.
 */
class EntityPriceController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Entity price  revision.
   *
   * @param int $entity_price_revision
   *   The Entity price  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($entity_price_revision) {
    $entity_price = $this->entityManager()->getStorage('entity_price')->loadRevision($entity_price_revision);
    $view_builder = $this->entityManager()->getViewBuilder('entity_price');

    return $view_builder->view($entity_price);
  }

  /**
   * Page title callback for a Entity price  revision.
   *
   * @param int $entity_price_revision
   *   The Entity price  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($entity_price_revision) {
    $entity_price = $this->entityManager()->getStorage('entity_price')->loadRevision($entity_price_revision);
    return $this->t('Revision of %title from %date', ['%title' => $entity_price->label(), '%date' => format_date($entity_price->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Entity price .
   *
   * @param \Drupal\entity_price\Entity\EntityPriceInterface $entity_price
   *   A Entity price  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(EntityPriceInterface $entity_price) {
    $account = $this->currentUser();
    $langcode = $entity_price->language()->getId();
    $langname = $entity_price->language()->getName();
    $languages = $entity_price->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $entity_price_storage = $this->entityManager()->getStorage('entity_price');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $entity_price->label()]) : $this->t('Revisions for %title', ['%title' => $entity_price->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all entity price revisions") || $account->hasPermission('administer entity price entities')));
    $delete_permission = (($account->hasPermission("delete all entity price revisions") || $account->hasPermission('administer entity price entities')));

    $rows = [];

    $vids = $entity_price_storage->revisionIds($entity_price);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\entity_price\EntityPriceInterface $revision */
      $revision = $entity_price_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $entity_price->getRevisionId()) {
          $link = $this->l($date, new Url('entity.entity_price.revision', ['entity_price' => $entity_price->id(), 'entity_price_revision' => $vid]));
        }
        else {
          $link = $entity_price->link($date);
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
              Url::fromRoute('entity.entity_price.translation_revert', ['entity_price' => $entity_price->id(), 'entity_price_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.entity_price.revision_revert', ['entity_price' => $entity_price->id(), 'entity_price_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.entity_price.revision_delete', ['entity_price' => $entity_price->id(), 'entity_price_revision' => $vid]),
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

    $build['entity_price_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
