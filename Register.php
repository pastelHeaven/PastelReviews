<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: dashboard.php");
    exit(); // Prevent further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="log.css" rel="stylesheet" type="text/css" />
    <title>PastelReviews</title>
</head>

<body>
    <div>
        <?php
        if (isset($_POST["submit"])) {
            require_once "conn.php"; // Ensure this file contains $conn connection

            // Get user input
            $username = trim($_POST["username"]);
            $email = trim($_POST["email"]);
            $password = $_POST["password"];
            $passwordRepeat = $_POST["Repeatpassword"];

            $errors = array();

            // Input Validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }
            if (strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 characters long");
            }
            if ($password !== $passwordRepeat) {
                array_push($errors, "Passwords do not match");
            }

            // this check if email already exists by using prepared statements
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                array_push($errors, "Email already exists!");
            }
            mysqli_stmt_close($stmt); // Close statement

            // Insert new user if no errors
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert'>$error</div>";
                }
            } else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Securely hash password
                $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='success'>You are registered successfully, go to login.</div>";
                    mysqli_stmt_close($stmt);
                } else {
                    die("Something went wrong.");
                }
            }
            mysqli_close($conn); 
        }
        ?>
        
        <form class="registration-form" action="Register.php" method="post">
            <h1>Registration</h1>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="Repeatpassword" placeholder="Repeat Password" required>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>

        <div>
            <p>Already registered? <a href="Login.php">Click Here</a></p>
        </div>
    </div>
</body>
</html>
