<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("layout_head.php") ?>
    <title>Document</title>
</head>

<body>
    <!-- header -->
    <?php include("header.php"); ?>
    This is the About page <br>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus soluta aperiam omnis repudiandae consequatur.
        Quae reprehenderit earum, dolorem ad nisi non error repudiandae in nihil, officiis quod excepturi quas
        distinctio.</p>
    <br>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#check-out">
  Launch static backdrop modal
</button>

<!-- Modal -->
<div class="modal fade" id="check-out" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Order success</h1>
      </div>
      <div class="modal-body">
        <h2>Thanks for your order!</h2>
        <span>Order ID: 123</span>
      </div>
      <div class="modal-footer">
        <a href="index.php" role="button" class="btn btn-primary">Continue shopping</a>
      </div>
    </div>
  </div>
</div>
    

    <!-- footer -->
    <?php include("footer.php"); ?>
</body>

</html>