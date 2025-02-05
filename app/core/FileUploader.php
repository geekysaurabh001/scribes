<?php

namespace Core;

use Core\Validator;

class FileUploader
{
    private $imagekit;
    private $errors = [];

    private $fileErrors = [
        "UPLOAD_ERR_OK" => 'There is no error, the file uploaded with success', // UPLOAD_ERR_OK = 0
        "UPLOAD_ERR_INI_SIZE" => 'The uploaded file exceeds the upload_max_filesize directive in php.ini', // UPLOAD_ERR_INI_SIZE = 1
        "UPLOAD_ERR_FORM_SIZE" => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', // UPLOAD_ERR_FORM_SIZE = 2
        "UPLOAD_ERR_PARTIAL" => 'The uploaded file was only partially uploaded', // UPLOAD_ERR_PARTIAL = 3
        "UPLOAD_ERR_NO_FILE" => 'No file was uploaded', // UPLOAD_ERR_NO_FILE = 4
        "UPLOAD_ERR_NO_TMP_DIR" => 'Missing a temporary folder', // UPLOAD_ERR_NO_TMP_DIR = 6
        "UPLOAD_ERR_CANT_WRITE" => 'Failed to write file to disk.', // UPLOAD_ERR_CANT_WRITE = 7
        "UPLOAD_ERR_EXTENSION" => 'A PHP extension stopped the file upload.', // UPLOAD_ERR_EXTENSION = 8
    ];

    public function __construct($imagekit)
    {
        $this->imagekit = $imagekit;
    }

    public function uploadFile(array $file, string $folder, string $formName): ?array
    {
        if (!Validator::file($file)) {
            return null;
        }

        if (!!$file["error"]) {
            $this->errors[$formName] = $this->fileErrors[$file["error"]] ?? "Unknown error.";
            return null;
        }

        if (is_uploaded_file($file["tmp_name"])) {
            $upload = $this->imagekit->uploadFile([
                "file" => base64_encode(file_get_contents($file["tmp_name"])),
                "fileName" => $this->formatFileName($file["name"]),
                "folder" => $folder,
                "isPrivate" => false,
            ]);

            if (!empty($upload->error)) {
                $this->errors[$formName] = "File upload failed!";
                return null;
            }

            return [
                "filePath" => $upload->result->filePath,
                "url" => $upload->result->url,
            ];
        }

        $this->errors[$formName] = "Invalid file upload.";
        return null;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function formatFileName(string $fileName): string
    {
        $nameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $nameWithSpaces = str_replace(['-', '_'], '_', $nameWithoutExtension);
        return $nameWithSpaces . '_image.' . $extension;
    }
}
