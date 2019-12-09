<?php
use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utils;

require __DIR__ . '/../vendor/autoload.php';

// Carga las variables de entorno
Utils::loadEnv(__DIR__ . '/../');

$entityManager = Utils::getEntityManager();

if ($argc < 3 || $argc > 4) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN
$argc
    Usage: $fich <UserId> username | email | password <newValue>

MARCA_FIN;
    exit(0);
}
$userId       = (int) $argv[1];
$newAtribute       = (string) $argv[2];
$newValue       = (string) $argv[3];

$user = $entityManager
    ->getRepository(User::class)
    ->findOneBy(['id' => $userId]);

if (null === $user) {
    echo "Usuario $userId no encontrado" . PHP_EOL;
    exit(0);
}


try {
    if($newAtribute === 'username') {
        $user->setUsername($newValue);
        $entityManager->persist($user);
        $entityManager->flush();
    } elseif($newAtribute === 'email'){
        $user->setEmail($newValue);
        $entityManager->persist($user);
        $entityManager->flush();
    } elseif($newAtribute === 'password'){
        $user->setPassword($newValue);
        $entityManager->persist($user);
        $entityManager->flush();
    }
    else{
        echo "Atributo $newAtribute no encontrado, use: username, email or password." . PHP_EOL;
        exit(0);
    }
    echo 'Updated user with ID ' . $user->getId()
        . ' USER ' . $user->getUsername() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage();
}