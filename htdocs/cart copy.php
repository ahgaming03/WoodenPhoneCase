<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("layout_head.php") ?>
    <title>Cart</title>
    <link rel="stylesheet" href="css/cart.css">

</head>

<body>
    <?php include("header.php"); ?>

    <div class="cart-box" id="cart">
        <h2>Shopping cart</h2>
        <div class="text-end">Price</div>
        <hr>

        <?php
        if (empty($_SESSION["user_id"])) {
            ?>

            <p>Your cart is empty</p>
            <a href="login.php" class="btn btn-warning" role="button">Sign in to your account</a>
            <a href="signup.php" class="btn btn-secondary">Sign up now</a>

        <?php } else { ?>
            <?php
            // Connect to mySQL database
            include("database.php");

            $user_id = $_SESSION["user_id"];

            $stmt = $conn->prepare(
                "SELECT p.id, ol.order_id, p.name AS pName, b.name AS bName, p.price, ol.quantity, p.image_url
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

                <div class="row" id="product-<?= $row['id'] ?>">
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
                                <input type="number" id="quantity-<?= $row['id'] ?>" min="1" value="<?= $row['quantity'] ?>"
                                    width="10px" onfocus="showButton('button<?= $row['id'] ?>')">
                                <button type="button" id="button<?= $row['id'] ?>"
                                    class="btn btn-warning buttonUpdate">Update</button>
                                <button type="button" class="btn btn-danger"
                                    onclick="removeProduct(<?= $row['id'] ?>, <?= $row['order_id'] ?>)">Remove</button>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-end" id="price-<?= $row['id'] ?>"><?= "$" . $row['price'] ?></div>
                    </div>
                    <hr>
                </div>

                <?php
            }
            // Select the column you want to calculate the total of
            $sql = "SELECT total FROM orders WHERE user_id = $user_id AND status = 0";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output the total
                $row = $result->fetch_assoc();
                ?>

                <div class="text-end">
                    <span style="font-family: 'Minecraft-Bold'">Subtotal: </span>
                    <span id="subtotal">
                        <?= "$" . $row['total'] ?>
                    </span>
                    <button type="button" id="checkOut" class="btn btn-primary">Check out</button>
                </div>

                <?php
            } else {
                echo "YOUR CART IS EMPTY!!";
            }
            // Close mySQL connection
            $conn->close();
        }
        ?>
    </div>

    <?php include("footer.php"); ?>

    <script src="js/cart.js"></script>
</body>

</html>