<!-- start -->
<?php
session_start();

require_once "functions/functions.php";

// check for session timeout
checkSessionTimeout();

echo makePageStart("Register");
echo makeHeader();

?>

<!-- page content -->
<main class="narrow-page-container">
    <?php

    echo makeRegisterPage();

    ?>
</main>

<!-- end -->
<?php

echo makeFooter();
echo makePageEnd();

?>