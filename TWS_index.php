<?php
session_start();


// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartItemCount = 0;
$cartTotalPrice = 0;

// Calculate total number of items and total price in the cart
foreach ($_SESSION['cart'] as $item) {
    $quantity = $item['quantity'] ?? 1; // Default to 1 if not set
    $cartItemCount += $quantity;
    $cartTotalPrice += $item['price'] * $quantity;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TheWholeStory - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Poiret+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
     /* Banner Styles */
.banner {
    text-align: center; /* Center the banner text */
    padding: 20px;
    background-color: #f8f9fa; /* Light background for banner */
    margin-bottom: 20px; /* Space below the banner */
}

/* Content Section Styles */
.content-section {
    display: flex;
    flex-direction: column; /* Stack elements vertically */
    align-items: center; /* Center horizontally */
    justify-content: center; /* Center vertically */
    height: 250px; /* Set a height for the section */
    text-align: center; /* Center text */
    background-color: #c0c0c0; /* Background color */
    padding: 10px; /* Add padding for spacing */
    border-radius: 8px; /* Rounded corners */
}

.content-section h1 {
    font-size: 48px; /* Adjust font size for the heading */
    text-shadow: 2px 2px #ffce1b;

    
}

.content-section p {
    font-size: 20px; /* Adjust font size for the paragraph */
    color: gold; /* Ensure text visibility */
    font-weight: bold;
}
/* Sidebar Styles */
.sidebar {
    width: 250px; /* Width of the sidebar */
    position: fixed; /* Fixed position */
    top: 60px; /* Adjust to be below the navbar */
    left: 0; /* Align to the left */
    background-color: rgba(128, 128, 128, 0.9); /* Background color */
    color: white; /* Text color */
    padding: 20px; /* Padding inside sidebar */
    height: calc(100% - 60px); /* Full height minus navbar */
    overflow-y: auto; /* Scroll if content overflows */
    z-index: 99; /* Above other content */
    transition: transform 0.3s ease; /* Smooth transition */
}

.sidebar.hidden {
    transform: translateX(-100%); /* Hide by moving out */
}

/* Sidebar hover effect */
.sidebar:hover {
    transform: translateX(0); /* Slide in on hover */
}



.sidebar h2 {
    font-size: 24px; /* Sidebar heading size */
    margin-bottom: 20px; /* Space below heading */
}

.sidebar ul {
    list-style: none; /* Remove default list styles */
    padding: 0; /* Remove padding */
}

.sidebar ul li {
    margin: 10px 0; /* Space between items */
}

.sidebar ul li a {
    color: gold; /* Link color */
    text-decoration: none; /* Remove underline */
    transition: color 0.3s; /* Smooth color transition */
}

.sidebar ul li a:hover {
    color: white; /* Change color on hover */
    text-decoration: underline; /* Underline on hover */
}



/* Body Styles */
body {
    font-family: 'Poiret One', sans-serif;
    margin: 0;
    padding: 0;
    background-color:  #c0c0c0; /* Dark background */
    color: white;
    overflow-x: hidden;
}

/* Navigation Menu Styles */
nav {
    background-color: rgba(128, 128, 128, 0.8); /* Semi-transparent gray */
    padding: 21px;
    position: fixed; /* Fixed at the top */
    width: 100%; /* Full width */
    top: 0; /* Position it at the top */
    z-index: 100; /* Above other content */
}

nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: center;
}

nav ul li {
    margin: 0 15px;
    position: relative; /* Make sure the button is positioned correctly */
}


nav ul li a {
    font-family: 'Poiret One', sans-serif;
    font-weight: bold;
    color: gold; /* Text color */
    text-decoration: none; /* Remove underline */
}

nav ul li a:hover {
    color: white; /* Hover effect */
}

/* Slideshow Container */
.slideshow-container {
    position: relative;
    width: 100%;
    height: 90vh; /* Full viewport height */
    overflow: hidden;
}

/* Slideshow Images */
.slide {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover; /* Maintain aspect ratio */
    opacity: 0;
    transition: opacity 1s ease-in-out;
    z-index: 0;
}

.active {
    opacity: 1; /* Active slide visibility */
    z-index: 1; /* Ensure it's on top */
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .slideshow-container {
        height: 50vh; /* Adjust for smaller screens */
    }
}

