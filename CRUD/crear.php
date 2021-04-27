<?php include 'funciones.php';?>

<?php
$output = NULL;
$Nombre = "";
$no_control = "";
$carrera = "";
$semestre = "";
$Contraseña = "";
if (isset($_POST['submit'])){
	//Database connection
	$mysqli = NEW MySQLi('localhost', 'root', '', 'fya');
	$Nombre = $mysqli->real_escape_string($_POST['Nombre']);
	$no_control = $mysqli->real_escape_string($_POST['no_control']);
	$carrera = $mysqli->real_escape_string($_POST['carrera']);
  $semestre = $mysqli->real_escape_string($_POST['semestre']);
  $Contraseña = $mysqli->real_escape_string($_POST['Contraseña']);

	$query = $mysqli->query("SELECT * FROM alumnos WHERE no_control = '$no_control'");
	if (empty($Nombre) OR empty($no_control) OR empty($carrera) OR empty($semestre) OR empty($Contraseña)) {
		$output = "<h5 style=color:red;> Por favor llena todos los campos.</h5>";
	}elseif (strlen($no_control)!= 8) {
		$output = "<h5 style=color:red;> El número de control tiene que ser de 8 caracteres. </h5>";
	}
  elseif ($query->num_rows !=0) {
		$output = "<h5 style=color:red;> Ese número de control ya está registrado. </h5>";
  }elseif (strlen($Contraseña) < 5) {
    $output = "<h5 style=color:red;> La contraseña debe de contar con mas de 5 caracteres. </h5>";
  }else{
		$insert = $mysqli->query("INSERT INTO alumnos (id_alumn, no_control, Nombre, carrera, promedio_ingles, semestre, password) 
                            VALUES (NULL, '$no_control', '$Nombre', '$carrera', NULL, '$semestre', '$Contraseña')");
		if ($insert != TRUE) {
			$output = "<h5 style=color:red;> Hubo un error </h5> <br/> ";
			$output .=$mysqli->error;
		}else{
			$output = "<h5 style=color:green;> Se ha registrado correctamente! </h5>";
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
      <?php echo $output ; ?>
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
              <option value="Ing. Industrial" <?php if($carrera == "Ing. Industrial") echo "selected" ?> >Ing. Industrial</option>
              <option value="Ing. en Gestion Empresarial" <?php if($carrera == "Ing. en Gestion Empresarial") echo "selected" ?> >Ing. en Gestion Empresarial</option>
              <option value="Ing. en Industrias Alimentarias" <?php if($carrera == "Ing. en Industrias Alimentarias") echo "selected" ?> >Ing. en Industrias Alimentarias</option>
              <option value="Ing. Ambiental" <?php if($carrera == "Ing. Ambiental") echo "selected" ?> >Ing. Ambiental</option>
              <option value="Ing. Agronomia" <?php if($carrera == "Ing. Agronomia") echo "selected" ?> >Ing. Agronomia</option>
          <select>
        </div>
        <div class="form-group">
          <label for="semestre">Semestre</label>
          <select name="semestre" id="semestre" class="form-control">
              <option value="">Seleccione tu Semestre</option>
              <option value="1" <?php if($semestre == "1") echo "selected" ?> >Primer Semestre</option>
              <option value="2" <?php if($semestre == "2") echo "selected" ?> >Segundo Semestre</option>
              <option value="3" <?php if($semestre == "3") echo "selected" ?> >Tercer Semestre</option>
              <option value="4" <?php if($semestre == "4") echo "selected" ?> >Cuarto Semestre</option>
              <option value="5" <?php if($semestre == "5") echo "selected" ?> >Quinto Semestre</option>
              <option value="6" <?php if($semestre == "6") echo "selected" ?> >Sexto Semestre</option>
              <option value="7" <?php if($semestre == "7") echo "selected" ?> >Septimo Semestre</option>
              <option value="8" <?php if($semestre == "8") echo "selected" ?> >Octavo Semestre</option>
              <option value="9" <?php if($semestre == "9") echo "selected" ?> >Noveno Semestre</option>
              <option value="10" <?php if($semestre == "10") echo "selected" ?> >Decimi Semestre</option>
              <option value="11" <?php if($semestre == "11") echo "selected" ?> >Undecimo Semestre</option>
              <option value="12" <?php if($semestre == "12") echo "selected" ?> >Duodecimo Semestre</option>
          <select>
        </div>
        <div class="form-group">
          <label for="Contraseña">Contraseña</label>
          <input type="text" name="Contraseña" id="Contraseña" class="form-control" value="<?php echo $Contraseña; ?>">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>


<?php include 'templates/footer.php'; ?>


