<?php
use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utils;
require __DIR__ . '/../vendor/autoload.php';

// Carga las variables de entorno

Utils::loadEnv(__DIR__ . '/../');

$entityManager = Utils::getEntityManager();

if ($argc < 1 || $argc > 2) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN
$argc
    Usage: $fich <UserId> <userNewName> 

MARCA_FIN;
    exit(0);
}
$userId       = (int) $argv[1];
$user = $entityManager
    ->getRepository(User::class)
    ->findOneBy(['id' => $userId]);

if (null === $user) {
    echo "Usuario $userId no encontrado" . PHP_EOL;
    exit(0);
}


try {


    $entityManager->remove($user);
    $entityManager->flush();
    echo 'User deleted';
} catch (Exception $exception) {
    echo $exception->getMessage();
}