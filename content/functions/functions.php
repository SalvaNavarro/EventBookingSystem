<?php

require_once "config.php";

// CONNECTION
function getConnection() {
    $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    if ($conn === false) {
        echo "Cannot connect to DB.";
    }
    return $conn;
}

// GENERAL UTILITY FUNCTIONS
function splitDate($dateString) {

    // based on dates from MySQL database in the format YYYY-MM-DD HH:MM:SS
    $day = substr($dateString, 8,2);
    $month = substr($dateString, 5,2);
    $year = substr($dateString, 2,2);
    $hour = substr($dateString, 11,5);
    // concatenate reformatted date string
    $date = $day."/".$month."/".$year." at ".$hour;

    return $date;
}

function splitDateShort($dateString) {

    // based on dates from MySQL database in the format YYYY-MM-DD HH:MM:SS
    $day = substr($dateString, 8,2);
    $month = substr($dateString, 5,2);
    $year = substr($dateString, 2,2);
    // concatenate reformatted date string
    $date = $day."/".$month."/".$year;

    return $date;
}


function isDateValid($dateString) {

    // based on dates from MySQL database in the format YYYY-MM-DD HH:MM:SS
    $day = substr($dateString, 8,2);
    $month = substr($dateString, 5,2);
    $year = substr($dateString, 0,4);

    // check date
    $valid = checkdate($month, $day, $year);

    //return validation flag
    return $valid;

}

// SHARED CONTENT GENERATION FUNCTIONS
function getPlainHTML($includeFile) {
    ob_start();
    include "includes/".$includeFile;
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function makePageStart($pageTitle) {
    ob_start();
    include "includes/pageStart.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function makePageEnd() {
    return getPlainHTML("pageEnd.php");
}

function makeHeader() {
    return getPlainHTML("header.php");
}

function makeFooter() {
    return getPlainHTML("footer.php");
}

function makeCallToRegister() {
    return getPlainHTML("registerSection.php");
}

function makeRegisterSuccess() {
    return getPlainHTML("registerSuccess.php");
}

function heroRow($eventSpeaker, $eventTitle, $formattedDate, $description, $id, $fullPath) {
    ob_start();
    include "includes/heroRow.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function getTalkItems($eventSpeaker, $eventTitle, $formattedDate, $description, $id, $fullPath, $imageAlt) {
    ob_start();
    include "includes/talkItem.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function getTalkItemsSmall($eventTitle, $eventSpeaker, $formattedDate, $description, $id, $fullPath, $imageAlt) {
    ob_start();
    include "includes/talkItemSmall.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function getPastTalkItemsSmall($eventTitle, $eventSpeaker, $formattedDate, $description, $id, $fullPath, $imageAlt) {
    ob_start();
    include "includes/talkItemPast.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function getUpcomingTalks($talkItems) {
    ob_start();
    include "includes/upcomingTalks.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function getAllUpcomingTalks($talkItems) {
    ob_start();
    include "includes/allUpcomingTalks.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function getPastTalks($talkItems) {
    ob_start();
    include "includes/pastTalks.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function getRelatedTalks($talkItems) {
    ob_start();
    include "includes/relatedTalks.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function getEventDetails($eventSpeaker, $eventTitle, $formattedDate, $description, $fullPath, $eventPrice, $imageAlt) {
    ob_start();
    include "includes/eventDetailsContent.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function getBookingItem($eventID, $eventTitle, $eventDate, $people, $cost, $notes) {
    ob_start();
    include "includes/bookingItem.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function getBookingList($bookingItems) {
    ob_start();
    include "includes/bookingList.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function getUserDetails($forename, $surname, $email, $id, $dob) {
    ob_start();
    include "includes/userDetails.php";
    $content = ob_get_clean();
    $content .="\n";
    return $content;
}

function validateScope ($scope) {

    // checks whether $scope is one of the predefined constants
    if ($scope != UPCOMING_TALKS && $scope != PAST_TALKS) {
        echo "Search scope error.";
        header("Refresh: 1; url=index.php");
        exit;
    }

}

// MAIN SQL QUERYING FUNCTIONS PROTECTED AGAINST SQL INJECTION
function getEvents($number, $scope) {

    validateScope($scope);

    $conn = getConnection();
    $sql = "SELECT * FROM events WHERE ".$scope." LIMIT 0, ?";

    // protection against SQL injection
    $stmt = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i", $number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $speaker, $title, $description, $date, $price, $image, $imageAlt);

    // array of associative arrays to store all data retrieved
    $events = [];

    while (mysqli_stmt_fetch($stmt)) {

            $events[] = [
                "id" => $id,
                "speaker" => $speaker,
                "title" => $title,
                "description" => $description,
                "date" => splitDate($date), // formatting the date for readability
                "price" => $price,
                "image" => IMAGE_PATH.$image,
                "imageAlt" => $imageAlt
            ];

    }

    // free up memory and close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    return $events;

}

function getSingleEvent($eventID) {

    $conn = getConnection();
    $sql = "SELECT * FROM events WHERE eventID=?";

    // protection against SQL injection
    $stmt = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"i", $eventID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $speaker, $title, $description, $date, $price, $image, $imageAlt);

    if (mysqli_stmt_fetch($stmt)) {

        $eventDetails = [
            "id" => $id,
            "speaker" => $speaker,
            "title" => $title,
            "description" => $description,
            "date" => splitDate($date), // formatting the date for readability
            "price" => $price,
            "image" => IMAGE_PATH.$image,
            "imageAlt" => $imageAlt
        ];

        return $eventDetails;

    }

    // free up memory and close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}

function getUserBookings($customerID) {

    $conn = getConnection();
    $sql = "SELECT `bookingID`, `eventID`, `number_people`, `total_booking_cost`, `booking_notes` FROM booking WHERE customerID=?";

    // protection against SQL injection
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt,"i", $customerID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $bookingID, $eventID, $people, $cost, $notes);

    // array of associative arrays to store all data retrieved
    $bookings = [];

    while (mysqli_stmt_fetch($stmt)) {

        $bookings[] = [
            "bookingID" => $bookingID,
            "eventID" => $eventID,
            "people" => $people,
            "cost" => $cost,
            "notes" => $notes
        ];

    }

    // free up memory and close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    return $bookings;

}

