<!DOCTYPE html>
<html lang="cs">
<head>
    <?php $page_title = 'CarRate – Přihlášení'; require __DIR__ . '/../partials/_head.php'; ?>
</head>
<body class="bg-gray-100 flex flex-col" style="height:100vh;overflow:hidden">

    <?php require __DIR__ . '/../partials/_navbar.php'; ?>

    <!-- Formulář přesně vyplní zbývající výšku -->
    <div class="flex-1 flex items-center justify-center px-4 overflow-y-auto py-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md border border-gray-100 p-8">

            <div class="text-center mb-6">
                <a href="?url=review/index" class="inline-flex items-center justify-center gap-2 mb-3">
                    <img src="assets/logo.svg" alt="CarRate logo" class="h-10">
                    <span class="text-2xl font-extrabold text-blue-600">CarRate</span>
                </a>
                <h1 class="text-xl font-extrabold text-gray-900">Vítejte zpět! 🔑</h1>
                <p class="text-gray-500 text-sm mt-1">Přihlaste se do svého účtu</p>
            </div>

            <?php if (isset($_GET['success'])): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm font-semibold">
                    ✅ Registrace proběhla úspěšně! Nyní se můžete přihlásit.
                </div>
            <?php endif; ?>

            <form action="?url=user/login" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Uživatelské jméno</label>
                    <input type="text" name="username" required autofocus
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Heslo</label>
                    <div class="relative">
                        <input type="password" name="password" id="login-pw" required
                               class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <button type="button"
                                onclick="togglePassword('login-pw', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-lg opacity-50 hover:opacity-90 transition select-none">
                            👁️
                        </button>
                    </div>
                </div>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-md mt-2">
                    Přihlásit se
                </button>
            </form>

            <p class="text-center text-gray-500 text-sm mt-5">
                Nemáte účet?
                <a href="?url=user/register" class="text-blue-600 font-bold hover:underline">Zaregistrujte se</a>
            </p>
        </div>
    </div>

    <?php require __DIR__ . '/../partials/_footer.php'; ?>

<?php if (isset($error_message)): ?>
<script>
document.addEventListener('DOMContentLoaded', () =>
    showToast("<?php echo addslashes(strip_tags($error_message)); ?>", 'error', 5000));
</script>
<?php endif; ?>

</body>
</html>
