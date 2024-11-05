<?php
session_start();
include('db_connect.php');

$message = ""; // Variable to hold messages

// Check if the user is already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: TWS_index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password, full_name, email, address FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $fullName, $email, $address);
        $stmt->fetch();
        
        // Check if the password matches
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username; // This should be the username used for login
            $_SESSION['full_name'] = $fullName; // The full name of the user for shipping
            $_SESSION['user_email'] = $email; // User's email
            $_SESSION['user_address'] = $address; // User's address
            
            // Set logged_in session variable to true
            $_SESSION['logged_in'] = true; // Set the logged-in status

            // Redirect back to the previous page if available
            if (isset($_GET['redirect'])) {
                header("Location: " . urldecode($_GET['redirect']));
                exit();
            } else {
                header("Location: TWS_index.php"); // Redirect to the homepage after login
                exit();
            }
        } else {
            $message = "Error: Incorrect password.";
        }
    } else {
        $message = "Error: User not found.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TheWholeStory</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Ensure html and body fill the full screen */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Poiret One', sans-serif;
        }

        /* Container to take full height of screen */
        .container {
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #f4f4f4;
        }

        /* Center the form container */
        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1; /* Takes the remaining space */
        }

        /* Navigation Bar */
        nav {
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px;
            position: relative;
            z-index: 10;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            flex-grow: 1;
        }

        nav ul li {
            margin: 0 15px;
        }

        .shop-logo {
            position: absolute;
            left: 20px;
            height: 50px;
        }

        nav a {
            text-decoration: none;
            color: gold;
        }

        nav a:hover {
            color: white;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center; /* Center text inside the form container */
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #007bff;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>
<body>

    <!-- Navigation Menu -->
    <nav>
        <ul>
            <li><a href="TWS_index.php">Home</a></li>
            <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="admin_login.php">Admin Login</a></li> <!-- Admin login link -->
            <?php else: ?>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="order_history.php">Order History</a></li> <!-- Link for logged-in users -->
            <?php endif; ?>
        </ul>
    </nav>

    <div class="container">
        <div class="form-wrapper">
            <div class="form-container">
                <h1>Login</h1>
                <form action="" method="POST">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" value="Login">
                </form>
                <?php if ($message): ?>
                    <p class="message"><?php echo $message; ?></p>
                <?php endif; ?>
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>

</body>
</html>
