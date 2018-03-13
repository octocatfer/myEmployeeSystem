<?php
date_default_timezone_set('America/Mexico_City');
$database = new mysqli('localhost','root','','sistema');

if ($database->connect_error != null) {
  echo 'Error: ' . $database->connect_error;
  exit();
} else {
  $database->set_charset('utf8');
  $sql = "SELECT id, nombre FROM empleados";
  $query = $database->query($sql);

  $fecha = date('Y-m-d');
  $sql = "SELECT id_empleado FROM entradas WHERE DATE(entrada) = '$fecha' AND estado = 'S'";
  $checarEmpleado = $database->query($sql);
  
  $sql = "SELECT a.nombre, b.entrada, b.salida
          FROM empleados a
          JOIN entradas b ON a.id = b.id_empleado
          WHERE DATE(b.entrada) = '$fecha'
          ORDER BY a.nombre";
  $lista = $database->query($sql);
  
  $trabajaron = [];
  while ($c = $checarEmpleado->fetch_assoc()) {
    $trabajaron[] = $c['id_empleado'];
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Entradas y salidas</title>
  <link rel="stylesheet" href="css/main.css">
  <script src="scripts/process.js"></script>
</head>
<body>
<div>
  <h1>Entradas y salidas</h1>
    <div class="fila">
      <div class="columna">
        <label for="empleado" class="titleLabel">Empleados</label>
        <?php if ($query->num_rows != count($trabajaron)) { ?>
        <select multiple="multiple" id="empleado">
          <?php while ($row = $query->fetch_assoc()) {
                if (!in_array($row['id'], $trabajaron)) { ?>
          <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
        <?php } else { ?>
        <p>Todos los empleados ya checaron su entrada y salida de este día</p>
        <p>Hasta mañana</p>
        <?php } ?>
      </div>
      <?php if ($query->num_rows != count($trabajaron)) { ?>
      <div class="columna">
        <h3>Acción</h3>
        <fieldset>
          <legend>¿Que desea hacer?</legend>
          <input type="radio" name="opcion" value="entrada">
          <label for="entrada">Checar entrada</label>
          <input type="radio" name="opcion" value="salida">
          <label for="salida">Checar salida</label>
        </fieldset>
        <div class="btn">
          <button id="checar">Checar</button>
        </div>
      </div>
      <?php } ?>
      <div class="columna">
        <div class="estado">
          <h3>Estado</h3>
          <?php if ($lista->num_rows > 0) { ?>
          <ul>
          <?php while ($row = $lista->fetch_assoc()) { ?>
          <li>
            <?php echo $row['nombre']; ?>
            <ul>
              <li>Entró a las: <?php echo date('g:i a', strtotime($row['entrada'])); ?></li>
              <?php if (!empty($row['salida'])) { ?>
              <li>Salió a las: <?php echo date('g:i a', strtotime($row['salida'])); ?></li>
              <?php } ?>
            </ul>
          </li>
          <?php } ?>
          </ul>
          <?php } else { ?>
          <p>Ningun empleado a checado su entrada</p>
          <?php } ?>
        </div>
      </div>
    </div>
</div>
</body>
</html>