<?php

/**
 * @file
 * File for Drush Integration.
 */

/**
 * Implements hook_drush_help_alter().
 */
function migrate_devel_drush_help_alter(&$command) {
  if ($command['command'] == 'migrate-import') {
    $command['options']['migrate-debug'] = 'Enable Debug Mode';
    $command['options']['migrate-debug-pre'] = 'Enable Debug Mode (Before Row Save)';
  }
}
