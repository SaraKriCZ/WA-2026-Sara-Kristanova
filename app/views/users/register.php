<!DOCTYPE html>
<html lang="cs">
<head>
    <?php $page_title = 'CarRate – Registrace'; require __DIR__ . '/../partials/_head.php'; ?>
</head>
<body class="bg-gray-100 flex flex-col" style="height:100vh;overflow:hidden">

    <?php require __DIR__ . '/../partials/_navbar.php'; ?>

    <div class="flex-1 flex items-center justify-center px-4 overflow-y-auto py-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md border border-gray-100 p-8">

            <div class="text-center mb-6">
                <a href="?url=review/index" class="inline-flex items-center justify-center gap-2 mb-3">
                    <img src="assets/logo.svg" alt="CarRate logo" class="h-10">
                    <span class="text-2xl font-extrabold text-blue-600">CarRate</span>
                </a>
                <h1 class="text-xl font-extrabold text-gray-900">Vytvořit účet 🚗</h1>
                <p class="text-gray-500 text-sm mt-1">Připoj se ke komunitě řidičů</p>
            </div>

            <form id="reg-form" action="?url=user/register" method="POST" class="space-y-4" novalidate>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">
                        Uživatelské jméno <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="username" id="reg-username" required autofocus
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">
                        Heslo <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="reg-pw" required
                               class="w-full border border-gray-200 rounded-xl py-2.5 px-4 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <button type="button"
                                onclick="togglePassword('reg-pw', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-lg opacity-50 hover:opacity-90 transition select-none">
                            👁️
                        </button>
                    </div>
                    <!-- Live validace pravidel -->
                    <div class="mt-2 grid grid-cols-3 gap-1.5 text-xs">
                        <span id="rule-len"  class="flex items-center gap-1 text-gray-400 transition"><span>○</span> 8+ znaků</span>
                        <span id="rule-num"  class="flex items-center gap-1 text-gray-400 transition"><span>○</span> Číslice</span>
                        <span id="rule-caps" class="flex items-center gap-1 text-gray-400 transition"><span>○</span> Velké písmeno</span>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-md">
                    Zaregistrovat se
                </button>
            </form>

            <p class="text-center text-gray-500 text-sm mt-5">
                Už máte účet?
                <a href="?url=user/login" class="text-blue-600 font-bold hover:underline">Přihlaste se</a>
            </p>
        </div>
    </div>

    <?php require __DIR__ . '/../partials/_footer.php'; ?>

<script>
// ── Live validace pravidel hesla ──────────────────────────
const pwInput = document.getElementById('reg-pw');
const rules = {
    'rule-len':  v => v.length >= 8,
    'rule-num':  v => /[0-9]/.test(v),
    'rule-caps': v => /[A-Z]/.test(v),
};
pwInput.addEventListener('input', function() {
    Object.entries(rules).forEach(([id, test]) => {
        const el   = document.getElementById(id);
        const dot  = el.querySelector('span');
        const pass = test(this.value);
        dot.textContent = pass ? '✅' : '○';
        el.classList.toggle('text-green-600', pass);
        el.classList.toggle('text-gray-400',  !pass);
    });
});

// ── Submit validace → toast ───────────────────────────────
document.getElementById('reg-form').addEventListener('submit', function(e) {
    const uname = document.getElementById('reg-username').value.trim();
    const pw    = pwInput.value;
    const errors = [];
    if (!uname)                  errors.push('Zadej uživatelské jméno.');
    if (pw.length < 8)           errors.push('Heslo musí mít alespoň 8 znaků.');
    if (!/[0-9]/.test(pw))       errors.push('Heslo musí obsahovat číslici.');
    if (!/[A-Z]/.test(pw))       errors.push('Heslo musí obsahovat velké písmeno.');

    if (errors.length > 0) {
        e.preventDefault();
        errors.forEach(msg => showToast(msg, 'error', 4500));
    }
});

<?php if (isset($error_message)): ?>
document.addEventListener('DOMContentLoaded', () =>
    showToast("<?php echo addslashes(strip_tags($error_message)); ?>", 'error', 5000));
<?php endif; ?>
</script>
</body>
</html>
