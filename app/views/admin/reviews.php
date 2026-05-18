<!DOCTYPE html>
<html lang="cs">
<head><?php $page_title='CarRate – Admin: Recenze'; require __DIR__.'/../partials/_head.php'; ?></head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<?php require __DIR__.'/../partials/_navbar.php'; ?>

<div class="container mx-auto px-6 max-w-5xl py-10 flex-grow">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-red-500 mb-1">Admin panel</p>
            <h1 class="text-3xl font-extrabold text-gray-900">Správa recenzí</h1>
        </div>
        <div class="flex gap-3">
            <a href="?url=profile/adminComments" class="text-sm text-gray-500 hover:text-blue-600 font-semibold">Komentáře</a>
            <a href="?url=profile/adminUsers"    class="text-sm text-gray-500 hover:text-blue-600 font-semibold">Uživatelé</a>
            <a href="?url=profile/index"         class="text-sm text-gray-400 hover:text-blue-600 font-semibold">&larr; Profil</a>
        </div>
    </div>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm font-semibold">✅ Recenze byla smazána.</div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">ID</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">Vůz</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">Autor</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">Verdikt</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($reviews as $r): ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3 text-gray-400 font-mono">#<?php echo $r['id']; ?></td>
                    <td class="px-5 py-3 font-bold text-gray-800">
                        <a href="?url=review/show&id=<?php echo $r['id']; ?>" class="hover:text-blue-600 transition">
                            <?php echo htmlspecialchars($r['brand'].' '.$r['model']); ?>
                        </a>
                        <span class="text-xs text-gray-400 ml-1"><?php echo $r['year']; ?></span>
                    </td>
                    <td class="px-5 py-3 text-gray-600">👤 <?php echo htmlspecialchars($r['username']); ?></td>
                    <td class="px-5 py-3">
                        <?php if ($r['recommend']): ?>
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">👍 Doporučeno</span>
                        <?php else: ?>
                            <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full">❌ Nedoporučeno</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <button onclick="confirmDeleteReview('<?php echo htmlspecialchars($r['brand'].' '.$r['model']); ?>', <?php echo $r['id']; ?>)"
                                class="text-red-500 hover:text-red-700 font-bold text-xs hover:underline">
                            🗑️ Smazat
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__.'/../partials/_footer.php'; ?>
<script>
function confirmDeleteReview(name, id) {
    showConfirm(`Opravdu smazat recenzi „${name}"? Tato akce je nevratná.`,
        () => { window.location.href = '?url=review/delete&id=' + id; },
        { icon: '🚗', confirmLabel: 'Ano, smazat' });
}
</script>
</body></html>
