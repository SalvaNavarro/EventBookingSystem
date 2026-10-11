<?php

// local database credentials for development
define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");
define("DB_DATABASE", "localPE7045");

// global paths
define("IMAGE_PATH", "../assets/images/speakers/");

// global constants for queries
define("UPCOMING_TALKS", "`event_date` >= CURDATE() ORDER BY `event_date`");
define("PAST_TALKS", "`event_date` < CURDATE() ORDER BY `event_date`");

?>
