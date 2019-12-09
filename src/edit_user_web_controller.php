<html>
<header>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body{
            background-color: #4988ca85;
        }
    </style>
</header>
<body>
<nav class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a id="index" class="nav-link" href="./list_result_web.php" >List Results<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a id="services" class="nav-link" href="./list_users_web.php" >List Users</a>
            </li>
            <li class="nav-item">
                <a id="install" class="nav-link" href="./create_user_web.php">Create User</a>
            </li>
            <li class="nav-item">
                <a id="reserva" class="nav-link" href="./create_result_web.php">Create Result</a>
            </li>
            <li class="nav-item">
                <a id="reserva" class="nav-link" href="./show_result_web.php">Show Results</a>
            </li>
            <li class="nav-item">
                <a id="reserva" class="nav-link" href="./show_user_web.php">Show Users</a>
            </li>
        </ul>
    </div>
</nav>

<?php
use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utils;

require __DIR__ . '/../vendor/autoload.php';

// Carga las variables de entorno
Utils::loadEnv(__DIR__ . '/../');

$entityManager = Utils::getEntityManager();

$result = $entityManager
    ->getRepository(Result::class)
    ->findOneBy(['id' => $resultId]);

$id= (int) $_POST['id'];
$username= (string) $_POST['username'];
$email= (string) $_POST['email'];

$user =$entityManager
    ->getRepository(User::class)
    ->findOneBy(['id' => $id]);




$user->setUsername($username);
$user->setEmail($email);




try {
    $entityManager->persist($user);
    $entityManager->flush();
    echo 'User updated';
} catch (Exception $exception) {
    echo $exception->getMessage();
}
?>
</body>
</html>