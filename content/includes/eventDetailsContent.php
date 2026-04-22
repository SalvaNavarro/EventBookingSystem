<div class="event-details-container">

    <div class="event-details-content">
        <div class='event-details-image-container'>

            <img src='<?php echo $fullPath ?>' alt='<?php echo $imageAlt ?>'>
            <div class='event-details-title'>
                <h1><?php echo $eventTitle ?></h1>
                <h3><?php echo $eventSpeaker ?></h3>
                <h4 class='event-date'><?php echo $formattedDate ?></h4>
            </div>

        </div>
        <div class='event-details-description'>

            <p class='event-description'><?php echo $description ?></p>

        </div>
    </div>

    <div class="event-booking-container">
        <div class="event-booking">

            <h2>Book this event</h2>
            <h4><?php echo $eventTitle ?><span id='booking-talk-title'></span></h4>
            <h5><?php echo $eventSpeaker ?></h5>
            <p id='booking-talk-date'><?php echo $formattedDate ?>, £<?php echo $eventPrice ?></p>

            <form method="post" action="bookingProcess.php">

                <label for="people">Number of people (if +10 please email us):</label><br>
                <input type="number" name="people" id="people"><br>


                <label for="notes">Optional booking notes:</label><br>
                <textarea name="notes" placeholder="Message..." maxlength="100" id="notes"></textarea>

                <input type="submit" value="Submit booking" class="form-button">

            </form>

            <p class="non-member-note">Not a member? <a href="register.php">Register now.</a></p>

        </div>

    </div>

</div>