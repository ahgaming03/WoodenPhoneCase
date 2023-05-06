<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("layout_head.php") ?>
    <title>Jackarry</title>
    <link rel="stylesheet" href="css/card.css">
</head>

<body>
    <?php
    // Header page
    include("header.php");

    // foreach ($_SESSION as $key => $value) {
    //     echo "{$key} = {$value} <br>";
    // }
    ?>

    This is the Home page <br>
    Welcome <br>
    <br>
    <div class="card-box">
        <h1>Wood</h1>
        <div class="row row-cols-1 row-cols-md-5 g-4">
            <?php
            // Connect to mySQL database
            include("database.php");

            // Prepare SQL query
            $stmt = $conn->prepare("SELECT id, name, price, image_url FROM products");

            // Execute query
            $stmt->execute();
            
            // Get query result as a result object
            $result = $stmt->get_result();

            // Fetch result rows as an associative array
            while ($row = $result->fetch_assoc()) {
                ?>
                <!-- products -->
                <div class="col">
                    <div class="card h-100">
                        <a href="product.php?id=<?= $row['id'] ?>">
                            <img src="<?= $row['image_url'] ?>" class="card-img" alt="<?= $row['name'] ?>">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= $row['name'] ?>
                            </h5>
                        </div>
                        <div class="card-footer">
                            <small class="text-body-secondary">$
                                <?= $row['price'] ?>
                            </small>
                        </div>
                    </div>
                </div>
            <?php
            }
            // Close mySQL connection
            $conn->close();
            ?>

        </div>
    </div>

    <!-- footer -->
    <?php include("footer.php"); ?>
</body>

</html>