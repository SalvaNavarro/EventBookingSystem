<div class='talk-item'>
    <a href='eventDetails.php?eventID=<?php echo $id ?>' class='talk-link'>
        <h4><?php echo $eventTitle ?></h4>
        <h5><?php echo $eventSpeaker ?></h5>
    </a>
    <p class='event-date'><?php echo $formattedDate ?></p>
    <a href='eventDetails.php?eventID=<?php echo $id ?>' class='talk-image-link'>
        <img src='<?php echo $fullPath ?>' alt="<?php echo $imageAlt ?>">
    </a>
    <p class='event-description'><?php echo $description ?></p>
</div>