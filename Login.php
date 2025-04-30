<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST["submit"])) {
    require_once "conn.php";

    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($user) {
            // Verify hashed password
            if (password_verify($password, $user["password_hash"])) {
                $_SESSION['user'] = 'yes';
                $_SESSION['user_id'] = $user['id'];
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<div class='alert'>Password does not match</div>";
            }
        } else {
            echo "<div class='alert'>Username does not match</div>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert'>Something went wrong</div>";
    }
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="log.css" rel="stylesheet" type="text/css" />
    <title>Login</title>
</head>
<body>
    <form class="registration-form" action="Login.php" method="post">
        <h1>Login</h1>
        <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
        </div>

        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>

        <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="Log in" name="submit">
        </div>
    </form>

    <div>
        <p>Need to register? <a href="Register.php">Click Here</a></p>
        <p>Forgot password? <a href="">Click Here</a></p>
    </div>
</body>
</html>
