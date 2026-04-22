<!-- start -->
<?php
session_start();

require_once "functions/functions.php";

// check user is logged in, redirect home if not
redirectHome(checkLogin());

// check for session timeout
checkSessionTimeout();

echo makePageStart("My Account");
echo makeHeader();

?>

<!-- page content -->
<main>
    <div class="other-page-container">
        <?php

        $userID = $_SESSION['userID'];
        echo makeBookingList($userID);
        echo makeUserDetails();

        ?>
    </div>
</main>

<!-- end -->
<?php

echo makeFooter();
echo makePageEnd();

?>
