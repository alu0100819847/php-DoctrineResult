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
/**
 * PHP version 7.3
 * demoRouting - demoRouting/src/index.php
 */

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\RouteCollection;



// Directorios que contienen la definición de las rutas
const DIRECTORIES = [ __DIR__ . '/../config' ];

// Nombre del fichero con las rutas
const ROUTES_FILE = 'routes.yml';

// Empleando el componente symfony/config cargamos todas las rutas
$locator = new FileLocator(DIRECTORIES);
$loader  = new YamlFileLoader($locator);
/** @var RouteCollection $routes */
$routes  = $loader->load(ROUTES_FILE);

// obtenermos el contexto de la petición HTTP
$requestContext = new RequestContext(filter_input(INPUT_SERVER, 'REQUEST_URI'));

// Busca la información de la ruta para la petición
$matcher = new UrlMatcher($routes, $requestContext);

// Trabajo hecho. Ahora mostramos la información asociada a la petición
$path_info = filter_input(INPUT_SERVER, 'PATH_INFO') ?? '/';

try {
    $parameters = $matcher->match($path_info);
    $action = $parameters['_controller'];
    //$action();   # no logrado


} catch (ResourceNotFoundException $e) {
    echo 'Caught exception: The resource could not be found' . PHP_EOL;
} catch (MethodNotAllowedException $e) {
    echo 'Caught exception: the resource was found but the request method is not allowed'. PHP_EOL;
}
?>
    </body>
</html>