<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Dostupné knihy</h2>
            <p class="text-slate-500 mt-1">Spravujte svou sbírku knih v databázi.</p>
        </div>
    </div>

    <?php if (!empty($books)): ?>
        <div class="bg-white shadow-md rounded-xl overflow-x-auto border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-50 text-blue-800 border-b border-blue-100 text-sm uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Název</th>
                        <th class="px-6 py-4 font-semibold">Autor</th>
                        <th class="px-6 py-4 font-semibold">ISBN</th>
                        <th class="px-6 py-4 font-semibold">Rok</th>
                        <th class="px-6 py-4 font-semibold">Cena</th>
                        <th class="px-6 py-4 font-semibold text-center">Akce</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($books as $b): ?>
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4 font-medium text-slate-900"><?= htmlspecialchars($b['title']) ?></td>
                            <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($b['author']) ?></td>
                            <td class="px-6 py-4 text-slate-500 text-sm"><?= htmlspecialchars($b['isbn']) ?></td>
                            <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($b['year']) ?></td>
                            <td class="px-6 py-4 font-semibold text-blue-600"><?= htmlspecialchars($b['price']) ?> Kč</td>
                            
                            <td class="px-6 py-4 text-center space-x-3 text-sm">
                                <?php if (!empty($b['link'])): ?>
                                    <a href="<?= htmlspecialchars($b['link']) ?>" target="_blank" class="text-blue-500 hover:text-blue-700 font-medium">Odkaz</a>
                                <?php endif; ?>
                                <a href="/WA-2026-SARA-KRISTANOVA/public/index.php?url=book/show/<?= $b['id'] ?>" class="text-blue-500 hover:text-blue-700 font-medium">Detail</a>
                                <a href="/WA-2026-SARA-KRISTANOVA/public/index.php?url=book/edit/<?= $b['id'] ?>" class="text-slate-500 hover:text-slate-800 font-medium">Upravit</a>
                                <a href="/WA-2026-SARA-KRISTANOVA/public/index.php?url=book/delete/<?= $b['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="text-red-500 hover:text-red-700 font-medium">Smazat</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="bg-white p-12 text-center rounded-xl shadow-sm border border-slate-100">
            <svg class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <h3 class="text-lg font-medium text-slate-900">Zatím tu nejsou žádné knihy</h3>
            <p class="mt-1 text-slate-500">Začněte tím, že přidáte svou první knihu do databáze.</p>
        </div>
    <?php endif; ?>
</main>

</html>