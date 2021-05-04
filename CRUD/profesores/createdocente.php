<?php include '../funciones.php';?>

<?php
$output = NULL;
$CURP = "";
$Nombre_profesor = "";
$password = "";

if (isset($_POST['submit'])){
	//Database connection
	$mysqli = NEW MySQLi('localhost', 'root', '', 'fya');
	$CURP = $mysqli->real_escape_string($_POST['CURP']);
	$Nombre_profesor = $mysqli->real_escape_string($_POST['Nombre_profesor']);
  $password = $mysqli->real_escape_string($_POST['password']);

	$query = $mysqli->query("SELECT * FROM profesores WHERE CURP = '$CURP'");
	if (empty($CURP) OR empty($Nombre_profesor OR empty($password))) {
		$output = "<h5 style=color:red;> Por favor llena todos los campos.</h5>";
	}elseif (strlen($CURP)!= 18) {
		$output = "<h5 style=color:red;> La CURP debe de tener 18 caracteres. </h5>";
	}elseif ($query->num_rows !=0) {
		$output = "<h5 style=color:red;> La CURP ya existe. </h5>";
  }elseif (strlen($password) < 5) {
    $output = "<h5 style=color:red;> La contraseña debe de contar con mas de 5 caracteres. </h5>";
  }else{
		$insert = $mysqli->query("INSERT INTO profesores (CURP, Nombre_profesor, password) 
                            VALUES ('$CURP', '$Nombre_profesor', '$password')");
		if ($insert != TRUE) {
			$output = "<h5 style=color:red;> Hubo un error </h5> <br/> ";
			$output .=$mysqli->error;
		}else{
			$output = "<h5 style=color:green;> Se ha registrado correctamente! </h5>";
		}
	}
}
?>

<?php include '../templates/header.php'; ?>


<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Crea un alumno</h2>
      <hr>
      <?php echo $output ; ?>
      <form method="post">
        <div class="form-group">
          <label for="CURP">CURP</label>
          <input type="text" name="CURP" id="CURP"  class="form-control" value="<?php echo $CURP; ?>">
        </div>
        <div class="form-group">
          <label for="Nombre_profesor">Nombre del Docente</label>
          <input type="text" name="Nombre_profesor" id="Nombre_profesor" class="form-control" value="<?php echo $Nombre_profesor; ?>">
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="text" name="password" id="password" class="form-control" value="<?php echo $password; ?>">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="verdocentes.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>


<?php include '../templates/footer.php'; ?>
