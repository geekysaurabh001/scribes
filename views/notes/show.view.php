<?php view("partials/meta.php"); ?>
<?php view("partials/header.php"); ?>
<main class="flex-1  bg-gray-50">
  <section class="px-4 sm:px-0 bg-white text-black border-b border-solid border-b-gray-200 py-6">
    <div class="container mx-auto">
      <h1 class="text-3xl font-bold "><?= $heading ?></h1>
    </div>
  </section>
  <section class="container mt-4 mx-auto px-4 sm:px-0 flex flex-col items-start justify-start gap-2">
    <a href="/notes" class="underline text-blue-500">Go back</a>
    <?php echo $note['content'] ?? ""; ?>

    <form method="post" class="mt-6">
      <input type="hidden" name="action" value="delete">
      <input type="hidden" name="publicId" value="<?= $note['public_id'] ?? "" ?>">
      <button type="submit" class="bg-red-100 text-red-700 px-4 py-3 rounded">Delete</button>
    </form>
  </section>
</main>
<?php view("partials/footer.php"); ?>