<?php

namespace Http\Forms;

use Core\FileUploader;
use Core\Validator;
use Dotenv\Parser\Value;

class NotesForm
{
  protected $notes = [];
  protected $errors = [];
  protected $db;

  protected $thumbnailPath = NULL;
  protected $thumbnailUrl = NULL;
  protected $featuredImagePath = NULL;
  protected $featuredImageUrl = NULL;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function create() {}

  public function fetchAllNotes(string $id)
  {
    $stmt = $this->db->query('SELECT notes.public_id as "publicId", title FROM notes JOIN users ON notes.user_id = users.id WHERE users.id= :id')
      ->execute([":id" => $id]);

    if ($stmt) {
      $notes = $stmt->fetchAll();
      if (!Validator::array($notes)) {
        return false;
      }
      $this->notes = $notes;
      return true;
    }

    return false;
  }

  public function getNotes()
  {
    return $this->notes;
  }

  public function validateFormNoteEntries(string $title, string $description, string $content)
  {
    if (!Validator::string($title, 1, 255)) {
      $this->errors["title"] = "Title is missing!";
    }
    if (!Validator::string($description, 1, 255)) {
      $this->errors["description"] = "Description is missing!";
    }
    if (!Validator::string($content, 1, 1024)) {
      $this->errors["content"] = "Content is missing!";
    }
    return empty($this->errors);
  }

  public function getNotesFormErrors()
  {
    return $this->errors;
  }

  public function validateUser()
  {
    return Validator::array($_SESSION) && Validator::array($_SESSION["user"]) && Validator::string($_SESSION["user"]["id"], 1, 1);
  }

  public function validateFormFiles(string $thumbnailFile, string $featuredImageFile)
  {

    require basePath("libs/imagekit.php");
    $fileUploader = new FileUploader($imagekit);
    $thumbnail = $fileUploader->uploadFile($_FILES, "/php-notes-app", $thumbnailFile);
    $featuredImage = $fileUploader->uploadFile($_FILES, "/php-notes-app", $featuredImageFile);

    if ($thumbnail) {
      $this->thumbnailPath = $thumbnail["filePath"];
      $this->thumbnailUrl = $thumbnail["url"];
    }

    if ($featuredImage) {
      $this->featuredImagePath = $featuredImage["filePath"];
      $this->featuredImageUrl = $featuredImage["url"];
    }

    $fileErrors = $fileUploader->getErrors();

    if (!Validator::array($fileErrors)) {
      return false;
    }

    if (Validator::array($fileErrors)) {
      if ($fileErrors[$thumbnailFile])
        $this->errors[] = $fileErrors[$thumbnailFile];
      if ($fileErrors[$featuredImageFile])
        $this->errors[] = $fileErrors[$featuredImageFile];
    }
    return empty($this->errors) || $thumbnail || $featuredImage;
  }

  public function insertDataWithoutFiles(string $title, string $description, string $content, string $userId)
  {
    return $this->db->query("INSERT INTO notes (title, description, content, user_id, public_id) VALUES(:title, :description, :content, :userId, :publicId)")->execute([":title" => $title, ":description" => $description, ":content" => $content, ":userId" => $userId]);
  }

  public function insertDataWithFiles(string $title, string $description, string $content, string $userId)
  {
    dd($this->thumbnailPath);
    if ($this->thumbnailPath && $this->thumbnailUrl && $this->featuredImagePath && $this->featuredImageUrl) {
      return $this->db->query("INSERT INTO notes (title, description, content, user_id, public_id, thumbnail_url, thumbnail_path, featured_image_url, featured_image_path) VALUES(:title, :description, :content, :userId, :publicId, :thumbnailUrl, :thumbnailPath, :featuredImageUrl, :featuredImagePath)")->execute([":title" => $title, ":description" => $description, ":content" => $content, ":userId" => $userId, ":thumbnailUrl" => $this->thumbnailUrl, ":thumbnailPath" => $this->thumbnailPath, ":featuredImageUrl" => $this->featuredImageUrl, ":featuredImagePath" => $this->featuredImagePath]);
    }
    return false;
  }
}
