<?php

// کدهای ANSI برای رنگ‌ها
$colors = [
    'green' => "\033[32m",
    'yellow' => "\033[33m",
    'red' => "\033[31m",
    'reset' => "\033[0m"
];

// دریافت آرگومان‌های خط فرمان
$command = isset($argv[1]) ? $argv[1] : null;
$port = 8585; // پورت پیش‌فرض

// بررسی اینکه آیا آرگومان پورت دریافت شده یا خیر
if (isset($argv[2]) && $argv[2] == '-p' && isset($argv[3])) {
    $port = $argv[3];
}

switch ($command) {
    case 'run':
        echo "[{$colors['green']}Running{$colors['reset']}] on port " . $port . "\n";
        exec("php -S localhost:" . $port . " -t public");
        break;

    case 'stop':
        echo "[{$colors['red']}Stopping{$colors['reset']}] the server (This is just an example, implement actual logic).\n";
        break;

    case 'restart':
        echo "[{$colors['yellow']}Restarting{$colors['reset']}] the server on port " . $port . "\n";
        exec("php -S localhost:" . $port . " -t public");
        break;

    default:
        echo $colors['red'] . "Unknown command. Use 'run', 'stop', or 'restart'.\n" . $colors['reset'];
        break;
}
