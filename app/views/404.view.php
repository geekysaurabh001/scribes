<?php view("partials/meta.php"); ?>
<?php view("partials/header.php"); ?>
<main class="flex-1  bg-gray-50">
    <section class="px-4 sm:px-0 bg-white text-black border-b border-solid border-b-gray-200 py-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold "><?= $heading ?></h1>
        </div>
    </section>
    <section class="container mt-4 mx-auto px-4 sm:px-0 flex flex-col items-start justify-start gap-2">
        <a href="/notes" class="underline text-blue-500">Go back to notes</a>
    </section>
</main>
<?php view("partials/footer.php"); ?>