function getUserInfo($customerID) {

    $conn = getConnection();
    $sql = "SELECT `customer_forename`, `customer_surname`, `customer_email`, `customerID`, `date_of_birth` FROM customers WHERE customerID=?";

    // protection against SQL injection
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt,"i", $customerID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $forename, $surname, $email, $id, $dob);

    if (mysqli_stmt_fetch($stmt)) {

        $userDetails = [
            "forename" => $forename,
            "surname" => $surname,
            "email" => $email,
            "id" => $id,
            "dob" => $dob
        ];

    }

    // free up memory and close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    return $userDetails;

}

// CONTENT RETRIEVAL FUNCTIONS
function makeWireframesPage() {
    return getPlainHTML("wireframesContent.php");
}

function makeCreditsPage()
{
    return getPlainHTML("creditsContent.php");
}

function makeLoginPage() {
    return getPlainHTML("loginContent.php");
}

function makeRegisterPage() {
    return getPlainHTML("registerContent.php");
}

// MAIN CONTENT GENERATION
function makeHeroRow() {

    $nextEvent = getEvents(1, UPCOMING_TALKS);

    $id = $nextEvent[0]["id"];
    $title = $nextEvent[0]["title"];
    $speaker = $nextEvent[0]["speaker"];
    $description = $nextEvent[0]["description"];
    $date = $nextEvent[0]["date"];
    $price = $nextEvent[0]["price"];
    $image = $nextEvent[0]["image"];

    return heroRow($speaker, $title, $date, $description, $id, $image);

}

function makeUpcomingEvents($number)
{

    $events = getEvents($number, UPCOMING_TALKS);
    $outputArray = [];

    foreach ($events as $event) {

        $id = $event["id"];
        $title = $event["title"];
        $speaker = $event["speaker"];
        $description = $event["description"];
        $date = $event["date"];
        $price = $event["price"];
        $image = $event["image"];
        $imageAlt = $event["imageAlt"];

        $content = getTalkItems($speaker, $title, $date, $description, $id, $image, $imageAlt);
        $content .= "\n";
        $outputArray[] = $content;
    }

    $talkItems = implode("", $outputArray);
    $talks = getUpcomingTalks($talkItems);
    return $talks;

}

