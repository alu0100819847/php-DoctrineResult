<?php
use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utils;

require __DIR__ . '/../vendor/autoload.php';

// Carga las variables de entorno
Utils::loadEnv(__DIR__ . '/../');

$entityManager = Utils::getEntityManager();

if ($argc < 2 || $argc > 3) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN
$argc
    Usage: $fich <UserId> <userNewName> 

MARCA_FIN;
    exit(0);
}
$userId       = (int) $argv[1];
$userNewName       = (string) $argv[2];
$user = $entityManager
    ->getRepository(User::class)
    ->findOneBy(['id' => $userId]);

if (null === $user) {
    echo "Usuario $userId no encontrado" . PHP_EOL;
    exit(0);
}


try {

    $user->setUsername($userNewName);
    $entityManager->persist($user);
    $entityManager->flush();
    echo 'Updated user with ID ' . $user->getId()
        . ' USER ' . $user->getUsername() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage();
}