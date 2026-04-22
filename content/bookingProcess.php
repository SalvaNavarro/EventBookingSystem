<!-- start -->
<?php
session_start();

require_once "functions/functions.php";

// standard redirect replaced with conditional statement below on this page
// redirectHome(checkLogin());

// check for session timeout
checkSessionTimeout();

echo makePageStart("Booking");
echo makeHeader();

?>

<!-- page content -->
<main class="narrow-page-container">
    <div class="form-pad">
        <h2 class="form-pad-title">Booking</h2>
        <?php

        // check user is logged in, redirect to login page if not
        if (!checkLogin()) {
            $output = <<<MESSAGES
        <ul class="form-feedback">
            <li>Please log in to book events.</li>
            <li>Redirecting you to login page...</li>
        </ul>
MESSAGES;
            echo $output;
            header('Refresh: 2; url=login.php');
        }

        else {
            bookingFormAssessment();
        }

        ?>
    </div>
</main>

<!-- end -->
<?php

echo makeFooter();
echo makePageEnd();

?>

