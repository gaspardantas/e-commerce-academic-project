<?php
include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <!--Navigation Bar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" p-0>
        <!--Logo-->
        <img src="../images/logo.png" height="40" width="40">
        <a class="navbar-brand" href="#">GameSpark</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php"><i class="fas fa-home"></i>Home</a>
                </li>
            </ul>
        </div>
    </nav>
    <!--Form-->
    <div class="container-fluid">
        <h2 class="text-center my-3">User Login</h2>
        <div class="row d-flex align-items-center justify-content-center py-2">
            <!-- The form will be inside a column -->
            <div class="col-lg-12 col-xl-5">
                <form action="" method="post">
                    <div class="form-outline">
                        <!-- User name field -->
                        <label for="user_email" class="form-label py-3">User email:</label>
                        <input type="text" id="user_email" class="form-control" placeholder="Please enter your username" autocomplete="off" required="required" name="user_email">
                        <!-- User password field -->
                        <label for="user_password" class="form-label py-3">Password:</label>
                        <input type="password" id="user_password" class="form-control" placeholder="Please enter your password" autocomplete="off" required="required" name="user_password">
                        <!-- Hide/show password checkbox -->
                        <label for="showPassword">
                            <input type="checkbox" id="showPassword"> Show Password
                        </label>
                    </div>
                    <div class="text-center py-3">
                        <input type="submit" value="Login" class="bg-info py-2 px-2 border-0" name="user_login">
                        <p class="small fw-bold mt-2 pt-2">Not registered, click -> <a href="user_registration.php">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<!-- Javascript code to change input type from text/password to show/hide password -->
<script>
    const passwordInput = document.getElementById('user_password');
    const showPasswordCheckbox = document.getElementById('showPassword');

    showPasswordCheckbox.addEventListener('change', function() {
        if (showPasswordCheckbox.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    });
</script>

<!-- PHP code to login -->
<?php
//start session to save variables in the server
session_start();
if (isset($_POST['user_login'])) {
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    if ($user_email == 'admin@' & $user_password == 'admin@') {
        header(("Location: ../admin/index.php"));
        exit();
    } else {
        // Check if user email is in the database
        $select_query = "Select * from `user` where user_email='$user_email'";
        $result = mysqli_query($con, $select_query);
        //Count how many matches
        $rows_count = mysqli_num_rows($result);
        //Get the row data
        $row_info = mysqli_fetch_assoc($result);
        //Save user_name in the server
        $_SESSION['user_name'] = $row_info['user_name'];
        $_SESSION['user_email'] = $row_info['user_email'];
        if ($rows_count > 0) {
            //Check if the password typed matches what's in the database
            if (password_verify($user_password, $row_info['user_password'])) {
                echo "<script>alert('Login Successful')</script>";
                //open main page
                header(("Location: ../index.php"));
                exit();
            } else {
                echo "<script>alert('Invalid password')</script>";
            }
        } else {
            echo "<script>alert('Invalid email, please correct it or register')</script>";
        }
    }
}
?>