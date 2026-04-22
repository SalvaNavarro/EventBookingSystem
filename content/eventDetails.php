<!-- start -->
<?php
session_start();

require_once "functions/functions.php";

// check for session timeout
checkSessionTimeout();

echo makePageStart("Event Details");
echo makeHeader();

?>

<!-- page content -->
<main>

    <?php

        // get current eventID and price for further processing
        $currentEventDetails = getCurrentEventDetails();
        setSession('eventID', $currentEventDetails['id']);
        setSession('price', $currentEventDetails['price']);

        echo makeEventDetails();
        echo makeRelatedTalks(4);

    ?>

</main>

<!-- end -->
<?php

echo makeFooter();
echo makePageEnd();

?>