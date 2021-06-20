<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';
(new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
