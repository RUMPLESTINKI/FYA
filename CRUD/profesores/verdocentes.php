<?php
include '../funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include '../config.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  if (isset($_POST['CURP'])) {
    $consultaSQL = "SELECT * FROM profesores WHERE CURP LIKE '%" . $_POST['CURP'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM profesores";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $docente = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['CURP']) ? 'Lista de docentes ' . $_POST['CURP'] . '' : 'Lista de docentes';
?>

<?php include "../templates/header.php"; ?>

<?php
if ($error) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <a href="../index.php"  class="btn btn-primary mt-4">Home</a>
      <a href="createdocente.php"  class="btn btn-primary mt-4">Crear Docentes</a>
      <hr>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="CURP" name="CURP" placeholder="Buscar por CURP" class="form-control">
        </div>
        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
        <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"></h2>
      <table class="table">
        <thead>
          <tr>
            <th>CURP</th>
            <th>Nombre</th>
            <th>Contraseña</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($docente && $sentencia->rowCount() > 0) {
            foreach ($docente as $fila) {
              ?>
              <tr>
                <td><?php echo escapar($fila["CURP"]); ?></td>
                <td><?php echo escapar($fila["Nombre_profesor"]); ?></td>
                <td><?php echo escapar($fila["password"]); ?></td>
                <td>
                  <a href="<?= 'borrar.php?id_prof=' . escapar($fila["id_prof"]) ?>">🗑️Borrar</a>
                </td>
                <td>
                  <a href="<?= 'editar.php?id_prof=' . escapar($fila["id_prof"]) ?>">✏️Editar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>

<?php include "../templates/footer.php"; ?>