function makePastEvents($number) {

    $events = getEvents($number, PAST_TALKS); // replace upcoming talks with past talks
    $outputArray = [];

    foreach ($events as $event) {

        $id = $event["id"];
        $title = $event["title"];
        $speaker = $event["speaker"];
        $description = $event["description"];
        $date = $event["date"];
        $price = $event["price"];
        $image = $event["image"];
        $imageAlt = $event["imageAlt"];

        $content = getPastTalkItemsSmall($title, $speaker, $date, $description, $id, $image, $imageAlt);
        $content .= "\n";
        $outputArray[] = $content;
    }

    $talkItems = implode("", $outputArray);
    $talks = getPastTalks($talkItems);
    return $talks;

}

function makeAllUpcomingEvents($number)
{

    $events = getEvents($number, UPCOMING_TALKS);
    $outputArray = [];

    foreach ($events as $event) {

        $id = $event["id"];
        $title = $event["title"];
        $speaker = $event["speaker"];
        $description = $event["description"];
        $date = $event["date"];
        $price = $event["price"];
        $image = $event["image"];
        $imageAlt = $event["imageAlt"];

        $content = getTalkItems($speaker, $title, $date, $description, $id, $image, $imageAlt);
        $content .= "\n";
        $outputArray[] = $content;
    }

    $talkItems = implode("", $outputArray);
    $talks = getAllUpcomingTalks($talkItems);
    return $talks;

}

function makeRelatedTalks($number)
{

    $events = getEvents($number, UPCOMING_TALKS);
    $outputArray = [];

    foreach ($events as $event) {

        $id = $event["id"];
        $title = $event["title"];
        $speaker = $event["speaker"];
        $description = $event["description"];
        $date = $event["date"];
        $price = $event["price"];
        $image = $event["image"];
        $imageAlt = $event["imageAlt"];

        $content = getTalkItemsSmall($title, $speaker, $date, $description, $id, $image, $imageAlt);
        $content .= "\n";
        $outputArray[] = $content;
    }

    $talkItems = implode("", $outputArray);
    $talks = getRelatedTalks($talkItems);
    return $talks;

}

function makeEventDetails() {

    // get events
    if (array_key_exists('eventID',$_REQUEST)) {

        $eventID = $_REQUEST['eventID'];
        $eventDetails = getSingleEvent($eventID);

        //retrieve event details
        $id = $eventDetails["id"];
        $title = $eventDetails["title"];
        $speaker = $eventDetails["speaker"];
        $description = $eventDetails["description"];
        $date = $eventDetails["date"];
        $price = $eventDetails["price"];
        $image = $eventDetails["image"];
        $imageAlt = $eventDetails["imageAlt"];

        $content = getEventDetails($speaker, $title, $date, $description, $image, $price, $imageAlt); // refer to "includes/eventDetailsContent.php"
        $content .="\n";
        return $content;

    }

    //if the 'eventID' is not found in the $_REQUEST array (i.e. the user has accessed the page directly)
    else {
        //Redirect back to home page
        header('Location: index.php');
        exit;
    }

}

function makeBookingList($userID)
{

    $bookings = getUserBookings($userID);
    $outputArray = [];

    foreach ($bookings as $booking) {

        $eventID = $booking['eventID'];
        $people = $booking['people'];
        $cost = $booking['cost'];
        $notes = $booking['notes'];

        // include key information about the event from the events table
        $eventDetails = getSingleEvent($eventID);
        $eventTitle = $eventDetails["title"];
        $eventDate = $eventDetails["date"];

        $content = getBookingItem($eventID, $eventTitle, $eventDate, $people, $cost, $notes);
        $content .= "\n";
        $outputArray[] = $content;

    }

    $bookingItems = implode("", $outputArray);
    $bookingList = getBookingList($bookingItems);
    return $bookingList;

}

