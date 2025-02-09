<?php


// $env = parse_ini_file(__DIR__ . "/../.env");

return [
  "database" => [
    "host" => getenv("DB_HOST"),
    "port" => getenv("DB_PORT"),
    "dbname" => getenv("DB_NAME"),
    "user" => getenv("DB_USER"),
    "password" => getenv("DB_PASSWORD")
  ],
  "imageKit" => [
    "publicKey" => getenv("IMAGEKIT_PUBLIC_KEY"),
    "privateKey" => getenv("IMAGEKIT_PRIVATE_KEY"),
    "urlEndPoint" => getenv("IMAGEKIT_URL_END_POINT")
  ]
];
