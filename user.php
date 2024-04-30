<?php
require '../database/connection.php';
session_start();

if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
} else {
    header("location: ../home/home.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refugee User Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            background-image: url(../img/imgb6.jpg);
            margin: 0;
            padding: 0;
        }
        .active{
            color: orange;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
        p {
            color: #666;
            margin-bottom: 5px;
        }
        button {
            background-color: #ff6600;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #cc5500;
        }
        .actions {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <nav style="background: transparent;">
        <ul>
            <li><a href="#" class="active">Dashboard</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="#">Donate</a></li>
            <li><a href="../database/logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Welcome to Your Dashboard <?php echo $row["name"]; ?></h1>
        <p>Here you can manage your donations, update your profile, and explore more options.</p>
        <!-- Add more content and features as needed -->
    </div>

    <div class="container">
        <h1>Distribution Details</h1>
        <div>
            <h2>Next Distribution:</h2>
            <p>Date: 2024-04-05</p>
            <p>Camps: Camp A, Camp B, Camp C</p>
        </div>
    </div>

    <div class="container">
        <h1>Welcome, <?php echo $row["name"]; ?>!</h1>
        <div>
            <h2>Your Details</h2>
            <p><strong>Name:</strong> <?php echo $row["name"]; ?></p>
            <p><strong>Family Size:</strong> <?php echo $row["family_size"]; ?></p>
            <p><strong>Zone:</strong> <?php echo $row["zone"]; ?></p>
            <p><strong>Food Aid Amount:</strong> <?php echo $row["food_aid_amount"]; ?> kgs</p>
            <p><strong>Population in Your Camp:</strong> <?php echo $row["population"]; ?></p>
            <p><strong>ID Number:</strong> <?php echo $row["id_number"]; ?></p>
        </div>
        <div class="actions">
            <button onclick="adjustFamilySize()">Adjust Family Size</button>
            <button onclick="viewDistributionDates()">View Distribution Dates</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>