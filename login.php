<?php
require '../database/connection.php';

if (isset($_POST["usernameemail"])) {
    $usernameemail = mysqli_real_escape_string($conn, $_POST["usernameemail"]);
    
    

    // Use prepared statement to prevent SQL injection
    $password_query = mysqli_prepare($conn, "SELECT * FROM tb_user WHERE username = ? OR email = ?");
    mysqli_stmt_bind_param($password_query, "ss", $usernameemail, $usernameemail);
    mysqli_stmt_execute($password_query);

    $result = mysqli_stmt_get_result($password_query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $password = $row["password"];

            if (password_verify($_POST["password"], $password)) {
                session_start();
                session_regenerate_id();
                $_SESSION["login"] = true;
                $_SESSION["id"] = $row["id"];
                header("location: ../home/user.php");
                exit();
            } else {
                echo "<script>alert('Wrong password');</script>";
            }
        } else {
            echo "<script>alert('User not registered');</script>";
        }
    } else {
        echo "Error in query: " . mysqli_error($conn);
    }

    mysqli_stmt_close($password_query);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-image: url(../img/imgb6.jpg); background-size: cover; background-repeat: no-repeat;">

    <nav>
        <li><a href="../home/home.html">Home Page</a></li>
    </nav>
    
    <form action="" method="post" autocomplete="off">
        <h2>Login</h2>
        <label for="usernameemail">Username or email:</label>
        <input type="text" name="usernameemail" id="usernameemail" value="<?php echo htmlspecialchars(isset($_POST['usernameemail']) ? $_POST['usernameemail'] : ''); ?>">
        <label for="password">Password:</label>
        <input type="password" name="password" required value=""><br>
        <button type="submit">Login</button><br>
        <a href="register.php">Registration</a>

    </form>
</body>
</html>