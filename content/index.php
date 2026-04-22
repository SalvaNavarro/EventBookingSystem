<!-- start -->
<?php
session_start();

require_once "functions/functions.php";

// check for session timeout
checkSessionTimeout();

echo makePageStart("Home");
echo makeHeader();

?>

<!-- page content -->
<main>
    <?php

    echo makeHeroRow();
    echo makeUpcomingEvents(6);
    echo makePastEvents(4);
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