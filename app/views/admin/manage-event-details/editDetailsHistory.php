<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>
<h1 class="mb-4 text-center">Edit History Event Details</h1>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 col-md-6">
       
            
            <div class="card mb-3">
                <div class="card-header text-center" >
                    <u>Current Event Details</u>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($eventDetails->getName()) ?></h5>
                    <p class="card-text"><strong>Event ID:</strong> <?= htmlspecialchars($eventDetails->getEventId()) ?></p>
                    <p class="card-text"><strong>Date:</strong> <?= htmlspecialchars($eventDetails->getDate()) ?></p>
                    <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($eventDetails->getLocation()) ?></p>
                    <p class="card-text"><strong>Price:</strong> <?= htmlspecialchars($eventDetails->getPrice()) ?> </p>
                    <p class="card-text"><strong>Time:</strong> <?= htmlspecialchars($eventDetails->getTime()) ?></p>
                    <div class="mb-3 text-center">
                        <p class="card-text"><strong>Picture:</strong></p>
                        <img src="/../img/<?= htmlspecialchars($eventDetails->getPicture()) ?>" alt="Event Image" class="img-fluid" style="max-width: 100%; height: auto;">
                    </div>
                    <?Php /* Below use a popup modal similar to how I do it in the manage users page. */?>
                    <a href="edit-event.php?id=<?= htmlspecialchars($eventDetails->getEventId()) ?>" class="btn btn-primary">Edit Event Details</a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="card mb-3">
                <div class="card-header text-center">
                <u>Time Slots</u>
                </div>
                <div class="card-body">
      
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../general_views/footer.php'; ?>
