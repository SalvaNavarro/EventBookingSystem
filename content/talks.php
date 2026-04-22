<!-- start -->
<?php
session_start();

require_once "functions/functions.php";

// check for session timeout
checkSessionTimeout();

echo makePageStart("Talks");
echo makeHeader();

?>

<!-- page content -->
<main>
    <?php

    echo makeAllUpcomingEvents(12);
    if (!checkLogin()) {
        echo makeCallToRegister();
    }

    ?>
</main>

<!-- end -->
<?php

echo makeFooter();
echo makePageEnd();

?>