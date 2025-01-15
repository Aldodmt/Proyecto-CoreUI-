<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sysweb">
    <meta name="author" content="Aldo Torres">

    <link rel="shortcut icon" href="../../assets/img/favicon.ico" />
    <title>Sysweb - Recuperar</title>

    <!-- CoreUI CSS -->
    <link href="../../dist/css/coreui.min.css" rel="stylesheet">
    <link href="../../dist/css/themes/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons/css/all.min.css">

</head>

<body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="text-center mb-4">
                    <img src="../../assets/img/favicon.ico" alt="Sysweb" height="50">
                    <h1 style="color: #3c8dbc;">Recuperar contraseña</h1>
                </div>
                <!-- Alerts -->
                <?php
                if (!empty($_GET['alert'])) {
                    if ($_GET['alert'] == 1) {
                        echo "<div class='alert alert-warning' role='alert'>
                        <strong><i class='fa-solid fa-triangle-exclamation'></i> Error:</strong> Las contraseñas deben coincidir.
                        </div>";
                    }
                }
                ?>

                <!-- Login Form -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-3">
                            <i class="cil-user"></i> Recuperar su contraseña
                        </h5>
                        <?php
                        if (isset($_GET['email'])) {
                            $email = htmlspecialchars($_GET['email']);
                            ?>
                            <form action="proceso.php" method="POST">
                                <input type="hidden" name="email" value="<?= $email ?>">
                                <div class="mb-3">
                                    <label for="nuevo" class="form-label">Nueva contraseña</label>
                                    <input type="password" class="form-control" id="nuevo" name="nuevo"
                                        placeholder="Nueva contraseña" required>
                                </div>
                                <div class="mb-3">
                                    <label for="repetir" class="form-label">Repetir contraseña</label>
                                    <input type="password" class="form-control" id="repetir" name="repetir"
                                        placeholder="Repetir contraseña" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" name="Guardar">Guardar</button>
                            </form>
                        <?php } else { ?>
                            <p class="text-danger">Correo no válido. Intente de nuevo.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CoreUI JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.2.0/dist/js/coreui.min.js"
        integrity="sha384-c4nHOtHRPhkHqJsqK5SH1UkyoL2HUUhzGfzGkchJjwIrAlaYVBv+yeU8EYYxW6h5"
        crossorigin="anonymous"></script>
</body>

</html>