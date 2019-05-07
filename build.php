<?php

$dataConfig =  require(__DIR__ . '/config/env.php');

$config = "<?php \nreturn [\n";

$config = buildConfig($dataConfig, $config);

$config .= "];";

$file = __DIR__ . '/runtime/cache/config.php';

$handle = fopen($file, 'w');
fwrite($handle, $config);
fclose($handle);

echo "Config file was created in: \n - {$file} \n";

function buildConfig(array $dataConfig, string $configGenerate)
{
    $newPartConfig = null;

    foreach ($dataConfig as $key => $value) {
        if (is_array($value)) {
            $newPartConfig .= "'{$key}' => [ \n";

            foreach ($value as $subKey => $subValue) {
                if (is_numeric($value)) {
                    $newPartConfig .= "'{$subKey}' => $subValue, \n";
                } else {
                    $newPartConfig .= "'{$subKey}' => '$subValue', \n";
                }
            }

            $newPartConfig .= "], \n";
            continue;
        }

        if (is_numeric($value)) {
            $newPartConfig .= "'{$key}' => $value, \n";
        } else {
            $newPartConfig .= "'{$key}' => '$value', \n";
        }
    }

    return $configGenerate . $newPartConfig;
}
