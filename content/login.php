<!-- start -->
<?php
session_start();

require_once "functions/functions.php";

// check for session timeout
checkSessionTimeout();

echo makePageStart("Login");
echo makeHeader();

?>

<!-- page content -->
<main class="narrow-page-container">
    <?php

    echo makeLoginPage();

    ?>
</main>

<!-- end -->
<?php

echo makeFooter();
echo makePageEnd();

?>