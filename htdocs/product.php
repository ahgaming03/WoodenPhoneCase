<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("layout_head.php") ?>
    <title>
        Product
    </title>
    <link rel="stylesheet" href="css/product.css">

</head>

<body>
    <!-- header -->
    <?php include("header.php"); ?>

    <?php
    // Connect to mySQL database
    include("database.php");

    // Retrieve the product information from the database
    $id = $_GET['id'];
    $sql = "SELECT id, name, stoke, price, image_url, description  FROM products WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Display the product information
        $row = $result->fetch_assoc();
        ?>

        <div class="box">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <div class="image">
                        <img src="<?= $row['image_url'] ?> " alt="<?= $row['name'] ?> " width="500px" max-height="100%">
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <h1>
                        <?= $row['name'] ?>
                    </h1>
                    <p>
                        <?= $row['description'] ?>
                    </p>
                    <p>Price:
                        <?= $row['price'] ?>
                    </p>

                    <form method="post">
                        <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                        <input type="number" name="quantity" id="quantity" min="1" max="<?= $row['stoke'] ?>" value="1">
                        <button type="submit" class="btn btn-success" name="add_to_cart">Add to cart</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
        // Handle adding the product to the cart
        if (isset($_POST['add_to_cart'])) {
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }

            echo "<p>Product added to cart</p>";
        }
    } else {
        echo "Product not found";
    }

    // Close mySQL connection
    $conn->close();
    ?>
    <!-- footer -->
    <?php include("footer.php"); ?>

</body>

</html>