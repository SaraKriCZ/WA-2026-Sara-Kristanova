<?php require_once '../app/views/layout/header.php'; ?>

<?php 
// Rozbalíme text z databáze zpět na pole obrázků
$images = !empty($book['images']) ? json_decode($book['images'], true) : [];
?>

<main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 mt-8">
    
    <div class="mb-6">
        <a href="/WA-2026-SARA-KRISTANOVA/public/index.php" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors">
            &larr; Zpět na seznam
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-slate-100">
        
        <div class="bg-blue-600 px-8 py-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-white"><?= htmlspecialchars($book['title']) ?></h2>
                <p class="text-blue-100 mt-1">Autor: <?= htmlspecialchars($book['author']) ?></p>
            </div>
            <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">ID: <?= htmlspecialchars($book['id']) ?></span>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border-b border-slate-100 pb-4">
                    <span class="block text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Kategorie</span>
                    <span class="text-lg text-slate-800"><?= !empty($book['category']) ? htmlspecialchars($book['category']) : '-' ?></span>
                </div>
                <div class="border-b border-slate-100 pb-4">
                    <span class="block text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Podkategorie</span>
                    <span class="text-lg text-slate-800"><?= !empty($book['subcategory']) ? htmlspecialchars($book['subcategory']) : '-' ?></span>
                </div>
                <div class="border-b border-slate-100 pb-4">
                    <span class="block text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">ISBN</span>
                    <span class="text-lg text-slate-800"><?= !empty($book['isbn']) ? htmlspecialchars($book['isbn']) : '-' ?></span>
                </div>
                <div class="border-b border-slate-100 pb-4">
                    <span class="block text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Rok vydání</span>
                    <span class="text-lg text-slate-800"><?= htmlspecialchars($book['year']) ?></span>
                </div>
                <div class="border-b border-slate-100 pb-4">
                    <span class="block text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Cena</span>
                    <span class="text-lg font-bold text-blue-600"><?= htmlspecialchars($book['price']) ?> Kč</span>
                </div>
                <div class="border-b border-slate-100 pb-4">
                    <span class="block text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Odkaz</span>
                    <?php if (!empty($book['link'])): ?>
                        <a href="<?= htmlspecialchars($book['link']) ?>" target="_blank" class="text-blue-500 hover:text-blue-700 font-medium underline block">Zobrazit v obchodě</a>
                    <?php else: ?>
                        <span class="text-lg text-slate-800">-</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-8">
                <span class="block text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2">Popis knihy</span>
                <p class="text-slate-700 leading-relaxed whitespace-pre-line bg-slate-50 p-5 rounded-xl border border-slate-100">
                    <?= !empty($book['description']) ? htmlspecialchars($book['description']) : 'Tato kniha zatím nemá vyplněný žádný popis.' ?>
                </p>
            </div>
            
            <div class="mt-8">
                <span class="block text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2">Obrázky knihy</span>
                <?php if (!empty($images) && is_array($images)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <?php foreach ($images as $img): ?>
                            <div class="rounded-xl overflow-hidden border border-slate-200 shadow-sm bg-white">
                                <img src="/WA-2026-SARA-KRISTANOVA/public/uploads/<?= htmlspecialchars($img) ?>" 
                                     alt="Obrázek knihy <?= htmlspecialchars($book['title']) ?>" 
                                     class="w-full h-48 object-cover hover:scale-105 transition duration-300">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 text-slate-500 italic">
                        Tato kniha zatím nemá nahrané žádné obrázky.
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex gap-4">
                <a href="/WA-2026-SARA-KRISTANOVA/public/index.php?url=book/edit/<?= $book['id'] ?>" class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-xl shadow-sm transition duration-200">
                    Upravit tuto knihu
                </a>
            </div>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>