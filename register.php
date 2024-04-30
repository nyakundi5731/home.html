<?php
require '../database/connection.php';


if (!empty($_SESSION["id"])) {
    header("location: index.php");
    exit();
}

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $family_size = $_POST["family_size"];
    $zone = $_POST["zone"];
    $food_aid_amount = $_POST["food_aid_amount"];
    $population = $_POST["population"];
    $id_number = $_POST["id_number"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($conn, "SELECT * FROM tb_user WHERE username=? OR email=?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "<script>alert('Username or email is taken');</script>";
    } else {
        if ($password == $confirmpassword) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insertStmt = mysqli_prepare($conn, "INSERT INTO tb_user (name, username, email, password, family_size, zone, food_aid_amount, population, id_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($insertStmt, "ssssisiii", $name, $username, $email, $hashedPassword, $family_size, $zone, $food_aid_amount, $population, $id_number);

            if (mysqli_stmt_execute($insertStmt)) {
                echo "<script>alert('Registration successful');</script>";
            } else {
                echo "<script>alert('Registration failed');</script>";
            }

            mysqli_stmt_close($insertStmt);
        } else {
            echo "<script>alert('Password does not match');</script>";
        }
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-image: url(../img/imgb6.jpg); background-size: cover; background-repeat: no-repeat;">

    <nav>
        <li><a href="../home/home.html">Home Page</a></li>
    </nav>

    <form class="action" method="post" autocomplete="off">
        <h2>Registration</h2>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required value=""><br>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required value=""><br>

        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required value=""><br>

        <label for="family_size">Family Size:</label>
        <input type="number" name="family_size" id="family_size" required><br>

        <label for="id_number">ID Number:</label>
        <input type="number" name="id_number" id="id_number" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required value=""><br>

        <label for="confirmpassword">Confirm Password:</label>
        <input type="password" name="confirmpassword" id="confirmpassword" required value=""><br>

        <input type="hidden" name="zone" id="zone" value="Please Update"><br>
        <input type="hidden" name="food_aid_amount" id="food_aid_amount" value="0"><br>
        <input type="hidden" name="population" id="population" value="0"><br>

        <button type="submit" name="submit">Register</button><br>
        <a href="login.php">Login</a>
    </form>
    <br>
    
</body>
</html>