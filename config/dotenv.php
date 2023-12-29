<?php

function loadEnv($path = '.env')
{
  $contents = file_get_contents($path);
  $lines = explode("\n", $contents);

  foreach ($lines as $line) {
    $line = trim($line);

    if ($line && strpos($line, '=') !== false) {
      list($key, $value) = explode('=', $line, 2);
      $key = trim($key);
      $value = trim($value);

      putenv("$key=$value");
    }
  }
}

loadEnv();
