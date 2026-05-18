<!DOCTYPE html>
<html lang="cs">
<head>
    <?php $page_title = 'CarRate – Můj profil'; require __DIR__ . '/../partials/_head.php'; ?>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <?php $active_page = 'profile'; require __DIR__ . '/../partials/_navbar.php'; ?>

    <div class="container mx-auto px-6 max-w-6xl pb-12 flex-grow mt-8">

        <!-- Hlavička profilu -->
        <div class="bg-white rounded-2xl shadow border border-gray-100 p-7 mb-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl font-extrabold flex-shrink-0">
                <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
            </div>
            <div class="flex-grow text-center sm:text-left">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-1">
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </h2>
                <p class="text-gray-500 text-sm">
                    V garáži: <span class="font-bold text-blue-600"><?php echo $total_reviews; ?> 🚗</span>
                </p>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <span class="inline-block mt-2 bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full">👑 Administrátor</span>
                <?php endif; ?>
            </div>
            <div class="flex flex-col gap-2 flex-shrink-0 w-full sm:w-48">
                <?php if (isset($_GET['success']) && $_GET['success'] === 'password'): ?>
                    <div class="text-green-600 text-xs font-semibold text-center mb-1">✅ Heslo bylo změněno!</div>
                <?php endif; ?>
                <a href="?url=review/create"
                   class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-full text-center text-sm transition shadow shadow-orange-200">
                    + Přidat recenzi
                </a>
                <a href="?url=profile/edit"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full text-center text-sm transition border border-gray-200">
                    ⚙️ Upravit profil
                </a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <!-- Admin panel s rozbalovacím menu -->
                    <div class="relative" id="admin-dropdown-wrap">
                        <button onclick="document.getElementById('admin-menu').classList.toggle('hidden')"
                                class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-bold py-2 px-4 rounded-full text-center text-sm transition border border-red-200">
                            👑 Admin panel ▾
                        </button>
                        <div id="admin-menu" class="hidden absolute right-0 mt-1 w-full bg-white rounded-xl shadow-lg border border-gray-100 z-10 overflow-hidden">
                            <a href="?url=profile/adminUsers"    class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">👤 Uživatelé</a>
                            <a href="?url=profile/adminReviews"  class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 border-t border-gray-50">🚗 Recenze</a>
                            <a href="?url=profile/adminComments" class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 border-t border-gray-50">💬 Komentáře</a>
                        </div>
                    </div>
                <?php endif; ?>
                <button onclick="confirmLogout()"
                        class="text-gray-400 hover:text-gray-600 font-semibold text-sm text-center py-1 transition">
                    Odhlásit se
                </button>
            </div>
        </div>

        <!-- Recenze -->
        <?php if (empty($my_reviews)): ?>
            <div class="bg-white p-12 rounded-2xl shadow border border-gray-100 text-center max-w-xl mx-auto">
                <p class="text-5xl mb-4">🕸️</p>
                <p class="text-xl font-bold text-gray-700 mb-2">Tvoje garáž je prázdná!</p>
                <p class="text-gray-500 mb-6 text-sm">Přidej první auto a poděl se o svůj názor.</p>
                <a href="?url=review/create"
                   class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-7 rounded-full transition shadow shadow-orange-200">
                    Přidat první vůz
                </a>
            </div>
        <?php else: ?>
            <h3 class="text-lg font-bold text-gray-700 mb-5">Moje recenze</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($my_reviews as $review): ?>
                    <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden flex flex-col
                                cursor-pointer hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 group relative"
                         onclick="window.location='?url=review/show&id=<?php echo $review['id']; ?>'">
                        <div class="relative">
                            <?php if (!empty($review['image_path'])): ?>
                                <img src="<?php echo htmlspecialchars($review['image_path']); ?>" class="w-full h-44 object-cover">
                            <?php else: ?>
                                <div class="w-full h-44 bg-gray-100 flex items-center justify-center text-5xl text-gray-200">🚗</div>
                            <?php endif; ?>
                            <div class="absolute top-3 right-3">
                                <?php if ($review['recommend']): ?>
                                    <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">👍 Doporučuji</span>
                                <?php else: ?>
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">❌ Nedoporučuji</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="p-5 flex-grow">
                            <h4 class="text-base font-bold text-gray-900 group-hover:text-blue-600 transition mb-1">
                                <?php echo htmlspecialchars($review['brand'] . ' ' . $review['model']); ?>
                            </h4>
                            <p class="text-xs text-gray-400">
                                📅 <?php echo htmlspecialchars($review['year']); ?> &nbsp;·&nbsp;
                                ⛽ <?php echo htmlspecialchars($review['fuel']); ?>
                            </p>
                        </div>
                        <div class="border-t bg-gray-50 px-4 py-3 flex justify-between" onclick="event.stopPropagation()">
                            <a href="?url=review/edit&id=<?php echo $review['id']; ?>"
                               class="text-amber-600 hover:text-amber-800 font-bold text-sm">✏️ Upravit</a>
                            <button onclick="confirmDeleteReview('<?php echo htmlspecialchars($review['brand'].' '.$review['model']); ?>', <?php echo $review['id']; ?>)"
                                    class="text-red-500 hover:text-red-700 font-bold text-sm">🗑️ Smazat</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php require __DIR__ . '/../partials/_footer.php'; ?>

<script>
// Zavřít admin dropdown kliknutím mimo
document.addEventListener('click', function(e) {
    const wrap = document.getElementById('admin-dropdown-wrap');
    const menu = document.getElementById('admin-menu');
    if (wrap && menu && !wrap.contains(e.target)) menu.classList.add('hidden');
});

function confirmLogout() {
    showConfirm('Opravdu se chceš odhlásit?',
        () => { window.location.href = '?url=user/logout'; },
        { icon: '👋', confirmLabel: 'Odhlásit', confirmClass: 'bg-blue-600 hover:bg-blue-700 flex-1 py-2.5 rounded-xl text-white font-bold transition' }
    );
}

function confirmDeleteReview(name, id) {
    showConfirm(`Opravdu chceš smazat recenzi vozu „${name}"?`,
        () => { window.location.href = '?url=review/delete&id=' + id; },
        { icon: '🗑️', confirmLabel: 'Ano, smazat' }
    );
}
</script>
</body>
</html>
