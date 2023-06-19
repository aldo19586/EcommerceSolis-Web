<?php
include_once 'Views/Layouts/header.php'
 ?>
<title> Home | FerreteriaSolis </title>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Home</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Blank Page</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<style>
.titulo_producto {
    color: #000;
}

.titulo_producto:visited {
    color: #000;
}

.titulo_producto:focus {
    border-bottom: 1px solid;
}

.titulo_producto:hover {
    border-bottom: 1px solid;
}

.titulo_producto:active {
    background: #000;
    color: #FFF;
}
</style>
<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Productos</h3>
        </div>
        <div class="card-body">
            <div class="row" id="productos">

            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            Footer
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->
<?php
include_once 'Views/Layouts/footer.php'
 ?>
<script src="index.js"></script>