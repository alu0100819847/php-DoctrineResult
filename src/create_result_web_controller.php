<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utils;

require __DIR__ . '/../vendor/autoload.php';
Utils::loadEnv(__DIR__ . '/../');

$entityManager = Utils::getEntityManager();

$user = $_POST['user'];
$result = $_POST['result'];
$date = new DateTime($_POST['date']) ?? new DateTime('now');

$selected_user = $entityManager
    ->getRepository(User::class)
    ->findOneBy(['id' => $user]);

if(null === $selected_user){
    echo "Error al encontrar el usuario $user." . PHP_EOL;
    exit(0);
}
    echo $selected_user;
$new_result = new Result($result, $selected_user, $date);


try {
    $entityManager->persist($new_result);
    $entityManager->flush();
    echo 'Created Result with ID ' . $new_result->getId() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage();
}


?>
</body>
</html>