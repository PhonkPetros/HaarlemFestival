<html>
<head>
    <style>
        body {
            background: url('/img/Music_img/Jazz.jpeg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        header {
            /* Your header styles go here */
        }

        #image-section {
            position: relative;
            min-height: 500px; /* Set a minimum height */
            overflow: hidden;
            background: url('/img/Music_img/image 100.png') no-repeat center center fixed;
            background-size: cover;
        }

        #slogan {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            color: white;
            text-align: center;
            width: 100%;
        }

        #top-artist-section {
            text-align: center;
            margin-top: 20px;
            margin-right: 20px;
        }

        .top-artist-heading {
            font-size: 24px;
            font-weight: bold;
            color: white;
            float: left;
            margin-right: 40px; /* Increase the margin to add more space */
        }

        .artist-images {
            width: 100%;
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 50px;
            margin-bottom: 20px;
        }

        .artist-images img {
            flex: 0 0 150px;
            height: 150px;
            border-radius: 75px;
           /* border: 5px solid #f00; */
            margin-right: 10px;
        }

        #events-section {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        #events-section h2 {
          color: white; /* Change the text color to white */
       } 

        #calendar-view {
            /* Add your styles for the calendar view here */
        }
    </style>
</head>
<body>
    <header>
        <!-- Your header content goes here -->
    </header>

    <div id="image-section">
        <div id="slogan">JAZZ ECLECTICA Haarlem's Melodic Tapestry Unveiled</div>
    </div>

    <!-- Your webpage content goes here -->

    <div id="top-artist-section">
        <div class="top-artist-heading">TOP JAZZ ARTISTS</div>
        <div class="artist-images">
            <!-- Add your round-shaped artist images here -->
            <img src="./img/Music_img/Ellipse 77.png" alt="Artist 1">
            <img src="./img/Music_img/Ellipse 82.png" alt="Artist 2">
            <img src="./img/Music_img/Ellipse 80.png" alt="Artist 3">
            <img src="./img/Music_img/Ellipse 63.png" alt="Artist 4">
            <!-- Duplicate an existing image to reduce the gap -->
            <img src="/img/Music_img/Ellipse 77.png" alt="Artist 1">
        </div>
    </div>

    <!-- New section for events and calendar view -->
    <div id="events-section">
        <h2>Upcoming Events</h2>
        <div id="calendar-view">
        <head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <title>Color Calendar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/color-calendar@1.0.5/dist/bundle.js"></script>
  <link rel="stylesheet" href="/css/theme-basic.min.css" />
  <link rel="stylesheet" href="/css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet" />
</head> 

<body>
  <section class="container calender-bg">
    <div class="d-flex gap-5 align-items-start">
      <div class="">
        <h4>Jazz festival overview</h4>
        <div id="calendar-a"></div>
      </div>
      <div class="mt-5" style = "background: whitesmoke; width: 800px; padding: 10px; border-radius: 10px;">
        <h4 id="selected-date"></h4>
        <table style="width:100% ">
          <tr>
            <td style="width:20%"> - Singer 1</td>
            <td style="width:20%"> 19:00</td>
            <td style="width:20%"> Grote Markt</td>
            <td style="width:20%"> $40</td>
            <td style="width:20%"> <a href="#">Details</a></td>
          </tr>
          <tr>
            <td style="width:20%"> - Singer 2</td>
            <td style="width:20%"> 20:00</td>
            <td style="width:20%"> Patronaat</td>
            <td style="width:20%"> $50</td>
            <td style="width:20%"> <a href="#">Details</a></td>
          </tr>
          <tr>
            <td style="width:20%"> - Singer 3</td>
            <td style="width:20%"> 21:00</td>
            <td style="width:20%"> Grote Markt</td>
            <td style="width:20%"> $45</td>
            <td style="width:20%"> <a href="#">Details</a></td>
          </tr>
          <tr>
            <td style="width:20%"> - Singer 4</td>
            <td style="width:20%"> 22:00</td>
            <td style="width:20%"> Patronaat</td>
            <td style="width:20%"> $55</td>
            <td style="width:20%"> <a href="#">Details</a></td>
          </tr>
          <tr>
            <td style="width:20%"> - Singer 5</td>
            <td style="width:20%"> 23:00</td>
            <td style="width:20%"> Patronaat</td>
            <td style="width:20%"> $60</td>
            <td style="width:20%"> <a href="#">Details</a></td>
          </tr>
        </table>
      </div>
    </div>
  </section>
  <script src="/js/calender.js"></script>
</body>
        </div>
    </div>

</body>
<div style="text-align: center; margin-top: 50px;">
    <h3 style="color: white;">Jazz Up Your Rhythm: Swing Into Dance Now!</h3>
    <div style="width: 1500px; height: 626px; display: flex; justify-content: space-around; align-items: center;">
        <!-- Add your three images here with shared hover effect -->
        <div class="image-container" style="width: 520px; height: 500px; position: relative; overflow: hidden; cursor: pointer;">
            <img src="/img/Music_img/image 119.png" alt="Image 1" style="width: 100%; height: 100%; object-fit: cover;">
            
        </div>
        <div class="image-container" style="width: 520px; height: 500px; position: relative; overflow: hidden; cursor: pointer;">
            <img src="/img/Music_img/Tiesto.png" alt="Image 2" style="width: 100%; height: 100%; object-fit: cover;">
            <div class="hover-container">
                <div class="hover-text">Find your favourite artist</div>
            </div>
        </div>
        <div class="image-container" style="width: 520px; height: 500px; position: relative; overflow: hidden; cursor: pointer;">
            <img src="/img/Music_img/Martin Garrix.png" alt="Image 3" style="width: 100%; height: 100%; object-fit: cover;">
            
    </div>
</div>
</html>

<style>
    .image-container {
        position: relative;
        overflow: hidden;
    }

    .hover-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .hover-text {
        background-color: rgba(85, 112, 89, 1);
        color: white;
        padding: 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .image-container:hover .hover-text {
        opacity: 1;
    }
</style>
</html>

<?php
include __DIR__ . '/../general_views/footer.php';
?>