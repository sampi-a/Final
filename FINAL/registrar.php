<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "nombre_usuario";
$password = "contraseña";
$dbname = "nombre_base_de_datos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];

// Validar los datos
if (empty($nombre) || empty($apellido1) || empty($apellido2) || empty($email) || empty($login) || empty($password)) {
    die("Error: Todos los campos son obligatorios.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: El formato del correo electrónico no es válido.");
}

if (strlen($password) < 4 || strlen($password) > 8) {
    die("Error: La contraseña debe tener entre 4 y 8 caracteres.");
}

// Verificar si el email ya existe en la base de datos
$sql = "SELECT * FROM usuarios WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    die("Error: El correo electrónico ya está registrado.");
}

// Insertar los datos en la base de datos
$sql = "INSERT INTO usuarios (nombre, apellido1, apellido2, email, login, password)
        VALUES ('$nombre', '$apellido1', '$apellido2', '$email', '$login', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registro completado con éxito.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