/* Product List Styles */
ul.products {
    display: flex;
    flex-direction: column; /* Stack items vertically */
    padding: 20px;
    gap: 20px; /* Space between items */
    max-width: 800px; /* Limit max width */
    margin: 0 auto; /* Center product list */
}

ul.products li {
    background-color: rgb(233, 231, 222);
    border: 1px solid #e0e0e0; /* Soft border */
    padding: 20px;
    border-radius: 12px; /* Rounded corners */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Shadow for depth */
    text-align: center; /* Center text */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition */
}

ul.products li:hover {
    transform: translateY(-5px); /* Lift on hover */
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); /* Enhanced shadow */
}

ul.products li img {
    max-width: 100%;
    height: auto;
    border-radius: 10px; /* Rounded corners for images */
    margin-bottom: 15px; /* Space below images */
}

ul.products li h2 {
    font-size: 22px; /* Product name size */
    font-weight: bold:
    color: rgb(0, 0, 0); /* Dark text */
    margin: 10px 0; /* Spacing */
}

ul.products li p {
    font-size: 18px; /* Price size */
    font-weight: bold:
    color: goldenrod; /* Price color */
    margin: 10px 0; /* Spacing */
}

/* Featured Brands Section */
.products-section {
    background-color: white; /* Background color */
    padding: 50px 0; /* Add padding for top and bottom */
    text-align: center;
}

.products-section h1 {
    color: black; /* Heading color */
    font-size: 36px; /* Heading font size */
    margin-bottom: 20px; /* Space below the heading */
}

.products {
    display: flex;
    justify-content: center;
    gap: 20px;
    list-style: none;
    padding: 0;
    margin: 0 auto;
    max-width: 1200px; /* Limit width */
}

.products li {
    color: black; /* Text color */
    text-align: center;
    background-color: #f8f8f8; /* Product background */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Optional shadow */
}

.products img {
    max-width: 150px; /* Image max width */
    border-radius: 8px;
}

/* Button Styles */
.scroll-button {
    display: inline-block;
    width: 200px;
    padding: 10px 20px;
    background-color: #000;
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 18px;
    transition: background-color 0.3s ease-in-out;
    margin: 20px auto;
    border-radius: 5px; /* Rounded corners */
}

.scroll-button:hover {
    background-color: gold; /* Hover effect */
    color: black; /* Hover text color */
}
.extended-content {
            background-color: #f8f9fa; /* Light background */
            padding: 20px;
            border-radius: 8px; /* Rounded corners */
            margin-top: 20px; /* Space above */
        }
        .extended-content p{
            color:black;
            size:60px;
            font-weight:bold;
        }
        .extended-content h1{
            color:black;
            size:60px;
        }

/* Footer Styles */
footer {
    background-color: gray;
    padding: 20px;
    text-align: center;
    color: gold;
    border-top: 1px solid gold; /* Top border */
}
.product-container {
    position: relative; /* Needed for absolute positioning of the overlay */
    display: inline-block; /* Ensure the link wraps tightly around the image */
}

.image {
    display: block;
    width: 100%;
    height: auto;
    border-radius: 10px; /* Optional: matches previous styles */
}

.overlay {
    position: absolute; 
    bottom: 0; 
    background: rgba(0, 0, 0, 0.7); /* Black see-through */
    color: #f1f1f1; 
    width: 100%;
    transition: .5s ease;
    opacity: 0;
    font-size: 16px; /* Adjusted for product overlays */
    padding: 10px;
    text-align: center;
}

.product-container:hover .overlay {
    opacity: 1; /* Show overlay on hover */
}

    </style>
</head>
<body>
     <!-- Sidebar -->
     <div class="sidebar hidden"> <!-- Add 'hidden' class here -->
        <h2>User Menu</h2>
        <ul>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="support.php">Support</a></li>
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
    </div>

   <!-- Navigation Menu -->
<nav>
    <ul>
        <li><a href="TWS_index.php">Home</a></li>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <li><a href="logout.php">Logout</a></li> 
            <li><a href="order_history.php">Order History</a></li>
            <li><a href="admin_orders.php">Admin Orders</a></li>
        <?php else: ?>
            <li><a href="register.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="admin_login.php">Admin Login</a></li>
        <?php endif; ?>
    </ul>
    <li style="position: absolute; left: 10px; top: 10px;">
    <button id="toggleSidebar" style="position: absolute; left: 10px; top: 10px; background: none; border: none; cursor: pointer;">
    <i class="fas fa-chevron-right" id="sidebarArrow" style="font-size: 24px; color: gold;"></i>
