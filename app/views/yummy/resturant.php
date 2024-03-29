<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/resturant.css">
    <link rel="stylesheet" href="/css/yum.css">
</head>
<body>
<div class="div">
<?php
if ($restaurantDetails !== null) {
  $picture = $restaurantDetails->getPicture();
  var_dump($picture);
  if(empty($picture) || is_null($picture)) {
      $picture = "default.jpg";
  } else {
      $picture = htmlspecialchars($picture);
  }
} else {
  $picture = "default.jpg";
}
?>
<img src="/img/<?= $picture ?>" class="img"/>
  <div class="div-2">
    <?php echo $contentData[0]['content']?>
    <?php echo $contentData[1]['content']?>
  </div>
</div>

<section class="cuisine-container">
  <img src="/img/<?php echo $contentData[2]['image']?>" alt="French cuisine" class="cuisine-image" />
  <?php echo $contentData[2]['content']?>
</section>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-3 mb-4">
      <img src="/img/<?php echo $contentData[3]['image']?>" alt="Caviar dish" class="img-fluid">
      <div style="background-color: #ffffff; padding: 10px; margin-top: 10px;">
        <?php echo $contentData[3]['content']?>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <img src="/img/<?php echo $contentData[4]['image']?>" alt="Le dîner dish" class="img-fluid">
      <div style="background-color: #ffffff; padding: 10px; margin-top: 10px;">
       <?php echo $contentData[4]['content']?>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <img src="/img/<?php echo $contentData[5]['image']?>" alt="Le déjeuner dish" class="img-fluid">
      <div style="background-color: #ffffff; padding: 10px; margin-top: 10px;">
      <?php echo $contentData[5]['content']?>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <img src="/img/<?php echo $contentData[6]['image']?>" alt="Le repas dish" class="img-fluid">
      <div style="background-color: #ffffff; padding: 10px; margin-top: 10px;">
        <?php echo $contentData[6]['content']?>
      </div>
    </div>
  </div>
</div>

<div class="restaurant-info-wrapper">
  <div class="restaurant-info">
    <div class="restaurant-image-container">
      <img src="/img/<?php echo $contentData[7]['image']?>" alt="Restaurant Picture" class="responsive-image"> <!-- Renamed class for the image -->
    </div>
    <div class="restaurant-content">
      <?php echo $contentData[7]['content'] ?>
      <div class="restaurant-rating">
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
        <span class="star">&#9733;</span>
      </div>
      <?php echo $contentData[8]['content'] ?>
      <div class="restaurant-contact">
        <div class="restaurant-address">
          <p><?php echo htmlspecialchars($restaurantDetails->getLocation())?></p>
        </div>
        <div class="restaurant-phone">
          <p><?php echo htmlspecialchars($restaurantDetails->getStartDate())?></p>
        </div>
        <div class="restaurant-email">
          <p><?php echo htmlspecialchars($restaurantDetails->getEndDate())?></p> 
        </div>
        <?php echo $restaurantDetails->getPrice()?>
      </div>
    </div>
  </div>
</div>



<div class="container-table mt-5">
  <div class="table-wrapper">
    <table class="table table-dark">
      <thead>
        <tr>
          <th scope="col">TimeSlots</th>
          <th scope="col">Ticket ID</th>
          <th scope="col">Date</th>
          <th scope="col">Time</th>
          <th scope="col">Quantity</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($timeslots as $index => $ticket): ?>
          <tr>
              <th scope="row"><?php echo $index + 1; ?></th>
              <td><?php echo htmlspecialchars($ticket->getTicketId()); ?></td>
              <td><?php echo htmlspecialchars($ticket->getTicketDate()); ?></td>
              <td><?php echo htmlspecialchars($ticket->getTicketTime()); ?></td>
              <td><?php echo htmlspecialchars($ticket->getQuantity()); ?></td>
              <td>
              <button class="btn btn-primary reserve-btn" data-toggle="modal" data-target="#reservationModal" data-ticketid="<?= htmlspecialchars($ticket->getTicketId()); ?>">
                Reserve
              </button>
              </td>
          </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>


