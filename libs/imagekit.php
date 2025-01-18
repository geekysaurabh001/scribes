<?php


$config = require basePath("config.php");
require basePath("vendor/autoload.php");

use ImageKit\ImageKit;

$imagekit = new ImageKit(
  $config["imageKit"]["publicKey"],
  $config["imageKit"]["privateKey"],
  $config["imageKit"]["urlEndPoint"],
);

$fileErrors = [
  "UPLOAD_ERR_OK" => 'There is no error, the file uploaded with success', // UPLOAD_ERR_OK = 0
  "UPLOAD_ERR_INI_SIZE" => 'The uploaded file exceeds the upload_max_filesize directive in php.ini', // UPLOAD_ERR_INI_SIZE = 1
  "UPLOAD_ERR_FORM_SIZE" => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', // UPLOAD_ERR_FORM_SIZE = 2
  "UPLOAD_ERR_PARTIAL" => 'The uploaded file was only partially uploaded', // UPLOAD_ERR_PARTIAL = 3
  "UPLOAD_ERR_NO_FILE" => 'No file was uploaded', // UPLOAD_ERR_NO_FILE = 4
  "UPLOAD_ERR_NO_TMP_DIR" => 'Missing a temporary folder', // UPLOAD_ERR_NO_TMP_DIR = 6
  "UPLOAD_ERR_CANT_WRITE" => 'Failed to write file to disk.', // UPLOAD_ERR_CANT_WRITE = 7
  "UPLOAD_ERR_EXTENSION" => 'A PHP extension stopped the file upload.', // UPLOAD_ERR_EXTENSION = 8
];

if (!function_exists("formatFilename")) {
  function formatFileName($fileName)
  {
    // Remove the file extension
    $nameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    // Replace dashes and underscores with underscores
    $nameWithSpaces = str_replace(['-', '_'], '_', $nameWithoutExtension);
    return $nameWithSpaces . '_image.' . $extension;
  }
}

if (!function_exists("uploadFile")) {
  function uploadFile() {}
}
