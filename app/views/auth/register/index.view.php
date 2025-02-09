<?php view("partials/meta.php"); ?>
<?php view("partials/header.php"); ?>
<main class="flex-1  bg-gray-50">
  <section class="px-4 sm:px-0 bg-white text-black border-b border-solid border-b-gray-200 py-6">
    <div class="container mx-auto">
      <h1 class="text-3xl font-bold "><?= $heading ?></h1>
    </div>
  </section>
  <section class="px-4 mt-4 sm:px-0 container mx-auto flex items-start justify-between gap-12">
    <form class="w-1/2 flex flex-col gap-4 max-w-screen-sm" action="/register" method="post">
      <div class="flex flex-col gap-2">
        <label for="name" class="font-semibold">Name <span class="text-red-700">*</span></label>
        <input type="text" name="name" id="name" placeholder="Enter your name" class="w-full rounded" value="<?= $submittedData['name'] ?? '' ?>">
        <span class="text-sm text-red-700"><?php echo $errors["name"] ?? "" ?></span>
      </div>
      <div class="flex flex-col gap-2">
        <label for="username" class="font-semibold">Username <span class="text-red-700">*</span></label>
        <input type="text" name="username" id="username" placeholder="Enter your username" class="w-full rounded" value="<?= $submittedData['username'] ?? '' ?>">
        <span class="text-sm text-red-700"><?php echo $errors["username"] ?? "" ?></span>
      </div>
      <div class="flex flex-col gap-2">
        <label for="email" class="font-semibold">Email <span class="text-red-700">*</span></label>
        <input type="email" name="email" id="email" placeholder="Enter your email" class="w-full rounded" value="<?= $submittedData['email'] ?? '' ?>">
        <span class="text-sm text-red-700"><?php echo $errors["email"] ?? "" ?></span>
      </div>
      <div class="flex flex-col gap-2">
        <label for="password" class="font-semibold">Password <span class="text-red-700">*</span></label>
        <input type="password" name="password" id="password" placeholder="Enter your password" class="w-full rounded">
        <span class="text-sm text-red-700"><?php echo $errors["password"] ?? "" ?></span>
      </div>
      <div class="flex flex-col gap-2">
        <label for="confirmPassword" class="font-semibold">Confirm Password <span class="text-red-700">*</span></label>
        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Enter your confirm password" class="w-full rounded">
        <span class="text-sm text-red-700"><?php echo $errors["confirmPassword"] ?? "" ?></span>
      </div>
      <div class="flex gap-2">
        <button type="reset" class="bg-red-900 text-white px-4 py-3 rounded mt-6">Cancel</button>
        <button type="submit" class="bg-gray-900 text-white px-4 py-3 rounded mt-6">Register</button>
        <?php if ($success): ?>
          <span class="text-sm bg-green-100 rounded text-green-700 mt-6 py-3 px-4"><?= htmlspecialchars($success) ?></span>
        <?php endif; ?>
        <?php if (!empty($errors["error"])): ?>
          <span class="text-sm bg-red-100 rounded text-red-700 mt-6 py-3 px-4">
            <?= htmlspecialchars($errors["error"], ENT_QUOTES, 'UTF-8') ?>
          </span>
        <?php endif; ?>
      </div>
    </form>
    <aside class="w-1/2">
      <img src="<?= $registerIllustrationUrl ?>" alt="Register Illustration" width="616" height="616">
      <p class="text-right text-sm">Designed by <a href="https://www.freepik.com" class="underline text-blue-700">Freepik</a></p>
    </aside>
  </section>
</main>
<?php view("partials/footer.php"); ?>