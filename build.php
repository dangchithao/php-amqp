<?php

$dataConfig =  require(__DIR__ . '/config/env.php');

$config = "<?php \nreturn [\n";

foreach ($dataConfig as $key => $value) {
    if (is_numeric($value)) {
        $config .= "'{$key}' => $value, \n";
    } else {
        $config .= "'{$key}' => '$value', \n";
    }
}

$config .= "];";

$file = __DIR__ . '/runtime/cache/config.php';

$handle = fopen($file, 'w');
fwrite($handle, $config);
fclose($handle);

echo "Config file was created in: \n - {$file} \n";
