<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vision Tea Brokers Management System</title>
    <link rel="stylesheet" type="text/css" href="VTBL-login1.css">
    <script src="https://kit.fontawesome.com/9458984521.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Style for the map container */
        #mapContainer {
            display: none;
            position: absolute;
            width: 500px;
            height: 200px;
            top: 0;
            right: 0;
            border: 2px solid #333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            background-color: white;
        }
        
        #mapContainer iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Close button */
        #mapClose {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
            color: #333;
        }

        /* Pulse effect for IPS Building marker */
        #pulseMarker {
            position: absolute;
            top: 65px; /* Adjust as needed to overlay on IPS location */
            left: 245px; /* Adjust as needed to overlay on IPS location */
            width: 15px;
            height: 15px;
            background-color: red;
            border-radius: 50%;
            opacity: 0.8;
            animation: pulse 1.5s infinite ease-in-out;
            z-index: 10;
        }

        /* Pulse animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.5);
                opacity: 0.4;
            }
            100% {
                transform: scale(1);
                opacity: 0.8;
            }
        }
      
    </style>
</head>
<body>
    <div id="Page1">
        <div class="header"> 
            <img src="Vision.logo1.png" width="100px" height="110px">
            <a href="VTBL-Login1.php">Manager</a>
        </div>

        <div class="homepageCont">
            <div class="bannerHeader"> 
                <h1>VISION TEA BROKERS LIMITED</h1>
                <p>THE DAR ES SALAAM TEA AUCTION (DTA)-TANZANIA</p>
            </div> 

            <div class="bannerIcon">
                <a data-target="#Profile"><i class="fa-regular fa-building"></i><p>Profile</p></a>
                <a data-target="#Vision"><i class="fa-solid fa-eye-low-vision"></i><p>Vision</p></a>
                <a data-target="#Mission"><i class="fa-solid fa-person-circle-exclamation"></i><p>Mission</p></a>
                <a data-target="#Values"><i class="fa-solid fa-heart"></i><p>Values</p></a>
                <a data-target="#Services"><i class="fa-solid fa-taxi"></i><p>Services</p></a>
            </div>
        </div>

        <div class="iconContents">
            <div id="Profile">
                <p>Vision Tea Brokers Limited (VTBL) is a Tea Broking firm established in 2023 and registered by the Tea Board of Tanzania (TBT).</p>
            </div>
            <div id="Vision">
                <p>To provide quality tea broking services that bring value for clients.</p>
            </div>
            <div id="Mission">
                <p>Our dedication lies in meeting our clients’ expectations by creating an innovative tea broking experience.</p>
            </div>
            <div id="Values">
                <ul>
                    <li>Excellence</li>
                    <li>Teamwork</li>
                    <li>Responsibility</li>
                    <li>Trust</li>
                    <li>Respect</li>
                </ul>
            </div>
            <div id="Services">
                <ul>
                    <li>Tea Sales</li>
                    <li>Tea Tasting and Quality Analysis</li>
                    <li>Marketing Intelligence</li>
                    <li>Advisory Services</li>
                    <li>Audits & Consultancy</li>
                </ul>
            </div>
        </div>
    </div>

<div class="ContactsHeader">
<h1>Get In Touch</h1>
</div>

  <div class="ContactsCont">
            <a><i class="fa-solid fa-phone fa-fade"></i><br><p>Tel: +255 22 21 27537 <br>Fax: +255 22 2125674</p></a>
            <a><i class="fa-solid fa-envelope fa-spin-pulse"></i><br><p>info@visionteabrokers.co.tz</p></a>
            <a id="locationIcon"><i class="fa-solid fa-location-dot fa-bounce"></i><br>
                <p>IPS Building, 5th and 10th Floor, Samora Avenue,<br>P.O. Box 8680,<br>Dar-es-salaam Tanzania</p>
            </a>
        </div>

        <!-- Map container -->
        <div id="mapContainer">
            <span id="mapClose">&times;</span>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.3270408983136!2d39.28017351522362!3d-6.812272095070119!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c4c8f6a892cd5%3A0x7b8b06b49d3f3cd9!2sIPS%20Building!5e0!3m2!1sen!2stz!4v1696990847855!5m2!1sen!2stz"
                allowfullscreen="" loading="lazy"></iframe>
        </div>

<!--social-->

			<div class="social-icons">
                <p style="color:transparent;">.</p>
				<ul>
                <li><a href="https://www.visionteabrokers.co.tz/index.php"><i class="fa-solid fa-globe "></i></a></li>
    <li><a href=""><i class="fa-brands fa-linkedin "></i></a></li>
    <li><a href=""><i class="fa-brands fa-tiktok "></i></a></li>
    <li><a href=""><i class="fa-brands fa-facebook "></i></a></li>
    <li><a href=""><i class="fa-brands fa-youtube "></i></a></li>
    <li><a href=""><i class="fa-brands fa-instagram "></i></a></li>
    <li><a href=""><i class="fa-brands fa-x-twitter "></i></a></li>
    <li style="color:white;margin-left:80px;"><a href=""><i>&copy; Copyright 2023. All Rights Reserved</i></a></li>
				</ul>
			</div>
          
		</div>

        <script>
      $(document).ready(function() {
    
    // When an icon is clicked, toggle visibility and store the active section in localStorage
    $('.bannerIcon a').click(function(e) {
        e.preventDefault(); // Prevent default action
        var target = $(this).data('target');

        // Toggle the target section visibility
        $(target).toggle().siblings('div').hide();
        // Store the active section in localStorage
        localStorage.setItem('activeSection', target);
    });

    
      // Toggle map container visibility
      $('#locationIcon').click(function() {
                $('#mapContainer').fadeToggle();
            });

            // Close map when close button is clicked
            $('#mapClose').click(function() {
                $('#mapContainer').fadeOut();
            });
});

    </script>
</body>
</html>,