<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include 'config.php';

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  if (isset($_POST['no_control'])) {
    $consultaSQL = "SELECT * FROM list_espera WHERE no_control LIKE '%" . $_POST['no_control'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM list_espera";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $alumnos = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['no_control']) ? 'Lista de los alumnos en espera ' . $_POST['no_control'] . '' : 'Lista de los alumnos en espera';
?>

<?php include "templates/header.php"; ?>

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
      <a href="./index.php"  class="btn btn-primary mt-4">Home</a>
      <hr>
      <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input type="text" id="no_control" name="no_control" placeholder="Buscar por N. Control" class="form-control">
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
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>Numero de Control</th>
            <th>Nombre</th>
            <th>Carrera</th>
            <th>Modulo</th>
            <th>Semestre</th>
            <th>Argumento</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($alumnos && $sentencia->rowCount() > 0) {
            foreach ($alumnos as $fila) {
              ?>
              <tr>
                <td><?php echo escapar($fila["no_control"]); ?></td>
                <td><?php echo escapar($fila["Nombre"]); ?></td>
                <td><?php echo escapar($fila["carrera"]); ?></td>
                <td><center><?php echo escapar($fila["modulo"]); ?></center></td>
                <td><center><?php echo escapar($fila["semestre"]); ?></center></td>
                <td><?php echo escapar($fila["argumento"]); ?></td>
                <td><center><?php echo escapar($fila["created_at"]); ?></center></td>
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

<?php include "templates/footer.php"; ?>