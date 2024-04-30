<?php
session_start();
require '../database/connection.php';

if (!isset($_SESSION["admin_id"])) {
    header("location: ../admin/login.php");
    exit();
}

// Fetch registered users
$usersQuery = "SELECT * FROM tb_user";
$usersResult = mysqli_query($conn, $usersQuery);

// Fetch donations received
$donationsQuery = "SELECT * FROM tb_donations";
$donationsResult = mysqli_query($conn, $donationsQuery);

// Fetch donations distribution among users
$donationsDistributionQuery = "SELECT u.id, u.name, SUM(d.amount) AS total_donation 
                              FROM tb_user u 
                              LEFT JOIN tb_donations d ON u.id = d.user_id 
                              GROUP BY u.id";
$donationsDistributionResult = mysqli_query($conn, $donationsDistributionQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Your custom styles */
        body {
            font-family: Arial, sans-serif;
            background-image: url(../img/imgb6.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .btn {
            background-color: #ff6600;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #cc5500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Admin Dashboard</h1>

        <h2>Registered Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($usersResult)) : ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn">Edit</a>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Donations Received</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($donation = mysqli_fetch_assoc($donationsResult)) : ?>
                    <tr>
                        <td><?php echo $donation['id']; ?></td>
                        <td><?php echo $donation['user_id']; ?></td>
                        <td><?php echo $donation['amount']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Donations Distribution among Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Total Donation</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($distribution = mysqli_fetch_assoc($donationsDistributionResult)) : ?>
                    <tr>
                        <td><?php echo $distribution['id']; ?></td>
                        <td><?php echo $distribution['name']; ?></td>
                        <td><?php echo $distribution['total_donation']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
