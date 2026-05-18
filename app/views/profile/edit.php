<!DOCTYPE html>
<html lang="cs">
<head>
    <?php $page_title = 'CarRate – Upravit profil'; require __DIR__ . '/../partials/_head.php'; ?>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <?php $active_page = 'profile'; require __DIR__ . '/../partials/_navbar.php'; ?>

    <div class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8 border border-gray-100">

            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl font-extrabold mx-auto mb-4">
                    <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900">Změna hesla</h1>
                <p class="text-gray-500 text-sm mt-1">Přihlášen jako <span class="font-bold text-blue-600"><?php echo htmlspecialchars($_SESSION['username']); ?></span></p>
            </div>

            <?php if (isset($error_message)): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm font-semibold">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form action="?url=profile/update" method="POST" class="space-y-5">

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Aktuální heslo <span class="text-red-500">*</span></label>
                    <input type="password" name="current_password" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nové heslo <span class="text-red-500">*</span></label>
                    <input type="password" name="new_password" id="new_password" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <p class="text-xs text-gray-400 mt-1">Min. 8 znaků, 1 velké písmeno, 1 číslice.</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Potvrdit nové heslo <span class="text-red-500">*</span></label>
                    <input type="password" name="confirm_password" id="confirm_password" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-md">
                    💾 Uložit nové heslo
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <a href="?url=profile/index" class="text-gray-400 hover:text-gray-600 text-sm font-semibold">
                    &larr; Zpět na profil
                </a>
            </div>

            <!-- Smazání vlastního účtu – nebezpečná zóna -->
            <div class="mt-8 pt-6 border-t border-red-100">
                <p class="text-xs font-bold text-red-400 uppercase tracking-widest mb-3 text-center">Nebezpečná zóna</p>
                <button onclick="confirmDeleteSelf()"
                        class="w-full border border-red-200 text-red-500 hover:bg-red-50 font-bold py-2.5 rounded-xl transition text-sm">
                    🗑️ Smazat svůj účet
                </button>
            </div>

        </div>
    </div>

    <?php require __DIR__ . '/../partials/_footer.php'; ?>

<script>
function confirmDeleteSelf() {
    showConfirm(
        'Opravdu chceš smazat svůj účet? Přijdeš o všechny recenze a tuto akci nelze vrátit.',
        () => { window.location.href = '?url=profile/deleteAccount'; },
        { icon: '🗑️', confirmLabel: 'Ano, smazat účet' }
    );
}
</script>

</body>
</html>
