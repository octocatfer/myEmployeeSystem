<?php
date_default_timezone_set('America/Mexico_City');

if (isset($_POST['opcion']) && $_POST['opcion'] == 'e') {
  $id = $_POST['empleado'];
  $nip = $_POST['nip'];
  $db = new mysqli('localhost', 'root', '', 'sistema');
  $sql = "SELECT id FROM empleados WHERE id = '$id' AND nip = '$nip'";
  $query = $db->query($sql);

  if ($query->num_rows == 0) {
    echo $query->num_rows;
  } else {
    $fecha = date('Y-m-d');
    $sql = "SELECT id_empleado FROM entradas WHERE id_empleado = '$id' AND DATE(entrada) = '$fecha'";
    $query = $db->query($sql);

    if ($query->num_rows == 1) {
      echo "ok";
    } else {
      $sql = "INSERT INTO entradas (id_empleado, entrada) VALUES (?, NOW())";
      $query = $db->stmt_init();
      $query->prepare($sql);
      $query->bind_param('i', $id);
      $query->execute();
      echo $query->affected_rows;
    }
  }
} else if (isset($_POST['opcion']) && $_POST['opcion'] == 's') {
  $id = $_POST['empleado'];
  $nip = $_POST['nip'];
  $db = new mysqli('localhost', 'root', '', 'sistema');
  $sql = "SELECT id FROM empleados WHERE id = '$id' AND nip = '$nip'";
  $query = $db->query($sql);

  if ($query->num_rows == 0) {
    echo $query->num_rows;
  } else {
    $fecha = date('Y-m-d');
    $sql = "SELECT id_empleado FROM entradas WHERE id_empleado = '$id' AND DATE(entrada) = '$fecha'";
    $query = $db->query($sql);

    if ($query->num_rows > 0) {
      $sql = "SELECT id_empleado FROM entradas WHERE id_empleado = '$id' AND DATE(entrada) = '$fecha' AND estado = 'S'";
      $query = $db->query($sql);

      if ($query->num_rows == 1) {
        echo "ok";
      } else {
        $sql = "UPDATE entradas SET salida = NOW(), estado = 'S' WHERE id_empleado = ? AND DATE(entrada) = ?";
        $query = $db->stmt_init();
        $query->prepare($sql);
        $query->bind_param('is', $id, $fecha);
        $query->execute();
        echo $query->affected_rows;
      }
    } else {
      echo "no";
    }
  }
}