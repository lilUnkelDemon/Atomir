<?php

$colors = [
    'green' => "\033[32m",
    'yellow' => "\033[33m",
    'red' => "\033[31m",
    'reset' => "\033[0m"
];

$options = getopt("c:p:");

$command = isset($options['c']) ? $options['c'] : null;
$port = isset($options['p']) ? $options['p'] : 8585;

switch ($command) {
    case 'run':
        echo  "[{$colors['green']}Running{$colors['reset']}] on port " . $port . "\n" ;
        exec("php -S localhost:" . $port . " -t public");
        break;

    case 'stop':
        echo "[{$colors['red']}Stopping{$colors['reset']}] the server (This is just an example, implement actual logic).\n" ;
        break;

    case 'restart':
        echo "[{$colors['yellow']}Restarting{$colors['reset']}] the server on port " . $port . "\n"  ;
        exec("php -S localhost:" . $port . " -t public");
        break;

    default:
        echo $colors['red'] . "Unknown command.\n" . $colors['reset'];
        break;
}
