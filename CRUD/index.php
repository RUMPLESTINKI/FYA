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
    $consultaSQL = "SELECT * FROM alumnos WHERE no_control LIKE '%" . $_POST['no_control'] . "%'";
  } else {
    $consultaSQL = "SELECT * FROM alumnos";
  }

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $alumnos = $sentencia->fetchAll();

} catch(PDOException $error) {
  $error= $error->getMessage();
}

$titulo = isset($_POST['no_control']) ? 'Lista de alumnos ' . $_POST['no_control'] . '' : 'Lista de alumnos';
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
      <a href="crear.php"  class="btn btn-primary mt-4">Crear alumno</a>
      <a href="profesores/verdocentes.php"  class="btn btn-primary mt-4">Profesores</a>
      <a href="../CRUD/list_espera/index.php"  class="btn btn-primary mt-4">Soli. Lista Espera</a>
      <a href="view_list_espera.php"  class="btn btn-primary mt-4">Lista Espera</a>
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
            <th>Promedio</th>
            <th>Semestre</th>
            <th>Password</th>
            <th>Acciones</th>
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
                <td><center><?php echo escapar($fila["promedio_ingles"]); ?></center></td>
                <td><center><?php echo escapar($fila["semestre"]); ?></center></td>
                <td><?php echo escapar($fila["password"]); ?></td>
                <td>
                  <a href="<?= 'borrar.php?id_alumn=' . escapar($fila["id_alumn"]) ?>">🗑️Borrar</a>
                </td>
                <td>
                  <a href="<?= 'editar.php?id_alumn=' . escapar($fila["id_alumn"]) ?>">✏️Editar</a>
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

<?php include "templates/footer.php"; ?>