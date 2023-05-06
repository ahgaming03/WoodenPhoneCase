<?php
session_start();

// Check if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data using filter_input
    $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $confirm_password = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_SPECIAL_CHARS);
    $phonenumber = filter_input(INPUT_POST, "phonenumber", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
    $address2 = filter_input(INPUT_POST, "address2", FILTER_SANITIZE_SPECIAL_CHARS);

    // Check if the password and confirm password fields match
    if ($password !== $confirm_password) {
        echo "Error: Passwords do not match.";
    } else {
        // Include the database connection script
        include("database.php");
        // Hash the password using a secure algorithm like bcrypt
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user information into the database
        $sql = "INSERT INTO users (firstname, lastname, username, password, phonenumber, email, address, address2) 
                VALUES ('$firstname', '$lastname', '$username', '$hashed_password', '$phonenumber', '$email', '$address', '$address2')";

        try {
            $result = mysqli_query($conn, $sql);

            // Check if the query was successful
            if ($result) {
                echo "Sign up successful! You can log in now!";
                // Close the database connection
                mysqli_close($conn);

                // Delay the header for 5 seconds
                sleep(5);

                // Redirect the user to a new page
                header('Location: login.php');
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } catch (mysqli_sql_exception) {
            echo "<script> alert('Username/phone number is taken');</script>";
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("layout_head.php") ?>
    <title>Sign up</title>
    <link rel="stylesheet" href="css/signup.css">

    <script>
        function showPassword() {
            var passwordInput = document.getElementById("password");
            var confirmPasswordInput = document.getElementById("confirm_password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                confirmPasswordInput.type = "text";
            } else {
                passwordInput.type = "password";
                confirmPasswordInput.type = "password";
            }
        }
    </script>


</head>

<body>

    <div class="position-relative">
        <div class="signup-box">
            <h1>SIGN UP</h1>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="login.php" class>Back to Login</a>
            </div>
            <hr>
            <form class="row g-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="col-md-6">
                    <label for="firstname" class="form-label">First name</label>
                    <input type="text" minlength="3" class="form-control" id="firstname" name="firstname" required>
                </div>

                <div class="col-md-6">
                    <label for="lastname" class="form-label">Last name</label>
                    <input type="text" minlength="3" class="form-control" id="lastname" name="lastname" required>
                </div>

                <div class="col-12">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" minlength="5" class="form-control" id="username" name="username" required>
                </div>

                <div class="col-12">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" minlength="6" class="form-control" id="password" name="password" required>
                </div>

                <div class="col-12">
                    <label for="confirm_password" class="form-label">Confirm password</label>
                    <input type="password" minlength="6" class="form-control" id="confirm_password"
                        name="confirm_password" required>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="showPass" onclick="showPassword()">
                    <label class="form-check-label" for="showPass">
                        Show password
                    </label>
                </div>

                <?php

                // Display an error message if the password and confirm password fields do not match
                if (isset($_POST['password']) && isset($_POST['confirm_password']) && $_POST['password'] !== $_POST['confirm_password']) {
                    echo "<p style='color: red;'>Error: Passwords do not match.</p>";
                }
                ?>

                <div class="col-12">
                    <label for="phonenumber" class="form-label">Phone number:</label>
                    <input type="tel" class="form-control" id="phonenumber" name="phonenumber" placeholder="0123456789"
                        pattern="[0-9]{10}" required>
                </div>

                <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" minlength="6" class="form-control" id="email" name="email"
                        placeholder="Example@email.com">
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St"
                        required>
                </div>

                <div class="col-12">
                    <label for="address2" class="form-label">Address 2</label>
                    <input type="text" class="form-control" id="address2" name="address2"
                        placeholder="Apartment, studio, or floor">
                </div>


                <hr>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success" name="signup">Sign up</button>

                </div>
            </form>

        </div>
    </div>

</body>

</html>

