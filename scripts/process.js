window.onload = myFuncion;

function myFuncion() {
  var btn = document.getElementById('checar');

  if (btn) {
  btn.addEventListener('click', function() {
    var empleado = document.getElementById('empleado');
    if (empleado.selectedIndex == -1) {
      alert('Se debe seleccionar un empleado');
    } else {
      var opcion = document.getElementsByName('opcion');
      var grabar = new XMLHttpRequest();
      if (opcion[0].checked) {
        var nip = prompt('Teclee su NIP');
        if (nip.length > 0) {      
          var datos = 'opcion=e&empleado=' + empleado.value + '&nip=' + nip;
          grabar.open('post', 'grabar.php', true);
          grabar.onreadystatechange = function() {
            if (grabar.readyState == 4 && grabar.status == 200) {
              if (grabar.responseText == 1) {
                alert('Entrada agregada');
                window.location = 'index.php';
              } else if (grabar.responseText == 'ok') {
                alert('Ya ha checado su entrada');
              } else {
                alert('El NIP no es valido, vuelvalo a intentar!');
                console.log(grabar.responseText);
              }
            }
          }
          grabar.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          grabar.send(datos);
        } else {
          alert('No introdujo su nip');
        }
      } else if (opcion[1].checked) {
        var nip = prompt('Teclee su NIP');
        if (nip.length > 0) {  
          var datos = 'opcion=s&empleado=' + empleado.value + '&nip=' + nip;
          grabar.open('post', 'grabar.php', true);
          grabar.onreadystatechange = function() {
            if (grabar.readyState == 4 && grabar.status == 200) {
              if (grabar.responseText == 1) {
                alert('Salida registrada');
                window.location = 'index.php';
              } else if (grabar.responseText == 'ok') {
                alert('Ya ha checado su salida');
              } else if (grabar.responseText == 'no') {
                alert('Debe primero checar su entrada');
              } else {               
                alert('El NIP no es valido, vuelvalo a intentar!');
                console.log(grabar.responseText);
              }
            }
          }
          grabar.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          grabar.send(datos);
        } else {
          alert('No introdujo su nip');
        }
      } else {
        alert('Seleccione una opcion');
      }
    }
  });
  }
}