function makeUserDetails() {

    // get details
    if (array_key_exists('userID',$_SESSION)) {

        $userID = $_SESSION['userID'];
        $userDetails = getUserInfo($userID);

        //retrieve user details
        $forename = $userDetails["forename"];
        $surname = $userDetails["surname"];
        $email = $userDetails["email"];
        $id = $userDetails["id"];
        $dob = splitDateShort($userDetails["dob"]);

        $content = getUserDetails($forename, $surname, $email, $id, $dob); // refer to "includes/userDetails.php"
        $content .="\n";
        return $content;

    }

    //if the 'eventID' is not found in the $_REQUEST array (i.e. the user has accessed the page directly)
    else {
        //Redirect back to home page
        header('Location: index.php');
        exit;
    }

}

// REGISTER FORM VALIDATION AND PROCESSING FUNCTIONS
function checkEmailExists($email) {

    // connect to database and set statement
    $conn = getConnection();
    $sql = "SELECT EXISTS(SELECT * FROM customers WHERE customer_email=?); ";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $result);
    }

    if (mysqli_stmt_fetch($stmt)) {
        $exists = $result;
    }

    // close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // return email existence flag
    return $exists;

}

function validateRegisterForm() {

    // create errors and input arrays
    $errors = array();
    $input = array();

    // declare variables
    $input['forename'] = array_key_exists('forename', $_REQUEST)
        ? $_REQUEST['forename'] : null;
    $input['forename'] = trim($_REQUEST['forename']);

    $input['surname'] = array_key_exists('surname', $_REQUEST)
        ? $_REQUEST['surname'] : null;
    $input['surname'] = trim($_REQUEST['surname']);

    $input['email'] = array_key_exists('email', $_REQUEST)
        ? $_REQUEST['email'] : null;
    $input['email'] = trim($_REQUEST['email']);

    $input['dob'] = array_key_exists('dob', $_REQUEST)
        ? $_REQUEST['dob'] : null;
    $input['dob'] = trim($_REQUEST['dob']);

    $input['password'] = array_key_exists('password', $_REQUEST) ? $_REQUEST['password'] : null;
    $input['password'] = trim($_REQUEST['password']);

    $input['confirm-password'] = array_key_exists('confirm-password', $_REQUEST) ? $_REQUEST['confirm-password'] : null;
    $input['confirm-password'] = trim($_REQUEST['confirm-password']);

    // check if email already exists in database, sanitise it first
    $input['email'] = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
    $emailExists = checkEmailExists($input['email']);

    // validation
    foreach ($input as $inputItem){
        if (empty($inputItem)) {
            $errors[] = "Please fill in all fields.";
            break;
        }
    }

    if (strlen($input['forename']) > 50 || strlen($input['surname']) > 50) {
        $errors[] = "Forename/Surname should be less than 50 characters.";
    }

    $stringPattern = "/^[a-zA-Z]+$/";
    if (!preg_match($stringPattern, $input['forename'])
        || !preg_match($stringPattern, $input['surname'])) {
        $errors[] = "Invalid forename or surname.";
    }

    $datePattern = "/^\d{4}-\d{2}-\d{2}$/";
    if (!preg_match($datePattern, $input['dob']) or !isDateValid($input['dob'])) {
        $errors[] = "Please use a valid date with YYYY-MM-DD format.";
    }

    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen($input['password']) < 8 || strlen($input['password']) > 12) {
        $errors[] = "Password must be between 8 and 12 characters long.";
    }

    if ($input['password'] != $input['confirm-password']) {
        $errors[] = "Your passwords don't match.";
    }

    if ($emailExists) {
        $errors[] = "Email already in use. Please use another one.";
    }

    // returning input and errors array
    return array($input, $errors);

}
/* OLD VERSION OF SHOWERRORS
function showErrors($errors) {

    $output = "";
    foreach ($errors as $currentErrorMessage){
        $output .= $currentErrorMessage;
    }
    $output .= <<<BUTTON
        <a href="javascript:history.back()">
            <button class="form-button">Go Back</button>
        </a>
BUTTON;

    return $output;

}
*/
function showErrors($errors) {

    $errorList = "";
    foreach ($errors as $currentErrorMessage){
        $errorItem = "<li >" . $currentErrorMessage . "</li>";
        $errorList .= $errorItem;
    }
    $output = <<<MESSAGES
        <ul class="form-feedback">
            $errorList
        </ul>
        <a href="javascript:history.back()">
            <button class="form-button">Go Back</button>
        </a>
MESSAGES;

    return $output;

}