<?php echo $contentData[9]['content']?>
<div class="container mt-5">
  <div class="row">
    <div class="col-md-4 mb-4">
      <img src="/img/<?php echo $contentData[9]['image']?>" alt="Image 1" class="img-fluid">
    </div>
    <div class="col-md-4 mb-4">
      <img src="/img/<?php echo $contentData[9]['image']?>" alt="Image 2" class="img-fluid">
    </div>
    <div class="col-md-4 mb-4">
      <img src="/img/<?php echo $contentData[9]['image']?>" alt="Image 3" class="img-fluid">
    </div>
  </div>
</div>

<?php echo $contentData[10]['content']?>
<div class="picture-location">
  <img src="/img/<?php echo $contentData[10]['image']?>" alt="Location Picture" class="img-location">
</div>


<div id="reservationModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ticket Reservation</h5>
                <button type="button" class="btn-close close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reservationForm">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                      <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                      </div>
                    <div class="form-group">
                        <label for="specialRequest">Special Request</label>
                        <textarea class="form-control" id="specialRequest" name="specialRequest"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                    </div>
                    <div id="loginMessage" style="display:none; color:red; margin-top: 20px;">
                      Please log in to make a reservation. It costs 10 euros.
                    </div>
                    <input type="hidden" id="startTime" name="startTime" value="<?php echo $restaurantDetails->getStartDate()?>">
                    <input type = "hidden" id="eventId" name="eventId" value="<?php echo $restaurantDetails->getEventId()?>">
                    <input type="hidden" id="ticketId" name="ticketId" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submitReservation()">Submit Reservation</button>
            </div>
        </div>
    </div>
</div>





<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.reserve-btn').forEach(button => {
        button.addEventListener('click', function() {
            const ticketId = this.getAttribute('data-ticketid');
            document.getElementById('ticketId').value = ticketId;
        });
    });

    $('#reservationModal').on('hidden.bs.modal', function () {
        document.getElementById('loginMessage').style.display = 'none';
        resetFormAndErrors();
    });
});

function closeModal() {
    $('#reservationModal').modal('hide'); 
}

function resetFormAndErrors() {
    document.querySelectorAll('.form-control').forEach(element => {
        element.style.borderColor = "";
    });
    document.getElementById('reservationForm').reset();
}

function submitReservation() {
    event.preventDefault();

    const reservationData = {
        firstName: document.getElementById('firstName').value.trim(),
        lastName: document.getElementById('lastName').value.trim(),
        phoneNumber: document.getElementById('phoneNumber').value.trim(),
        email: document.getElementById('email').value.trim(),
        address: document.getElementById('address').value.trim(),
        specialRequest: document.getElementById('specialRequest').value.trim(),
        quantity: parseInt(document.getElementById('quantity').value, 10),
        startTime: document.getElementById('startTime').value,
        ticketId: document.getElementById('ticketId').value,
    };

    let validationPassed = true;

    Object.keys(reservationData).forEach(key => {
        const element = document.getElementById(key);
        if (!reservationData[key] || (key === 'quantity' && isNaN(reservationData[key]))) {
            element.style.borderColor = 'red';
            validationPassed = false;
        } else {
            element.style.borderColor = '';
        }
    });

    if (!validationPassed) return;

    fetch('/reservation/restaurant', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(reservationData),
    })
    .then(response => response.json())
    .then(data => handleResponse(data))
    .catch(error => console.error('Fetch error:', error));
}

function handleResponse(data) {
    if (data.login_required) {
        document.getElementById('loginMessage').style.display = 'block';
    } else if (data.success && data.paymentUrl) {
        window.location.href = data.paymentUrl;
    } else if (data.errors) {
        alert('Please correct the errors and try again.');
    } else {
        alert('An unexpected error occurred. Please try again later.');
    }
}

function showLoginMessage() {
    const messageElement = document.getElementById('loginMessage');
    if (messageElement) {
        messageElement.style.display = 'block';
        messageElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}
</script>




<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.9/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<?php include __DIR__ . '/../general_views/footer.php'; ?>

</body>
</html>