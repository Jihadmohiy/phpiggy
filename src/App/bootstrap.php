<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use App\Config\Paths;
use Dotenv\Dotenv;

use function App\Config\{registerRoutes, registerMiddleware};

$dotenv = Dotenv::createImmutable(paths::ROOT);
$dotenv->load(); //enviro variables are accessibled by project now

$app = new App(Paths::SOURCE . "App/container-defintions.php");

registerRoutes($app);
registerMiddleware($app);

return $app;
