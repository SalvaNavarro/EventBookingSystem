<div class="hero-row">
    <div class="hero-text-container">
        <h3>The London Forum of Technology</h3>
        <h1><?php echo $eventTitle ?></h1>
        <h2><?php echo $eventSpeaker ?></h2>
        <h4 id="hero-event-date"><?php echo $formattedDate ?></h4>
        <p class="hero-event-description"><?php echo $description ?></p>
        <div class="hero-call-to-action">
            <a href="eventDetails.php?eventID=<?php echo $id ?>" class="button-link">
                <p>Book Now</p>
            </a>
            <p>...and get a <strong>free signed poster!</strong></p>
        </div>
    </div>
    <div class="hero-image-container">
        <img src="<?php echo $fullPath ?>" alt="image">
    </div>
</div>