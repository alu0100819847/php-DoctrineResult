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

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utils;

require __DIR__ . '/../vendor/autoload.php';

// Carga las variables de entorno
Utils::loadEnv(__DIR__ . '/../');

$entityManager = Utils::getEntityManager();

if ($argc < 2 || $argc > 4) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN

    Usage: $fich <attr> <value> [<--json>]
    Attrs: id, user_id, result

MARCA_FIN;
    exit(0);
}

$attr    = (string) $argv[1];
$value       = (int) $argv[2];

/** @var User $user */
if($attr === 'id' || $attr === 'user_id' || $attr=== 'result'){



    if($attr === 'user_id'){
        /** @var User $user */
        $user = $entityManager
            ->getRepository(User::class)
            ->findOneBy(['id' => $value]);
        if (null === $user) {
            echo "Usuario $userId no encontrado" . PHP_EOL;
            exit(0);
        }
        $results = $entityManager
            ->getRepository(Result::class)
            ->findBy(['user' => $user]);
    }
    else {
        $results = $entityManager
            ->getRepository(Result::class)
            ->findBy([$attr => $value]);
    }


    if (in_array('--json', $argv, true)) {
        echo json_encode($results, JSON_PRETTY_PRINT);
    } else {
        $items = 0;
        echo PHP_EOL
            . sprintf('%3s - %3s - %22s - %s', 'Id', 'res', 'username', 'time')
            . PHP_EOL;
        $items = 0;
        /* @var Result $result */
        foreach ($results as $result) {
            echo $result . PHP_EOL;
            $items++;
        }
        echo PHP_EOL . "Total: $items results.";
    }




}