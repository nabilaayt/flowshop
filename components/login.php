<?php 

session_start();
require '../config/database.php';
require_once 'theme.php';

$db = new Database();
$conn = $db->getConnection();

$currentTheme = getCurrentTheme();

// Jika use sudah login, redirect ke index.php
if(!empty($_SESSION["id"])){
    header("Location: ../index.php");
    exit();
}

if(isset($_POST["submit"])){
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];
    
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if(password_verify($password, $row["password"])){
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: ../index.php");
            exit();
        } else {
            echo "<script> alert('Wrong Password'); </script>";
        }
    } else {
        echo "<script> alert('User Not Registered'); </script>";
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login FlowShop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="<?php echo $currentTheme; ?>-theme">
    <div class="login-wrapper">
        <div class="login-card">

            <!-- FORM LOGIN -->
            <div class="login-left">
                <h1 class="login_title">Welcome Back</h1>
                <p class="login_desc">Hi, to keep connected with us please login with your personal info</p>

                <form class="login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="login_box">
                        <input type="email" name="email" id="email" class="login_input" placeholder=" " required>
                        <label for="email" class="login_label">Email</label>
                    </div>
                    <div class="login_box">
                        <input type="password" name="password" id="password" class="login_input" placeholder=" " required>
                        <label for="password" class="login_label">Password</label>
                    </div>
                    <button type="submit" name="submit" class="login_btn">Login</button>
                </form>

                <p class="login_switch">Don’t have an account?
                    <a href="registration.php" class="login_switch">Create an account</a>
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