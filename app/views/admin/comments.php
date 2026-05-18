<!DOCTYPE html>
<html lang="cs">
<head><?php $page_title='CarRate – Admin: Komentáře'; require __DIR__.'/../partials/_head.php'; ?></head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<?php require __DIR__.'/../partials/_navbar.php'; ?>

<div class="container mx-auto px-6 max-w-5xl py-10 flex-grow">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-red-500 mb-1">Admin panel</p>
            <h1 class="text-3xl font-extrabold text-gray-900">Správa komentářů</h1>
        </div>
        <div class="flex gap-3">
            <a href="?url=profile/adminReviews" class="text-sm text-gray-500 hover:text-blue-600 font-semibold">Recenze</a>
            <a href="?url=profile/adminUsers"   class="text-sm text-gray-500 hover:text-blue-600 font-semibold">Uživatelé</a>
            <a href="?url=profile/index"        class="text-sm text-gray-400 hover:text-blue-600 font-semibold">&larr; Profil</a>
        </div>
    </div>

    <?php if (isset($_GET['deleted'])): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm font-semibold">✅ Komentář byl smazán.</div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">ID</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">Komentář</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">Autor</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wide">K recenzi</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($comments as $c): ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3 text-gray-400 font-mono">#<?php echo $c['id']; ?></td>
                    <td class="px-5 py-3 text-gray-700 max-w-xs truncate">
                        <?php echo htmlspecialchars(mb_substr($c['comment_text'], 0, 80)); ?>
                        <?php if (mb_strlen($c['comment_text']) > 80): ?>…<?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-gray-600">👤 <?php echo htmlspecialchars($c['username']); ?></td>
                    <td class="px-5 py-3">
                        <a href="?url=review/show&id=<?php echo $c['review_id']; ?>"
                           class="text-blue-600 hover:underline font-semibold text-xs">
                            <?php echo htmlspecialchars($c['brand'].' '.$c['model']); ?>
                        </a>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <button onclick="confirmDeleteComment(<?php echo $c['id']; ?>)"
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
function confirmDeleteComment(id) {
    showConfirm('Opravdu smazat tento komentář?',
        () => { window.location.href = '?url=profile/adminDeleteComment&id=' + id; },
        { icon: '💬', confirmLabel: 'Ano, smazat' });
}
</script>
</body></html>
