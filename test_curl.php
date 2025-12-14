<?php
echo '<pre>';
echo "PHP SAPI: " . php_sapi_name() . PHP_EOL;
echo "PHP version: " . PHP_VERSION . PHP_EOL;
echo "Loaded php.ini: " . (php_ini_loaded_file() ?: 'none') . PHP_EOL;
echo "extension_dir: " . ini_get('extension_dir') . PHP_EOL;
echo "Curl extension loaded? ";
var_export(extension_loaded('curl'));
echo PHP_EOL;
echo "php -m contains curl? (for CLI)".PHP_EOL;
echo shell_exec('php -m');
echo PHP_EOL;
if (function_exists('curl_init')) {
    echo "curl_init exists. OK\n";
} else {
    echo "curl_init NOT found.\n";
}
echo '</pre>';
