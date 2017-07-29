<?php
  // set the blockland version that the master server will be providing for.
  // default: 20
  define('SERVER_VERSION', 20);

  // the settings below don't really need to be changed, but are provided here just in case.

  // set the max time required in seconds for a server to post back to keep its master server listing.
  // default: 315
  define('SERVER_TIMEOUT', 315);
  
  // set the name of the sqlite database file.
  // default: Servers.db
  define('SERVER_DATABASE', 'Servers.db');
?>