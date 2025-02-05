<?php view("partials/meta.php"); ?>
<?php view("partials/header.php"); ?>
<main class="flex-1  bg-gray-50">
  <section class="px-4 sm:px-0 bg-white text-black border-b border-solid border-b-gray-200 py-6">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-3xl font-bold "><?= $heading ?></h1>
      <form method="post" class="m-0">
        <input type="hidden" name="_method" value="delete">
        <input type="hidden" name="publicId" value="<?= $note['public_id'] ?? "" ?>">
        <button type="submit" class="bg-red-100 text-red-700 px-4 py-1 rounded">Delete</button>
      </form>
    </div>
  </section>
  <section class="px-4 mt-4 sm:px-0 container mx-auto flex items-start justify-between gap-12">
    <form class="w-1/2 flex flex-col gap-4 max-w-screen-sm" action="/note" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="_method" value="patch">
      <input type="hidden" name="publicId" value="<?= $note['public_id'] ?>">
      <div class="flex flex-col gap-2">
        <label for="title" class="font-semibold">Title <span class="text-red-700">*</span></label>
        <input type="text" name="title" id="title" class="rounded" placeholder="Enter note title" value="<?php echo htmlspecialchars($note["title"]) ?>">
        <span class="text-sm text-red-700"><?php echo $errors["title"] ?? "" ?></span>
      </div>
      <div class="flex flex-col gap-2">
        <label for="description" class="font-semibold">Description <span class="text-red-700">*</span></label>
        <input type="text" name="description" id="description" class="rounded" placeholder="Enter note short description" value="<?php echo htmlspecialchars($note["description"]) ?>">
        <span class="text-sm text-red-700"><?php echo $errors["description"] ?? "" ?></span>
      </div>
      <div class="flex flex-col gap-2">
        <label for="content">Content <span class="text-red-700">*</span></label>
        <textarea rows="5" name="content" id="content" class="rounded" placeholder="Enter note content"><?php echo htmlspecialchars($note["content"]) ?></textarea>
        <span class="text-sm text-red-700"><?php echo $errors["content"] ?? "" ?></span>
      </div>
      <!-- <div class="flex flex-col gap-2">
        <label for="thumbnail">Thumbnail
        </label>
        <input type="file" name="thumbnail" id="thumbnail" accept="image/*" placeholder="Upload note thumbnail">
        <span class="text-sm text-red-700"><?php echo $errors["thumbnail"] ?? "" ?></span>
      </div>
      <div class="flex flex-col gap-2">
        <label for="featuredImage">Featured Image
        </label>
        <input type="file" name="featuredImage" id="featuredImage" accept="image/*" placeholder="Upload note featured image">
        <span class="text-sm text-red-700"><?php echo $errors["featuredImage"] ?? "" ?></span>
      </div> -->
      <div class="flex gap-2">
        <a href="/note?id=<?= $note['public_id'] ?>" class="bg-red-900 text-white px-4 py-3 rounded mt-6">Cancel</a>
        <button type="submit" class="bg-gray-900 text-white px-4 py-3 rounded mt-6">Edit</button>
        <?php if ($success): ?>
          <span class="text-sm bg-green-100 rounded text-green-700 mt-6 py-3 px-4"><?= htmlspecialchars($success) ?></span>
        <?php endif; ?>
      </div>
    </form>
    <aside class="w-1/2">
      <img src="<?= $notesIllustrationUrl ?>" alt="Notes Illustration" width="616" height="616">
      <p class="text-right text-sm">Designed by <a href="https://www.freepik.com" class="underline text-blue-700">Freepik</a></p>
    </aside>
  </section>
</main>
<?php view("partials/footer.php"); ?>