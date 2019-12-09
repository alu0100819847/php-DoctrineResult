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
    Usage: $fich <resultId> userId | result <newValue> 

MARCA_FIN;
    exit(0);
}
$resultId       = (int) $argv[1];
$newAtribute       = (string) $argv[2];
$newValue       = (int) $argv[3];
$result = $entityManager
    ->getRepository(Result::class)
    ->findOneBy(['id' => $resultId]);

if (null === $result) {
    echo "Resultado $resultId no encontrado" . PHP_EOL;
    exit(0);
}


try {
    if($newAtribute === 'userId'){
        $user = $entityManager
            ->getRepository(User::class)
            ->findOneBy(['id' => $newValue]);

        if (null === $user) {
            echo "Usuario $userId no encontrado" . PHP_EOL;
            exit(0);
        }
        $result->setUser($user);
        $entityManager->persist($result);
        $entityManager->flush();
        echo 'Updated user with ID ' . $result->getId() . PHP_EOL;

    } elseif($newAtribute === 'result'){
        $result->setResult($newValue);
        $entityManager->persist($result);
        $entityManager->flush();
        echo 'Updated result with ID ' . $result->getId() . PHP_EOL;
    } else {
        echo "Atributo $newAtribute no encontrado, use: userId or result." . PHP_EOL;
        exit(0);
    }

} catch (Exception $exception) {
    echo $exception->getMessage();
}