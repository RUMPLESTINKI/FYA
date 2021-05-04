<?php
include '../funciones.php';
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$config = include '../config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id_prof'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El profesor no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $profesor = [
      "id_prof"          => $_GET['id_prof'],
      "CURP"        => $_POST['CURP'],
      "Nombre_profesor"            => $_POST['Nombre_profesor'],
      "password"           => $_POST['password'],
    ];
    
    $consultaSQL = "UPDATE profesores SET 
        CURP = :CURP,
        Nombre_profesor = :Nombre_profesor,
        password = :password,
        updated_at = NOW()
        WHERE id_prof = :id_prof";

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($profesor);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id_prof'];
  $consultaSQL = "SELECT * FROM profesores WHERE id_prof =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $profesor = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$profesor) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el alumno';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "../templates/header.php"; ?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El alumno ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($profesor) && $profesor) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el alumno <br> <?= escapar($profesor['CURP']) . ' ' . escapar($profesor['CURP'])  ?></h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="CURP">CURP</label>
            <input type="text" name="CURP" id="CURP" value="<?= escapar($profesor['CURP']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="Nombre_profesor">Numero de control</label>
            <input type="text" name="Nombre_profesor" id="Nombre_profesor" value="<?= escapar($profesor['Nombre_profesor']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="password">Numero de control</label>
            <input type="text" name="password" id="password" value="<?= escapar($profesor['password']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="verdocentes.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "../templates/footer.php"; ?>