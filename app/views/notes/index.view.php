<?php view("partials/meta.php"); ?>
<?php view("partials/header.php"); ?>
<main class="flex-1  bg-gray-50">
  <section class="px-4 sm:px-0 bg-white text-black border-b border-solid border-b-gray-200 py-6">
    <div class="container mx-auto">
      <h1 class="text-3xl font-bold "><?= $heading ?></h1>
    </div>
  </section>
  <section class="container mt-4 mx-auto px-4 sm:px-0 flex flex-col items-start justify-start gap-2">
    <?php if (isset($errorMessage)): ?>
      <div class="bg-red-100 text-red-700 px-4 py-3 rounded">
        <p><?php echo htmlspecialchars($errorMessage); ?></p>
      </div>
    <?php else: ?>
      <?php if (empty($notes)): ?>
        <p>No notes</p>
      <?php endif; ?>
      <?php
      $count = 1;
      foreach ($notes as $note): ?>
        <a href="/note?id=<?= $note['publicId'] ?>" class="underline text-blue-500">
          <?php echo $count++ . ": " . $note['title']; ?>
        </a>
      <?php endforeach; ?>
    <?php endif; ?>
    <a href="/note/create" class="bg-gray-900 text-white px-4 py-3 rounded mt-6">Create Note</a>
  </section>
</main>
<?php view("partials/footer.php"); ?>