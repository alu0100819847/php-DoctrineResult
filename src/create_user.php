<?php
/**
 * PHP version 7.3
 * src\create_result.php
 *
 * @category Utils
 * @package  MiW\Results
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

use MiW\Results\Entity\User;
use MiW\Results\Utils;

require __DIR__ . '/../vendor/autoload.php';

// Carga las variables de entorno
Utils::loadEnv(__DIR__ . '/../');

$entityManager = Utils::getEntityManager();

if ($argc < 4 || $argc > 6) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN

    Usage: $fich <username> <email> <password> [<enabled>]

MARCA_FIN;
    exit(0);
}

$username    = (string) $argv[1];
$email       = (string) $argv[2];
$password       = (string) $argv[3];
$enabled     = (bool) $argv[4] ?? false;


$user = $entityManager
    ->getRepository(User::class)
    ->findOneBy(['username' => $username]);
if(null ==! $user){
    echo "Usuario $username ya existe." . PHP_EOL;
    exit(0);
}

$user = new User();
$user->setUsername($username);
$user->setEmail($email);
$user->setPassword($password);
$user->setEnabled($enabled);
$user->setIsAdmin(false);


try {
    $entityManager->persist($user);
    $entityManager->flush();
    echo 'Created User with ID ' . $user->getId() . PHP_EOL;
} catch (Exception $exception) {
    echo $exception->getMessage();
}