<?php
session_start();

require_once "functions/functions.php";

// check for session timeout
checkSessionTimeout();

// start
echo makePageStart("Wireframes");
echo makeHeader();

// main content
echo makeWireframesPage();

// end
echo makeFooter();
echo makePageEnd();

?>
