<?php

require basePath("vendor/autoload.php");

if (file_exists(basePath(".env"))) {
  $dotenv = Dotenv\Dotenv::createImmutable(basePath(""));
  $dotenv->load();
}

return [
  "database" => [
    "host" => getenv("DB_HOST") ?: $_ENV["DB_HOST"],
    "port" => getenv("DB_PORT") ?: $_ENV["DB_PORT"],
    "dbname" => getenv("DB_NAME") ?: $_ENV["DB_NAME"],
    "user" => getenv("DB_USER") ?: $_ENV["DB_USER"],
    "password" => getenv("DB_PASSWORD") ?: $_ENV["DB_PASSWORD"]
  ],
  "imageKit" => [
    "publicKey" => getenv("IMAGEKIT_PUBLIC_KEY") ?: $_ENV["IMAGEKIT_PUBLIC_KEY"],
    "privateKey" => getenv("IMAGEKIT_PRIVATE_KEY") ?: $_ENV["IMAGEKIT_PRIVATE_KEY"],
    "urlEndPoint" => getenv("IMAGEKIT_URL_END_POINT") ?: $_ENV["IMAGEKIT_URL_END_POINT"]
  ]
];
