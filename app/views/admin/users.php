<!DOCTYPE html>
<html lang="cs">
<head><?php $page_title='CarRate – Admin: Uživatelé'; require __DIR__.'/../partials/_head.php'; ?></head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<?php require __DIR__.'/../partials/_navbar.php'; ?>

<div class="container mx-auto px-6 max-w-5xl py-10 flex-grow">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-red-500 mb-1">Admin panel</p>
            <h1 class="text-3xl font-extrabold text-gray-900">Správa uživatelů</h1>
        </div>
        <div class="flex gap-3">
            <a href="?url=profile/adminReviews"  class="text-sm text-gray-500 hover:text-blue-600 font-semibold">Recenze</a>
            <a href="?url=profile/adminComments" class="text-sm text-gray-500 hover:text-blue-600 font-semibold">Komentáře</a>
            <a href="?url=profile/index"         class="text-sm text-gray-400 hover:text-blue-600 font-semibold">&larr; Profil</a>
        </div>
    </div>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm font-semibold">
            ✅ Uživatel byl úspěšně smazán.
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">ID</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">Uživatel</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">Role</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">Recenze</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($users as $u): ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3 text-gray-400 font-mono">#<?php echo $u['id']; ?></td>
                    <td class="px-5 py-3 font-bold text-gray-800">
                        <?php echo htmlspecialchars($u['username']); ?>
                        <?php if ($u['id'] == $_SESSION['user_id']): ?>
                            <span class="ml-2 text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">Ty</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3">
                        <?php if ($u['role'] === 'admin'): ?>
                            <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full">👑 Admin</span>
                        <?php else: ?>
                            <span class="bg-gray-100 text-gray-600 text-xs font-bold px-2 py-1 rounded-full">👤 Uživatel</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-gray-600 font-semibold">🚗 <?php echo $u['review_count']; ?></td>
                    <td class="px-5 py-3 text-right">
                        <?php if ($u['id'] != $_SESSION['user_id']): ?>
                            <button onclick="confirmDeleteUser('<?php echo htmlspecialchars($u['username']); ?>', <?php echo $u['id']; ?>)"
                                    class="text-red-500 hover:text-red-700 font-bold text-xs hover:underline">
                                🗑️ Smazat
                            </button>
                        <?php else: ?>
                            <span class="text-gray-300 text-xs">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__.'/../partials/_footer.php'; ?>
<script>
function confirmDeleteUser(username, id) {
    showConfirm(
        `Opravdu chceš smazat uživatele „${username}"? Tato akce smaže i všechny jeho recenze.`,
        () => { window.location.href = '?url=profile/adminDeleteUser&id=' + id; },
        { icon: '👤', confirmLabel: 'Ano, smazat' }
    );
}
</script>
</body>
</html>
