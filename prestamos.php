<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Rafael Dorado">
    <title>Biblioteca</title>

    <?php include("./head.php"); ?>
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Biblioteca</a>
    </header>

    <?php include("./modals/registro_prestamo.php"); ?>
    <?php include("./modals/editar_prestamo.php"); ?>

    <div class="container-fluid">
        <div class="row">

            <?php include("./navbar.php"); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-2">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header d-flex">
                                <h3 class="mb-0">Prestamos</h3>

                                <button type="button" class="btn btn-warning btn-sm" style="margin-left: auto!important;" data-bs-toggle="modal" data-bs-target="#nuevoPrestamo">NUEVO PRESTAMO <i class="fas fa-plus"></i></button>
                            </div>
                            <div class="table-responsive py-4">
                                <table class="table table-flush" id="results">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>IDLIB</th>
                                            <th>NOMBRE DEL LIBRO</th>
                                            <th>NOMBRE Y APELLIDO</th>
                                            <th>FECHA LIMITE</th>
                                            <th>ESTADO</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <?php include("./footer.php"); ?>

    <script src="./assets/js/prestamos.js"></script>

</body>

</html>