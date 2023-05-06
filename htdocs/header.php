<?php
// Start session
session_start();            
// Change status Login <-> Logout
// Check if the user is already logged in
if (empty($_SESSION["loggedin"])) {
    // User is not logged in, set button text to "Login"
    $button_text = "Login";
    $button_link = "login.php";
} else {
    // User is logged in, set button text to "Logout"
    $button_text = "Logout";
    $button_link = "logout.php";
}
?>

<header>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="locations.php">Locations</a>
    <a href="cart.php">Cart</a>

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <div class="btn-group">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    data-bs-auto-close="true" aria-expanded="false">
                    ☰
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Devices</a></li>
                    <li><a class="dropdown-item" href="#">Products</a></li>
                    <li><a class="dropdown-item" href="#">Customization</a></li>
                    <li><a class="dropdown-item" href="#">About us</a></li>
                </ul>

                <a class="navbar-brand" href="index.php">
                    <img src="img/wood_log.png" alt="Logo" width="32" height="32"
                        class="d-inline-block align-text-center">
                    Jackarry </a>
            </div>

            <div class="btn-group">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    data-bs-auto-close="true" aria-expanded="false">
                    Account
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Menu item</a></li>
                    <li><a class="dropdown-item" href="#">Menu item</a></li>
                    <li><a class="dropdown-item" href="<?php echo $button_link;?>" ><?php echo $button_text; ?></a></li>
            </div>
    </nav>


    <hr>
</header>