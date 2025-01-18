<?php
require basePath("core/imagekit.php");
$logo = $imagekit->url([
    "path" => "/php-notes-app/notes.png",
    'transformation' => [
        [
            'height' => '128',
            'width' => '128'
        ]
    ]
]);
?>

<header class="py-6 bg-gray-900 text-white">
    <div class="container px-4 sm:px-0 flex items-center justify-between mx-auto">
        <div class="flex items-center justify-start">
            <div class="flex gap-1 items-center justify-start">
                <img src="<?= $logo ?>" alt="Site logo" class="text-transparent w-8 h-8">
                <a href="/" class="font-bold text-xl">Scibes</a>
            </div>
            <nav>
                <ul class="flex items-center justify-start ml-12 gap-6">
                    <li>
                        <a href="/" class="<?= urlIs("/")
                                                ? "opacity-100"
                                                : "opacity-80" ?>">Home</a>
                    </li>
                    <li>
                        <a href="/notes"
                            class="<?= urlIs("/notes")
                                        ? "opacity-100"
                                        : "opacity-80" ?>">Notes</a>
                    </li>
                    <li>
                        <a href="/about"
                            class="<?= urlIs("/about")
                                        ? "opacity-100"
                                        : "opacity-80" ?>">About</a>
                    </li>
                    <li>
                        <a href="/contact"
                            class="<?= urlIs("/contact")
                                        ? "opacity-100"
                                        : "opacity-80" ?>">Contact</a>
                    </li>
                </ul>
            </nav>
        </div>
        <ul class="flex items-center justify-end gap-2">
            <li>
                <a href="/login.php" class="border border-solid rounded border-white bg-gray-900 px-4 py-3 hover:bg-gray-950">Login</a>
            </li>
            <li>
                <a href="/register.php" class="border border-solid border-white px-4 py-3 bg-white text-black rounded hover:bg-gray-100">Register</a>
            </li>
        </ul>
    </div>
</header>