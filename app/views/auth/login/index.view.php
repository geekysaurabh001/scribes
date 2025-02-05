<?php view("partials/meta.php"); ?>
<?php view("partials/header.php"); ?>
<main class="flex-1  bg-gray-50">
    <section class="px-4 sm:px-0 bg-white text-black border-b border-solid border-b-gray-200 py-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold "><?= $heading ?></h1>
        </div>
    </section>
    <section class="px-4 mt-4 sm:px-0 container mx-auto flex items-start justify-between gap-12">
        <form class="w-1/2 flex flex-col gap-4 max-w-screen-sm" action="/login" method="post">
            <div class="flex flex-col gap-2">
                <label for="email" class="font-semibold">Email <span class="text-red-700">*</span></label>
                <input type="email" name="email" id="email" placeholder="Enter your email" class="w-full rounded" value="<?= $submittedData['email'] ?? '' ?>">
                <span class="text-sm text-red-700"><?php echo $errors["email"] ?? "" ?></span>
            </div>
            <div class="flex flex-col gap-2">
                <label for="password" class="font-semibold">Password <span class="text-red-700">*</span></label>
                <input type="password" name="password" id="password" placeholder="Enter your password" class="w-full rounded" value="<?= $submittedData['password'] ?? '' ?>">
                <span class="text-sm text-red-700"><?php echo $errors["password"] ?? "" ?></span>
            </div>
            <div class="flex gap-2">
                <button type="reset" class="bg-red-900 text-white px-4 py-3 rounded mt-6">Cancel</button>
                <button type="submit" class="bg-gray-900 text-white px-4 py-3 rounded mt-6">Login</button>
                <?php if ($success): ?>
                    <span class="text-sm bg-green-100 rounded text-green-700 mt-6 py-3 px-4"><?= htmlspecialchars($success) ?></span>
                <?php endif; ?>
            </div>
        </form>
        <aside class="w-1/2">
            <img src="<?= $loginIllustrationUrl ?>" alt="Login Illustration" width="616" height="616">
            <p class="text-right text-sm">Designed by <a href="https://www.freepik.com" class="underline text-blue-700">Freepik</a></p>
        </aside>
    </section>
</main>
<?php view("partials/footer.php"); ?>