</button>

</li>

    <?php include('cart_summary.php'); ?>
</nav>

   

    <!-- Content Section -->
    <div class="content-section">
    <h1>Welcome to The Whole Story</h1>
    <p class="intro-text">Where the wonderful story begins</p>
</div>

 <!-- Slideshow Container -->
 <div class="slideshow-container">
        <img class="slide" src="LC_20200724_UK_CI_EM_FOODLOVE20LP01_ENG.jpg" alt="Slide 3">
        <img class="slide active" src="128644_3295752_tulip_w_11.jpg" alt="Slide 1">
        <img class="slide" src="Smeg-Kuechenmaschine-Standmixer-creme-Situation.jpg" alt="Slide 5">
        
    </div>


    <div class="products-section">
    <h1>Featured Brands</h1>
    <ul class="products">
        <li>
            <a href="la_cruset_products.php" class="product-container">
                <img src="le-creuset.jpg" alt="Le Creuset" class="image">
                <div class="overlay">Explore our selection of Le Creuset products!</div>
            </a>
            <h2>Le Creuset</h2>
        </li>
        <li>
            <a href="staub_products.php" class="product-container">
                <img src="Staub_logo.png" alt="Staub" class="image">
                <div class="overlay">Discover the finest Staub cookware!</div>
            </a>
            <h2>Staub</h2>
        </li>
        <li>
            <a href="portmeirion_products.php" class="product-container">
                <img src="Portmeirion.jpg" alt="Portmeirion" class="image">
                <div class="overlay">Shop our Portmeirion dinner sets!</div>
            </a>
            <h2>Portmeirion</h2>
        </li>
    </ul>
</div>



        <!-- Scroll Button -->
        <div>
        <button class="scroll-button" id="toggleButton">Browse More</button>
    </div>
    <div class="extended-content" id="extendedContent" style="display: none;">
        <h1>About us</h1>
        <p>Your extended content goes here. You can include images, text, or any other HTML elementsYour extended content goes here. You can include images, text, or any other HTML elementsYour extended content goes here. You can include images, text, or any other HTML elements.</p>
        <p>
            <h1>Le Creuset</h1>
            <p>The Story of a True Original
            With an unrivaled selection of bold, rich colors in a range of finishes and materials, Le Creuset is the leader in highly-durable, chip-resistant enameled cast iron.</p>
        <!-- Add more content as needed -->
    </div>

    <!-- Footer -->
<footer>
    <p>&copy; 2024 TheWholeStory. All rights reserved.</p>
</footer>

    <script>
        let slideIndex = 0;

        function showSlides() {
            const slides = document.getElementsByClassName("slide");
            
            // Set all slides to inactive
            for (let i = 0; i < slides.length; i++) {
                slides[i].classList.remove("active");
            }
            
            // Increment the index (loop back if at end)
            slideIndex++;
            if (slideIndex >= slides.length) {
                slideIndex = 0;
            }
            
            // Set current slide to active
            slides[slideIndex].classList.add("active");
            
            // Change slide every 4 seconds
            setTimeout(showSlides, 4000); 
        }

        showSlides();
    </script>
     <script>
        document.getElementById('toggleButton').addEventListener('click', function() {
            const extendedContent = document.getElementById('extendedContent');
            if (extendedContent.style.display === 'none') {
                extendedContent.style.display = 'block'; // Show the content
                this.innerText = 'Show Less'; // Change button text
            } else {
                extendedContent.style.display = 'none'; // Hide the content
                this.innerText = 'Browse More'; // Reset button text
            }
        });
    </script>
    <script>
document.getElementById('toggleSidebar').addEventListener('click', function() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('hidden'); // Toggle the hidden class
    
    const arrow = document.getElementById('sidebarArrow');

    // Change the arrow direction based on sidebar visibility
    if (sidebar.classList.contains('hidden')) {
        arrow.classList.remove('fa-chevron-left'); // Change to right arrow
        arrow.classList.add('fa-chevron-right');
    } else {
        arrow.classList.remove('fa-chevron-right'); // Change to left arrow
        arrow.classList.add('fa-chevron-left');
    }
});
</script>


</body>
</html>
