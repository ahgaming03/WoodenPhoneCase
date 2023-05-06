<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("layout_head.php") ?>
    <title>Cart</title>
    <link rel="stylesheet" href="css/cart.css">
</head>

<body>
    <?php include("header.php"); ?>

    <div class="box">
        <h2>Shopping cart</h2>
        <hr>

        <?php
        if (empty($_SESSION["user_id"])) {
            echo "";
            echo '
            <p>Your cart is empty</p>
            <a href="login.php" class="btn btn-warning">Sign in to your account</a>
            <a href="signup.php" class="btn btn-secondary">Sign up now</a>
            ';
        } else {
            // Connect to mySQL database
            include("database.php");

            $user_id = $_SESSION["user_id"];

            $stmt = $conn->prepare(
                "SELECT p.name AS pName, b.name AS bName, p.price, ol.quantity, p.price * ol.quantity AS total, p.image_url
            FROM ordersline AS ol
            INNER JOIN products AS p
            ON ol.product_id = p.id
            INNER JOIN brands AS b
            ON p.brand_id = b.id
            RIGHT JOIN orders AS o
            ON ol.order_id = o.id
            WHERE  o.user_id = $user_id AND o.status = 0"
            );

            // Execute query
            $stmt->execute();

            // Get query result as a result object
            $result = $stmt->get_result();

            // Fetch result rows as an associative array
            while ($row = $result->fetch_assoc()) {
                ?>

                <!-- cart list -->
                <div class="row">
                    <div class="col-md-2">
                        <img src="<?= $row['image_url'] ?>" class="img-fluid rounded-start" alt="<?= $row['pName'] ?>"
                            height="180" width="180">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h4 class="card-title">
                                <?= $row['pName'] ?>
                            </h4>
                            <p>Brand:
                                <?= $row['bName'] ?>
                            </p>
                            <div>
                                <span>
                                    <input type="number" name="quantity" id="quantity" min="1" value="<?= $row['quantity'] ?>"
                                        width="10px">
                                </span>
                                <span>|</span>
                                <span>Remove</span>
                                <span>|</span>
                                <span>Share</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-end">
                            $
                            <?= $row['total'] ?>
                        </div>
                    </div>
                    <div>
                        <hr>
                    </div>

                    <?php
            }
            ?>
            </div>

            <?php
            // Select the column you want to calculate the total of
            $sql = "SELECT total FROM orders WHERE user_id = $user_id AND status = 0";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output the total
                $row = $result->fetch_assoc();
                ?>

                <div class="text-end">
                    <span>Subtotal: </span>
                    <span>$
                        <?= $row['total'] ?>
                    </span>
                </div>

                <?php
            }
            // Close mySQL connection
            $conn->close();
        }
        ?>
    </div>

    <?php include("footer.php"); ?>

</body>

</html>