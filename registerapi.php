<?php

include('connetion.php');

$configargs = array(
    "config" => "C:/xampp/php/extras/openssl/openssl.cnf",
    'private_key_bits' => 2048,
    'default_md' => "sha256",
);

$pass = $_POST['pass'];
$correo = $_POST['correo'];
$pass2 = $_POST['pass2'];
$nombre = $_POST['nombre'];

if($pass === $pass2){
    // Usar bcrypt para crear el hash de la contraseña

$generar=openssl_pkey_new($configargs);
openssl_pkey_export($generar, $keypriv, null, $configargs);
$keypub = openssl_pkey_get_details($generar);

openssl_public_encrypt($pass, $hash, $keypub['key']);

// file_put_contents('privada.key',$keypriv);
// file_put_contents('publica.key',$keypub['key']);

    $queryList = "INSERT INTO usuarios2(nombre, correo, pass, pri_key) VALUES ('".$nombre."', '".$correo."', '".$hash."', '".$keypriv."');";
    echo $queryList;
    $rsList = mysqli_query($conn, $queryList);

    if($rsList){
       header("Location: home.html");
    } else {
       header("Location: register.html");
    }
} else {
   header("Location: register.html");
}

?>
