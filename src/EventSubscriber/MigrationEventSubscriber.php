<?php
/**
 * MigrationEventSubscriber for Debugging Migrations.
 *
 * @category Class
 * @package  migrate_devel
 */
namespace Drupal\migrate_devel\EventSubscriber;

use Drupal\migrate\Event\MigrateEvents;
use Drupal\migrate\Event\MigratePostRowSaveEvent;
use Drupal\migrate\Event\MigratePreRowSaveEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * MigrationEventSubscriber for Debugging Migrations.
 */
class MigrationEventSubscriber implements EventSubscriberInterface {

  /**
   * Pre Row Save Function for --migrate-debug-pre.
   *
   * @param \Drupal\migrate\Event\MigratePreRowSaveEvent $event
   */
  public function debugRowPreSave(MigratePreRowSaveEvent $event) {
    $row = $event->getRow();

    $using_drush = function_exists('drush_get_option');
    if ($using_drush && drush_get_option('migrate-debug-pre')) {
      // Starting with capital letter for variables since this is actually a label.
      $Source = $row->getSource();
      $Destination = $row->getDestination();

      // We use kint directly here since we want to support variable naming and CLI colors.
      kint_require();
      \Kint::dump($Source, $Destination);
    }
  }

  /**
   * Post Row Save Function for --migrate-debug.
   *
   * @param \Drupal\migrate\Event\MigratePostRowSaveEvent $event
   */
  public function debugRowPostSave(MigratePostRowSaveEvent $event) {
    $row = $event->getRow();

    $using_drush = function_exists('drush_get_option');
    if ($using_drush && drush_get_option('migrate-debug')) {
      // We use kint directly here since we want to support variable naming and CLI colors.
      $Source = $row->getSource();
      $Destination = $row->getDestination();
      $DestinationIDValues = $event->getDestinationIdValues();

      kint_require();
      \Kint::dump($Source, $Destination, $DestinationIDValues);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[MigrateEvents::PRE_ROW_SAVE][] = ['debugRowPreSave'];
    $events[MigrateEvents::POST_ROW_SAVE][] = ['debugRowPostSave'];
    return $events;
  }

}
