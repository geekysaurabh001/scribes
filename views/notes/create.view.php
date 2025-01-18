<?php view("partials/meta.php"); ?>
<?php view("partials/header.php"); ?>
<main class="flex-1  bg-gray-50">
  <section class="px-4 sm:px-0 bg-white text-black border-b border-solid border-b-gray-200 py-6">
    <div class="container mx-auto">
      <h1 class="text-3xl font-bold "><?= $heading ?></h1>
    </div>
  </section>
  <section class="px-4 mt-4 sm:px-0 container mx-auto flex items-start justify-between gap-12">
    <form class="w-1/2 flex flex-col gap-4 max-w-screen-sm" action="/notes/create" method="POST" enctype="multipart/form-data">
      <fieldset class="flex flex-col gap-2">
        <label for="title" class="font-semibold">Title <span class="text-red-700">*</span></label>
        <input type="text" name="title" id="title" class="rounded" placeholder="Enter note title">
        <span class="text-sm text-red-500"><?php echo $errors["title"] ?? "" ?></span>
      </fieldset>
      <fieldset class="flex flex-col gap-2">
        <label for="description" class="font-semibold">Description <span class="text-red-700">*</span></label>
        <input type="text" name="description" id="description" class="rounded" placeholder="Enter note short description">
        <span class="text-sm text-red-500"><?php echo $errors["description"] ?? "" ?></span>
      </fieldset>
      <fieldset class="flex flex-col gap-2">
        <label for="content">Content <span class="text-red-700">*</span></label>
        <textarea rows="5" name="content" id="content" class="rounded" placeholder="Enter note content"></textarea>
        <span class="text-sm text-red-500"><?php echo $errors["content"] ?? "" ?></span>
      </fieldset>
      <fieldset class="flex flex-col gap-2">
        <label for="thumbnail">Thumbnail
          <!-- <span class="text-red-700">*</span> -->
        </label>
        <input type="file" name="thumbnail" id="thumbnail" accept="image/*" placeholder="Upload note thumbnail">
        <span class="text-sm text-red-500"><?php echo $errors["thumbnail"] ?? "" ?></span>
      </fieldset>
      <fieldset class="flex flex-col gap-2">
        <label for="featuredImage">Featured Image
          <!-- <span class="text-red-700">*</span> -->
        </label>
        <input type="file" name="featuredImage" id="featuredImage" accept="image/*" placeholder="Upload note featured image">
        <span class="text-sm text-red-500"><?php echo $errors["featuredImage"] ?? "" ?></span>
      </fieldset>
      <fieldset class="flex gap-2">
        <button type="reset" class="bg-red-900 text-white px-4 py-3 rounded mt-6">Cancel</button>
        <button type="submit" class="bg-gray-900 text-white px-4 py-3 rounded mt-6">Create</button>
        <?php if ($success): ?>
          <span class="text-sm bg-green-100 rounded text-green-700 mt-6 py-3 px-4"><?= htmlspecialchars($success) ?></span>
        <?php endif; ?>

      </fieldset>
    </form>
    <aside class="w-1/2">
      <img src="<?= $notesIllustrationUrl ?>" alt="Notes Illustration" width="616" height="616">
      <p class="text-right text-sm">Designed by <a href="https://www.freepik.com" class="underline text-blue-500">Freepik</a></p>
    </aside>
  </section>
</main>
<?php view("partials/footer.php"); ?>