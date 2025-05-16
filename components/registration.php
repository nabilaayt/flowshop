<?php 

session_start();
require '../config/database.php';
require_once 'theme.php';

$db = new Database();
$conn = $db->getConnection();

$currentTheme = $themeManager->getCurrentTheme();

// Jika sudah login, redirect ke index.php
if(!empty($_SESSION["id"])){
    header("Location: ../index.php");
    exit();
}

if(isset($_POST["submit"])){
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmpassword"];

    // Default role "user"
    $role = 'user';

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        echo "<script> alert('Email Has Already Taken'); </script>";
    }else{
        if($password === $confirmPassword){
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO user (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

            if($stmt->execute()){
                // echo "<script> alert('Registration Successful'); </script>";
                header("Location: login.php");
                exit();
            }
        }else{
            echo "<script> alert('Password Does Not Match'); </script>";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration FlowShop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="<?php echo $currentTheme; ?>-theme">
    <div class="login-wrapper">
        <div class="login-card">
            

            <!-- FORM LOGIN -->
            <div class="login-left">
                <h1 class="login_title">Create Account</h1>
                <p class="login_desc">Hi, please create your account first below!</p>

                <form class="login_form" method="post">
                    <div class="login_box">
                        <input type="name" name="name" id="name" class="login_input" placeholder=" " required>
                        <label for="name" class="login_label">Name</label>
                    </div>
                    <div class="login_box">
                        <input type="email" name="email" id="email" class="login_input" placeholder=" " required>
                        <label for="email" class="login_label">Email</label>
                    </div>
                    <div class="login_box">
                        <input type="password" name="password" id="password" class="login_input" placeholder=" " required>
                        <label for="password" class="login_label">Password</label>
                    </div>
                    <div class="login_box">
                        <input type="password" name="confirmpassword" id="confirmpassword" class="login_input" placeholder=" " required>
                        <label for="confirmpassword" class="login_label">Confirm Password</label>
                    </div>
                    <button type="submit" name="submit" class="login_btn">Create Account</button>
                </form>

                <p class="login_switch">Already have an account?
                    <a href="login.php" class="login_switch">Login</a>
                </p>
            </div>

            <!-- GAMBAR -->
            <div class="login-right">
                <img src="../assets/bg-main2.jpg" alt="Login Image" class="login-image">
            </div>
        </div>
    </div>
    <a href="?toggle_theme=1" class="theme-toggle">
        <?php echo $currentTheme === 'dark' ? '☀️' : '🌙'; ?>
    </a>
</body>
</html>