function showConfirmation($confirmationMsg) {

    $messageList = "";
    foreach ($confirmationMsg as $currentConfirmationMsg){
        $messageItem = "<li >" . $currentConfirmationMsg . "</li>";
        $messageList .= $messageItem;
    }
    $output = <<<MESSAGES
        <ul class="form-feedback">
            $messageList
        </ul>
MESSAGES;

    return $output;

}

function processRegisterForm($input) {

    // code to process form input, SQL statements, add sanitisation code etc.
    $forename = htmlspecialchars($input['forename']);
    $surname = htmlspecialchars($input['surname']);
    $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($input['password'], PASSWORD_DEFAULT);
    $dob = date('Y-m-d', strtotime($input['dob']));

    $conn = getConnection();
    $sql = "INSERT INTO customers (`customer_forename`, `customer_surname`, `customer_email`, `password_hash`, `date_of_birth`) VALUES (?, ?, ?, ?, ?); ";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssss", $forename, $surname, $email, $password, $dob );
        $queryResult = mysqli_stmt_execute($stmt);
    }

    if ($queryResult) {
        return makeRegisterSuccess();
    }

    // close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}

function registerFormAssessment() {

    list($input, $errors) = validateRegisterForm();

    if ($errors) {
        echo showErrors($errors);
    }

    else {
        echo processRegisterForm($input);
    }

}

// SESSION FORM PROCESSING AND FUNCTIONS
function validateLogonForm() {

    // create errors and input arrays (email used as username for this case)
    $errors = array();
    $input = array();

    $input['email'] = array_key_exists('email', $_REQUEST) ? $_REQUEST['email'] : null;
    $input['email'] = trim($_REQUEST['email']);

    $input['password'] = array_key_exists('password', $_REQUEST) ? $_REQUEST['password'] : null;
    $input['password'] = trim($_REQUEST['password']);

    // validation
    foreach ($input as $inputItem){
        if (empty($inputItem)) {
            $errors[] = "Please fill in all fields.";
            break;
        }
    }

    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($errors)) {

        // sanitising input email (password will be hashed)
        $input['email'] = filter_var($input['email'], FILTER_SANITIZE_EMAIL);

        // create connection and set up prepared statement
        $conn = getConnection();
        $sql = "SELECT customerID, password_hash FROM customers WHERE customer_email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $input['email']);
            mysqli_stmt_execute($stmt);

            $queryresult = mysqli_stmt_get_result($stmt);
            $userRow = mysqli_fetch_assoc($queryresult);

            //verify password
            if ($userRow) {

                $input['userID'] = $userRow['customerID'];
                $passwordHash = $userRow['password_hash'];
                $validPassword = password_verify($input['password'], $passwordHash);

            }

            if ($validPassword) {
                $confirmationMsg = [];
                $confirmationMsg[] = "Your credentials are correct, welcome back!";
                $confirmationMsg[] = "Redirecting to home page...";
                echo showConfirmation($confirmationMsg);
                header('Refresh: 2; url=index.php');
            }

            else {
                $output = <<<MESSAGES
                    <ul class="form-feedback">
                        <li>Your email or password are not correct.</li>
                        <li>Please try it again.</li>
                    </ul>
                    <a href="javascript:history.back()">
                        <button class="form-button">Go Back</button>
                    </a>
MESSAGES;
                echo $output;
            }

        }

        // close statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

    }

    return array($input, $errors);
}

function processLogonForm() {

    list($input, $errors) = validateLogonForm();

    if ($errors) {
        echo showErrors($errors);
    }

    else {

        // set relevant values for $_SESSION array login flag and userID
        setSession('logged-in', true);
        setSession('userID', $input['userID']);
        // set session timeout
        setSession('session-start-time', time());

    }

}

function checkSessionTimeout() {
    if (isset($_SESSION['userID'])) {
        if (time() - $_SESSION['session-start-time'] > 1800){
            session_unset();
            session_destroy();
            echo "Logging out due to session timeout...redirecting to Home page.";
            header('Refresh: 2; url=index.php');
        }
    }
}

