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
<main class="narrow-page-container">
    <div class="form-pad">
        <h2 class="form-pad-title">Logout</h2>
        <?php
        logOut();
        ?>
    </div>
</main>

<!-- end -->
<?php

echo makeFooter();
echo makePageEnd();

?>
