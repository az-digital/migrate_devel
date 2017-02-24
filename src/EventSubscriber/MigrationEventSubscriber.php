<?php

namespace Drupal\migrate_devel\EventSubscriber;

use Drupal\migrate\Event\MigrateEvents;
use Drupal\migrate\Event\MigratePostRowSaveEvent;
use Drupal\migrate\Event\MigratePreRowSaveEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 *  MigrationEventSubscriber for Debugging Migrations
 */
class MigrationEventSubscriber implements EventSubscriberInterface {
  /**
   * Pre Row Save Function
   * @param \Drupal\migrate\Event\MigratePreRowSaveEvent $event
   */
  public function debugRowPreSave(MigratePreRowSaveEvent $event) {
    $row = $event->getRow();

    if (function_exists('drush_get_option') && drush_get_option('migrate-debug-pre')) {
      $Source = $row->getSource();
      $Destination = $row->getDestination();

      kint_require();
      \Kint::dump($Source, $Destination);
    }
  }

  /**
   * Post Row Save Function
   * @param \Drupal\migrate\Event\MigratePostRowSaveEvent $event
   */
  public function debugRowPostSave(MigratePostRowSaveEvent $event) {
    $row = $event->getRow();

    if (function_exists('drush_get_option') && drush_get_option('migrate-debug')) {
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
