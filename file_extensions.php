<?php

echo "Loaded PHP Extensions:" . PHP_EOL;
foreach (get_loaded_extensions() as $extension) {
    echo $extension . PHP_EOL;
}
?>
