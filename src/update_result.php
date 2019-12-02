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
$resultId       = (int) $argv[1];
$newAtribute       = (int) $argv[2];
$result = $entityManager
    ->getRepository(Result::class)
    ->findOneBy(['id' => $resultId]);

if (null === $result) {
    echo "Resultado $resultId no encontrado" . PHP_EOL;
    exit(0);
}


try {

    $result->setResult($newAtribute);
    $entityManager->persist($result);
    $entityManager->flush();
    echo 'Updated user with ID ' . $result->getId() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage();
}