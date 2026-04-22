<?php
session_start();

require_once "functions/functions.php";

// check for session timeout
checkSessionTimeout();

// start
echo makePageStart("Credits");
echo makeHeader();

// main content
echo makeCreditsPage();

// end
echo makeFooter();
echo makePageEnd();

?>