function setSession ($key, $value){
    $_SESSION[$key] = $value;
    return true;
}

function getSession($key) {
    $output = "";
    if (isset($_SESSION[$key])) {
        $output = $_SESSION[$key];
    }
    return $output;
}

function checkLogin() {

    $loginFlag = false;
    $login = getSession('logged-in');

    if ($login === true) {
        $loginFlag = true;
    }

    return $loginFlag;

}

function redirectHome($loginFlag) {

    if (!$loginFlag) {
        header('Location: index.php');
    }

}


function logOut() {
    session_unset();
    session_destroy();

    $output = <<<MESSAGES
        <ul class="form-feedback">
            <li>Logging out...redirecting to Home page.</li>
        </ul>
MESSAGES;
    echo $output;
    header('Refresh: 2; url=index.php');
}

// REGISTER FORM VALIDATION AND PROCESSING FUNCTIONS
function getCurrentEventDetails() {

    // get eventID and price
    $eventID = array_key_exists('eventID', $_REQUEST)
        ? $_REQUEST['eventID'] : null;

    if ($eventID === null) {
        echo "Event ID not found.";
    }

    else {
        // output details
        return getSingleEvent($eventID);
    }

}

function validateBookingForm() {

    // create errors and input arrays
    $errors = array();
    $input = array();

    // import customer ID from $_SESSION
    $input['userID'] = array_key_exists('userID', $_SESSION)
        ? $_SESSION['userID'] : null;

    $input['eventID'] = array_key_exists('eventID', $_SESSION)
        ? $_SESSION['eventID'] : null;

    $priceUnit = array_key_exists('price', $_SESSION)
        ? $_SESSION['price'] : null;

    // import data from booking form
    $input['people'] = array_key_exists('people', $_REQUEST)
        ? $_REQUEST['people'] : null;
    $input['people'] = trim($_REQUEST['people']);

    $input['notes'] = array_key_exists('notes', $_REQUEST)
        ? $_REQUEST['notes'] : null;
    $input['notes'] = trim($_REQUEST['notes']);

    $input['price'] = $priceUnit * $input['people'];

    // validation
    if (empty($input['people'])) {
        $errors[] = "Please indicate number of people.<br>";
    }

    if (is_numeric($input['people'])) {
        $input['people'] = intval($input['people']);
    }

    else {
        $errors[] = "Please use a numeric value.";
    }

    if ($input['people'] < 1) {
        $errors[] = "Please indicate a value between 1 and 10.";
    }

    if ($input['people'] > 10) {
        $errors[] = "Please email us for group booking (+10).";
    }

    // returning input and errors array
    return array($input, $errors);

}

function processBookingForm($input) {

    // declare variables and sanitise before sending to SQL statement
    $eventID = filter_var($input['eventID'], FILTER_SANITIZE_NUMBER_INT);
    $customerID = filter_var($input['userID'], FILTER_SANITIZE_NUMBER_INT);
    $numberPeople = filter_var($input['people'], FILTER_SANITIZE_NUMBER_INT);
    $totalPrice = filter_var($input['price'], FILTER_SANITIZE_NUMBER_FLOAT);
    $notes = htmlspecialchars($input['notes']);

    // create connection and set up prepared statement
    $conn = getConnection();
    $sql = "INSERT INTO booking (`eventID`, `customerID`, `number_people`, `total_booking_cost`, `booking_notes`) VALUES (?, ?, ?, ?, ?); ";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "iiids", $eventID, $customerID, $numberPeople, $totalPrice, $notes);
        mysqli_stmt_execute($stmt);
    }

    // close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}

function bookingFormAssessment() {

    list($input, $errors) = validateBookingForm();

    if ($errors) {
        echo showErrors($errors);
    }

    else {
        processBookingForm($input);
        $output = <<<MESSAGES
                    <ul class="form-feedback">
                        <li>Your booking has been successful, see you soon!</li>
                        <li>You may now check your bookings on your account.</li>
                    </ul>
                    <a href="myAccount.php" class="button-link">
                        <p>See Bookings</p>
                    </a>
MESSAGES;
        echo $output;
    }

}

?>