<?php

for ($a = 0; $a < 10; $a++) {
    foreach (['for 2', 'for 22'] as $key2 => $value2) {
        echo $value2;

        break 2;
    }

    echo $value1;
}