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

if ($argc < 2 || $argc > 4) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN

    Usage: $fich <attr> <value> [<--json>]
    Attrs: id, email, username

MARCA_FIN;
    exit(0);
}

$attr    = (string) $argv[1];
$value       = (string) $argv[2];

/** @var User $user */
if($attr === 'id' || $attr === 'username' || $attr=== 'email'){
    $users = $entityManager
        ->getRepository(User::class)
        ->findBy([$attr => $value]);

    if (in_array('--json', $argv, true)) {
        echo json_encode($users, JSON_PRETTY_PRINT);
    } else {
        $items = 0;
        echo PHP_EOL . sprintf(
                '  %2s: %20s %30s %7s' . PHP_EOL,
                'Id', 'Username:', 'Email:', 'Enabled:'
            );
        /** @var User $user */
        foreach ($users as $user) {
            echo sprintf(
                '- %2d: %20s %30s %7s',
                $user->getId(),
                $user->getUsername(),
                $user->getEmail(),
                ($user->isEnabled()) ? 'true' : 'false'
            ),
            PHP_EOL;
            $items++;
        }

        echo "\nTotal: $items users.\n\n";
    }

}
