# Migrate Devel

Adds new options to `drush migrate-import` which 
allows developers to debug their migrations.

`drush migrate-import` comes from either the 
[migrate_tools](https://www.drupal.org/project/migrate_tools) or the 
[migrate_run](https://www.drupal.org/project/migrate_run) modules.

Currently uses Kint (from devel) directly to print out debug information 
instead of devel in order to take advantage of 
cli coloring and named variable debugging.

Options are:

* `--migrate-debug` - Prints out rows as they run. 
* `--migrate-debug-pre` - Same as above before the process is run on the row.
