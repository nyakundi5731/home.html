<?php
session_start();
require '../database/connection.php';
if (!isset($_SESSION["id"])) {
    header("location: ../home/home.html");
    exit();
}

$id = $_SESSION["id"];
$result = mysqli_query($conn, "SELECT * FROM tb_user WHERE id = $id");
$row = mysqli_fetch_assoc($result);

if (isset($_POST["submit"])) {
    $familySize = $_POST["family_size"];
    $zone = $_POST["zone"];
    $population = $_POST["population"];
    $foodAid = $_POST["food_aid"];

    $updateStmt = mysqli_prepare($conn, "UPDATE tb_user SET family_size=?, zone=?, population=?, food_aid_amount=? WHERE id=?");
    mysqli_stmt_bind_param($updateStmt, "ssssi", $familySize, $zone, $population, $foodAid, $id);

    if (mysqli_stmt_execute($updateStmt)) {
        echo "<script>alert('Profile updated successfully');</script>";
        header("Refresh:0");
    } else {
        echo "<script>alert('Failed to update profile');</script>";
    }
    mysqli_stmt_close($updateStmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            background-image: url(../img/imgb6.jpg);
            background-size: cover;
            background-repeat: no-repeat;
        }
        nav {
            background: transparent;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
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
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
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
        canvas {
            margin-top: 5px;
            margin-bottom: 5px;
            width: 100%;
            max-width: 400px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav>
        <ul>
            <li><a href="user.php">Dashboard</a></li>
            <li><a href="#" class="active">Profile</a></li>
            <li><a href="#">Donate</a></li>
            <li><a href="../database/logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Your Personal Details</h1>
        <form class="profile-form" method="post">
            <label for="family_size"><strong>Family Size:</strong></label>
            <input type="text" name="family_size" id="family_size" value="<?php echo $row['family_size']; ?>" required><br>

            <label for="zone"><strong>Zone:</strong></label>
            <input type="text" name="zone" id="zone" value="<?php echo $row['zone']; ?>" required><br>

            <label for="population"><strong>Population in Camp:</strong></label>
            <input type="text" name="population" id="population" value="<?php echo $row['population']; ?>" required><br>

            <label for="food_aid"><strong>Food Aid Amount:</strong></label>
            <input type="text" name="food_aid" id="food_aid" value="<?php echo $row['food_aid_amount']; ?>" required><br>

            <button type="submit" name="submit">Update Profile</button>
        </form>

        <canvas id="donationsChart"></canvas>
    </div>

    <script>
        // Function to fetch donation data from the database
        function fetchDonationData() {
            // Dummy data for demonstration purposes
            const donationsData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Donations Received',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    data: [12, 19, 3, 5, 2, 3] // Example donation amounts
                }]
            };
            return donationsData;
        }
        function updateDonationsChart() {
            const ctx = document.getElementById('donationsChart').getContext('2d');
            const donationsChart = new Chart(ctx, {
                type: 'pie', // Changed chart type to pie
                data: fetchDonationData(),
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Donations Received'
                        }
                    }
                }
            });
        }
        updateDonationsChart();
    </script>
</body>
</html>