<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Menu-Vision Tea Brokers Management System</title>
    <link rel="stylesheet" href="VTBL-NavBar3.css">
    <link rel="stylesheet" href="AuctionCatalog.css">
    <script src="https://kit.fontawesome.com/9458984521.js" crossorigin="anonymous"></script>
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
<body>
  <div class="sidebar close">
    <div class="logo-details">
      <span class="logo_name">Vision Tea Brokers Ltd</span>
    </div>
    <ul class="nav-links">
      <!-- Dashboard -->
      <li  id="dash">
        <a href="#" id="dashboard-link">
          <i class="fa-solid fa-table-columns"></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li><a id="dash1" class="link_name" href="">Dashboard</a></li>
        </ul>
      </li>

      <!-- Pre-Sales -->
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class="fa-solid fa-prescription"></i>
            <span class="link_name">Pre-Sales</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Pre-Sales</a></li>
          <li id="sub-pre-sale1"><a>Auction Catalogue</a></li>
          <li><a href="#">Private Offers</a></li>
        </ul>
      </li>

      <!-- Sale Result -->
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class="fa-solid fa-universal-access"></i>
            <span class="link_name">Sale Result</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Sale Result</a></li>
          <li id="auction_sale"><a href="#">Auction Sale</a></li>
          <li><a href="#">Private Sale</a></li>
        </ul>
      </li>

      <!-- Accounts -->
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class="fa-solid fa-file-invoice"></i>
            <span class="link_name">Accounts</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Accounts</a></li>
          <li><a href="#">Invoice</a></li>
          <li><a href="#">Account Sale</a></li>
          <li><a href="#">Bank Letter</a></li>
          <li><a href="#">Release Order</a></li>
        </ul>
      </li>

      <!-- Reports -->
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class="fa-regular fa-flag"></i>
            <span class="link_name">Reports</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Reports</a></li>
          <li><a href="#">Market Report</a></li>
          <li><a href="#">Post-auction Report</a></li>
          <li><a href="#">Crop & Weather Data</a></li>
          <li><a href="#">DTA Market Statistics</a></li>
          <li><a href="#">Tea Trade Statistics</a></li>
        </ul>
      </li>

      <!-- Glossary -->
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class="fa-regular fa-window-restore"></i>
            <span class="link_name">Glossary</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Glossary</a></li>
          <li><a href="#">Buyer Details</a></li>
          <li><a href="#">Producer Details</a></li>
          <li><a href="#">Warehouse Details</a></li>
          <li><a href="#">Tea Nomenclature</a></li>
        </ul>
      </li>

      <!-- Profile -->
      <li>
        <div class="profile-details">
          <div class="profile-content">
            <img src="Vision.logo1.png" alt="profileImg">
          </div>
          <div class="name-job">
            <div class="profile_name">VTBL</div>
            <div class="job">Tea Broker</div>
          </div>
          <i onclick="history.go(-1)" class='bx bx-log-out'></i>
        </div>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu'></i>
    </div>
    <div id="CatalogContainer" style="display:none;">
      <?php require 'user_inputs.php'; ?>
    </div>
    <div id="dash-div" style="display:none;">
      <?php require 'dashboard.php'; ?>
    </div>
    <div id="sale_result" style="display:none;">
      <?php require 'sale_result.php'; ?>
    </div>
  </section>

  <script>
   $(document).ready(function() {
    // Initialize visibility states from localStorage
    const catalogVisible = localStorage.getItem("catalogVisible") === "true";
    const dashVisible = localStorage.getItem("dashVisible") === "true";
    const saleVisible = localStorage.getItem("saleVisible") === "true";

    // Set initial visibility based on localStorage
    $("#CatalogContainer").toggle(catalogVisible);
    $("#dash-div").toggle(dashVisible);
    $("#sale_result").toggle(saleVisible);

    // Toggle menu on click
    $(".arrow").click(function() {
        $(this).parent().parent().toggleClass("showMenu");
    });

    $(".bx-menu").click(function() {
        $(".sidebar").toggleClass("close");
    });

     // Show CatalogContainer and hide dash-div on Auction Catalogue click
     $("#auction_sale").click(function() {
        $("#dash-div").hide(); // Ensure #dash-div is hidden
        const isVisible = $("#sale_result").toggle().is(":visible");
        localStorage.setItem("saleVisible", isVisible); // Update localStorage
        localStorage.setItem("catalogVisible", false); // Update localStorage
        localStorage.setItem("dashVisible", false); // Update to ensure #dash-div is hidden
    });

    // Show CatalogContainer and hide dash-div on Auction Catalogue click
    $("#sub-pre-sale1").click(function() {
        $("#dash-div").hide(); // Ensure #dash-div is hidden
        const isVisible = $("#CatalogContainer").toggle().is(":visible");
        localStorage.setItem("catalogVisible", isVisible); // Update localStorage
        localStorage.setItem("dashVisible", false); // Update to ensure #dash-div is hidden
        localStorage.setItem("saleVisible", false); // Update to ensure #dash-div is hidden
    });

    // Show dash-div and hide CatalogContainer on Dashboard click
    $("#dash").click(function() {
        $("#CatalogContainer").hide(); // Ensure #CatalogContainer is hidden
        const isVisible = $("#dash-div").toggle().is(":visible");
        localStorage.setItem("dashVisible", isVisible); // Update localStorage
        localStorage.setItem("catalogVisible", false); // Update to ensure #CatalogContainer is hidden
        localStorage.setItem("saleVisible", false); // Update to ensure #CatalogContainer is hidden
    });

    // Hide both sections when a main link is clicked
    $(".link_name").click(function() {
        $("#CatalogContainer").hide();
        $("#dash-div").hide();

        // Update localStorage to reflect both are hidden
        localStorage.setItem("catalogVisible", false);
        localStorage.setItem("dashVisible", false);
        localStorage.setItem("saleVisible", false);
    });
});
  </script>
</body>
</html> )