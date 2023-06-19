<?php
return [
  'paths' => ['*'],
  'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
  'allowed_origins' => ['*'],
  'allowed_origins_patterns' => [],
  'allowed_headers' => ['X-PINGOTHER', 'Content-Type', '*'],
  'exposed_headers' => [],
  'max_age' => 86400,
  'supports_credentials' => true,
];