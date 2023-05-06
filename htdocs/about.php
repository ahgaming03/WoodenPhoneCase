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
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    
    <script> alert('Username/phone number is taken');</script>

    <!-- footer -->
    <?php include("footer.php"); ?>
</body>

</html>