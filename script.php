<?php
include('datos.php');

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni = $_POST['dni'];
$modelo = $_POST['modelo'];
$fechaInicio = $_POST['fechaInicio'];
$duracion = $_POST['duracion'];

$nombre_ok;
$apellido_ok;
$dni_ok;
$usuario_ok;
$fechaInicio_ok;
$duracion_ok;
$disponibilidad_ok;

$nombre_ok = !empty($nombre);
$apellido_ok = !empty($apellido);
$dni_ok = validarDNI($dni);

$usuario_ok=false;
foreach(USUARIOS as $usuario) {
    if ($usuario['nombre']==$nombre && 
        $usuario['apellido']==$apellido && 
        $usuario['dni']==$dni) {
            $usuario_ok=true;
    }
}

$fechaInicio_ok = strtotime($fechaInicio) > time(); 
$duracion_ok = ($duracion >= 1 && $duracion <= 30);

$disponibilidad_ok=false;
foreach($coches as $coche) {
    if ($coche['modelo'] == $modelo ) {
        if($coche['disponible']){
            $disponibilidad_ok = true;
        }
    } 
}




// Si todas las validaciones son correctas, se procede a guardar la reserva
// (En este ejemplo, simplemente mostraremos un mensaje)
if ($usuario_ok && $fechaInicio_ok && $duracion_ok && $disponibilidad_ok) {
    pintar_reserva_ok($nombre, $apellido);
} else {
    pintar_reserva_fallida();
}



// FUNCION QUE VALIDA EL DNI.  RECIBE COMO PARAMETRO UN DNI
// CALCULA CON EL NÚMERO LA LETRA QUE LE CORRESPONDERÍA
// Y LA COMPARA CON LA LETRA QUE TRAE EL PROPIO DNI

function validarDNI($dni) {
    $letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
    $numero = substr($dni, 0, -1);
    $letra = strtoupper(substr($dni, -1));

    // Calculamos el resto
    $resto = $numero % 23;

    // Comparamos la letra calculada con la letra del DNI
    return $letra == $letras[$resto];
}


// Funcion que genera la salida si la reserva es OK
function pintar_reserva_ok($nombre, $apellido) {
    echo '<html>';
    echo '<head>';
    echo '<title>Prueba de PHP</title>';
    echo '</head>';
    echo '<body>';
    echo '<h1>RESERVA CORRECTA</h1>';
    echo '<h2>Nombre del cliente: '.$nombre.' '.$apellido.' </h2> <br>';
    echo '<img src="img/coche.jpg" />';
    echo '</body>';
    echo '</html>';
}




// Función que genera la salida si la reserva es FALLIDA
function pintar_reserva_fallida() {
    global $nombre_ok, $apellido_ok, $dni_ok, $usuario_ok;
    global $fechaInicio_ok, $duracion_ok, $disponibilidad_ok;
    global $nombre, $apellido, $dni, $modelo, $fechaInicio, $duracion;
    echo '<html>';
    echo '<head>';
    echo '<title>Prueba de PHP</title>';
    echo '</head>';
    echo '<body>';
    echo '<h1>RESERVA FALLIDA</h1>';

    // NOMBRE
    if ($nombre_ok) {
        echo '<p style="color: green">'.$nombre.'</p>';
    } else {
        echo '<p style="color: red">Campo vacio</p>';
    }

    // APELLIDO
    if ($apellido_ok) {
        echo '<p style="color: green">'.$apellido.'</p>';
    } else {
        echo '<p style="color: red">Campo vacio</p>';
    }
    
    // DNI
    if ($dni_ok) {
        echo '<p style="color: green">'.$dni.'</p>';
    } else {
        echo '<p style="color: red">'.$dni.'</p>';
    }
    
    // USUARIO CORRECTO
    if ($usuario_ok) {
        echo '<p style="color: green">EL USUARIO ES CLIENTE</p>';
    } else {
        echo '<p style="color: red">EL USUARIO NO ES CLIENTE O SE HAN METIDO MAL LOS DATOS</p>';
    }
    
    // MODELO DE COCHE
    echo '<p style="color: green">'.$modelo.'</p>';

    // FECHA DE INICIO
    if ($fechaInicio_ok) {
        echo '<p style="color: green">'.$fechaInicio.'</p>';
    } else {
        echo '<p style="color: red">'.$fechaInicio.'</p>';
    }

    // DURACIÓN
    if ($duracion_ok) {
        echo '<p style="color: green">'.$duracion.' dias</p>';
    } else {
        echo '<p style="color: red">'.$duracion.' dias</p>';
    }

    // DISPONIBILIDAD
    if ($disponibilidad_ok) {
        echo '<p style="color: green">EL COCHE ESTÁ DISPONIBLE</p>';
    } else {
        echo '<p style="color: red">EL COCHE NO ESTÁ DISPONIBLE</p>';
    }
    

    echo '</body>';
    echo '</html>';
}