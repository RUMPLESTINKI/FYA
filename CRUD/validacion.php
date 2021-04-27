<?php

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El alumno ' . escapar($_POST['nombre']) . ' ha sido agregado con éxito'
  ];

  $config = include 'config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $alumno = [
      "no_control"        => $_POST['no_control'],
      "Nombre"            => $_POST['Nombre'],
      "carrera"           => $_POST['carrera'],
      "promedio_ingles"   => $_POST['promedio_ingles'],
      "semestre"          => $_POST['semestre'],
      "password"          => $_POST['password'],
    ];

    $consultaSQL = "INSERT INTO alumnos (no_control, Nombre, carrera, promedio_ingles, semestre, password)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($alumno)) . ")"; 

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($alumno);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include 'templates/header.php'; ?>

<?php
if (isset($resultado)) {
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
// define variables and set to empty values
$NombreErr = $no_controlErr = $promedio_inglesErr = $semestreErr = $passwordErr = "";
$Nombre = $no_control = $carrera = $promedio_ingles = $semestre = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["Nombre"])) {
    $NombreErr = "Se necesita introducir un nombre";
  } else {
    $Nombre = test_input($_POST["Nombre"]);
  }
  
  if (empty($_POST["no_control"])) {
    $no_controlErr = "Falta ingresar el Numero de control";
  } else {
    $no_control = test_input($_POST["no_control"]);
  }
    
  if (empty($_POST["carrera"])) {
    $carreraErr = "Seleccione una carrera";
  } else {
    $carrera = test_input($_POST["carrera"]);
  }

  if (empty($_POST["promedio_ingles"])) {
    $promedio_inglesErr = "Ingrese el promedio";
  } else {
    $promedio_ingles = test_input($_POST["promedio_ingles"]);
  }

  if (empty($_POST["semestre"])) {
    $semestreErr = "Seleccione un un semestre";
  } else {
    $semestre = test_input($_POST["semestre"]);
  }

  if (empty($_POST["password"])) {
    $passwordErr = "Ingrese una contraseña";
  } else {
    $password = test_input($_POST["password"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<style>
.error {color: #FF0000;}
</style>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Crea un alumno</h2>
      <hr>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
          <label for="Nombre">Nombre</label>
          <input type="text" name="Nombre" id="Nombre"  class="form-control">
          <span class="error"> <?php echo $NombreErr;?></span>
        </div>
        <div class="form-group">
          <label for="no_control">Numero de Control</label>
          <input type="text" name="no_control" id="no_control" class="form-control">
          <span class="error"> <?php echo $no_controlErr;?></span>
        </div>
        <div class="form-group">
          <label for="carrera">Carrera</label>
          <select name="carrera" id="carrera" class="form-control">
              <option value="">Seleccione la carrera</option>
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
          <input type="text" name="promedio_ingles" id="promedio_ingles" class="form-control">
          <span class="error"> <?php echo $promedio_inglesErr;?></span>
        </div>
        <div class="form-group">
          <label for="semestre">Semestre</label>
          <select name="semestre" id="semestre" class="form-control">
              <option value="">Seleccione tu Semestre</option>
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
          <label for="password">Contraseña</label>
          <input type="text" name="password" id="password" class="form-control">
          <span class="error"> <?php echo $passwordErr;?></span>
        </div>
        <div class="form-group">
          <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>

















<?php include 'funciones.php';?>

<?php
$output = NULL;
$Nombre = "";
$no_control = "";
$carrera = "";
$semestre = "";
if (isset($_POST['submit'])){
	//Database connection
	$mysqli = NEW MySQLi('localhost', 'root', '', 'fya');
	$Nombre = $mysqli->real_escape_string($_POST['Nombre']);
	$no_control = $mysqli->real_escape_string($_POST['no_control']);
	$carrera = $mysqli->real_escape_string($_POST['carrera']);
  $semestre = $mysqli->real_escape_string($_POST['semestre']);

	$query = $mysqli->query("SELECT * FROM alumnos WHERE no_control = '$no_control'");
	if (empty($Nombre) OR empty($no_control) OR empty($carrera) OR empty($semestre)) {
		$output = "Por favor llena todos los campos.";
	}elseif (strlen($no_control)!= 8) {
		$output = "El número de control tiene que ser de 8 caracteres.";
	}
	elseif ($query->num_rows !=0) {
		$output = "Ese número de control ya está registrado.";
	}else{
		$insert = $mysqli->query("INSERT INTO alumnos (id_alumn, no_control, Nombre, carrera, promedio_ingles, semestre, password) 
                            VALUES (NULL, '$no_control', '$Nombre', '$carrera', NULL, $semestre, NULL)");
		if ($insert != TRUE) {
			$output = "Hubo un error <br />";
			$output .=$mysqli->error;
		}else{
			$output = "Se ha registrado correctamente!";
		}
	}
}
?>

<?php include 'templates/header.php'; ?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Crea un alumno</h2>
      <hr>
      <form >
        <div class="form-group">
          <label for="Nombre">Nombre</label>
          <input type="text" name="Nombre" id="Nombre"  class="form-control">
        </div>
        <div class="form-group">
          <label for="no_control">Numero de Control</label>
          <input type="text" name="no_control" id="no_control" class="form-control">
        </div>
        <div class="form-group">
          <label for="carrera">Carrera</label>
          <select name="carrera" id="carrera" class="form-control">
              <option value="">Seleccione la carrera</option>
              <option value="Ing. en Sistemas Computacionales">Ing. en Sistemas Computacionales</option>
              <option value="Ing. Industrial">Ing. Industrial</option>
              <option value="Ing. en Gestion Empresarial">Ing. en Gestion Empresarial</option>
              <option value="Ing. en Industrias Alimentarias">Ing. en Industrias Alimentarias</option>
              <option value="Ing. Ambiental">Ing. Ambiental</option>
              <option value="Ing. Agronomia">Ing. Agronomia</option>
          <select>
        </div>
        <div class="form-group">
          <label for="semestre">Semestre</label>
          <select name="semestre" id="semestre" class="form-control">
              <option value="">Seleccione tu Semestre</option>
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
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
echo $output;
?>


<?php include 'templates/footer.php'; ?>



















<?php
echo $output;
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Crea un alumno</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="Nombre">Nombre</label>
          <input type="text" name="Nombre" id="Nombre"  class="form-control" value="<?php echo $Nombre; ?>">
        </div>
        <div class="form-group">
          <label for="no_control">Numero de Control</label>
          <input type="text" name="no_control" id="no_control" class="form-control" value="<?php echo $no_control; ?>">
        </div>
        <div class="form-group">
          <label for="carrera">Carrera</label>
          <select name="carrera" id="carrera" class="form-control">
              <option value="">Seleccione la carrera</option>
              <option value="Ing. en Sistemas Computacionales" <?php if($carrera == "Ing. en Sistemas Computacionales") echo "selected" ?>>Ing. en Sistemas Computacionales</option>
              <option value="Ing. Industrial">Ing. Industrial</option>
              <option value="Ing. en Gestion Empresarial">Ing. en Gestion Empresarial</option>
              <option value="Ing. en Industrias Alimentarias">Ing. en Industrias Alimentarias</option>
              <option value="Ing. Ambiental">Ing. Ambiental</option>
              <option value="Ing. Agronomia">Ing. Agronomia</option>
          <select>
        </div>
        <div class="form-group">
          <label for="semestre">Semestre</label>
          <select name="semestre" id="semestre" class="form-control">
              <option value="">Seleccione tu Semestre</option>
              <option value="1" <?php if($semestre == "1") echo "selected" ?> >Primer Semestre</option>
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
          <label for="password">Contraseña</label>
          <input type="text" name="password" id="password" class="form-control" value="<?php echo $no_control; ?>">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>