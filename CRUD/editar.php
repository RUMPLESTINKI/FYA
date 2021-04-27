<?php
include 'funciones.php';
csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$config = include 'config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id_alumn'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El alumno no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $alumno = [
      "id_alumn"          => $_GET['id_alumn'],
      "no_control"        => $_POST['no_control'],
      "Nombre"            => $_POST['Nombre'],
      "carrera"           => $_POST['carrera'],
      "promedio_ingles"   => $_POST['promedio_ingles'],
      "semestre"          => $_POST['semestre'],
      "password"          => $_POST['password']
    ];
    
    $consultaSQL = "UPDATE alumnos SET 
        no_control = :no_control,
        Nombre = :Nombre,
        carrera = :carrera,
        promedio_ingles = :promedio_ingles,
        semestre = :semestre,
        password = :password,
        updated_at = NOW()
        WHERE id_alumn = :id_alumn";

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($alumno);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id_alumn'];
  $consultaSQL = "SELECT * FROM alumnos WHERE id_alumn =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $alumno = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$alumno) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el alumno';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

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
if (isset($alumno) && $alumno) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el alumno <br> <?= escapar($alumno['Nombre']) . ' ' . escapar($alumno['no_control'])  ?></h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="Nombre">Nombre</label>
            <input type="text" name="Nombre" id="Nombre" value="<?= escapar($alumno['Nombre']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="no_control">Numero de control</label>
            <input type="text" name="no_control" id="no_control" value="<?= escapar($alumno['no_control']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="carrera">Carrera</label>
            <select name="carrera" id="carrera" value="<?= escapar($alumno['carrera']) ?>" class="form-control">
                <option value=""><?= escapar($alumno['carrera']) ?></option>
                <option value="Ing. en Sistemas Computacionales">Ing. en Sistemas Computacionales</option>
                <option value="Ing. Industrial">Ing. Industrial</option>
                <option value="Ing. en Gestion Empresarial">Ing. en Gestion Empresarial</option>
                <option value="Ing. en Industrias Alimentarias">Ing. en Industrias Alimentarias</option>
                <option value="Ing. Ambiental">Ing. Ambiental</option>
                <option value="Ing. Agronomia">Ing. Agronomia</option>
            <select>
          </div>
          <div class="form-group">
            <label for="promedio_ingles">Promedio</label>
            <input type="text" name="promedio_ingles" id="promedio_ingles" value="<?= escapar($alumno['promedio_ingles']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="semestre">Semestre</label>
            <select name="semestre" id="semestre" class="form-control">
                <option><?= escapar($alumno['semestre']) ?></option>
                <option value="1">Primer Semestre</option>
                <option value="2">Segundo Semestre</option>
                <option value="3">Tercer Semestre</option>
                <option value="4">Cuarto Semestre</option>
                <option value="5">Quinto Semestre</option>
                <option value="6">Sexto Semestre</option>
                <option value="7">Septimo Semestre</option>
                <option value="8">Octavo Semestre</option>
                <option value="9">Noveno Semestre</option>
                <option value="10">Decimi Semestre</option>
                <option value="11">Undecimo Semestre</option>
                <option value="12">Duodecimo Semestre</option>
            <select>
        </div>
          <div class="form-group">
            <label for="password">Pasword</label>
            <input type="text" name="password" id="password" value="<?= escapar($alumno['password']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "templates/footer.php"; ?>