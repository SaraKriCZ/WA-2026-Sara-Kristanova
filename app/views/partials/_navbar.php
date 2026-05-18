<?php
/**
 * PARTIAL: _navbar.php
 * Sdílená navigace s logem.
 * Proměnné: $active_page (volitelné) – 'catalog', 'profile', ...
 */
$active_page = $active_page ?? '';

function navLink(string $page, string $current): string {
    return $page === $current
        ? 'text-blue-600 font-bold underline underline-offset-4'
        : 'text-gray-500 hover:text-blue-600 font-semibold transition';
}
?>
<nav class="bg-white shadow-sm py-3 px-6 flex justify-between items-center sticky top-0 z-50">

    <!-- Logo + název -->
    <a href="?url=review/index" class="flex items-center gap-2 group">
        <img src="assets/logo.svg"
             alt="CarRate logo"
             class="h-9 w-auto transition-transform group-hover:scale-105">
        <span class="text-2xl font-extrabold text-blue-600 tracking-tight leading-none">
            CarRate
        </span>
    </a>

    <!-- Navigační odkazy -->
    <div class="hidden md:flex items-center space-x-5 border-l pl-5 border-gray-200">
        <a href="?url=catalog/index" class="<?php echo navLink('catalog', $active_page); ?> text-sm">
            Katalog aut
        </a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="?url=profile/index" class="<?php echo navLink('profile', $active_page); ?> text-sm">
                Můj profil
            </a>
        <?php endif; ?>
    </div>

    <!-- Pravá strana -->
    <div class="flex items-center gap-3">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="?url=review/create"
               class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-5 rounded-full transition shadow-md shadow-orange-200 text-sm">
                + Přidat recenzi
            </a>
        <?php else: ?>
            <a href="?url=user/login"
               class="text-blue-600 font-bold hover:underline text-sm">
                Přihlásit se
            </a>
            <a href="?url=user/register"
               class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-5 rounded-full transition shadow-md shadow-orange-200 text-sm">
                Registrace
            </a>
        <?php endif; ?>
    </div>

</nav>
