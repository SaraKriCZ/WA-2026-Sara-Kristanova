<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail knihy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">

<header class="bg-white shadow-sm border-b border-slate-200 mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
        <h1 class="text-2xl font-extrabold text-blue-600 tracking-tight">Knihovna<span class="text-orange-500">.</span></h1>
        <a href="/WA-2026-SARA-KRISTANOVA/public/index.php" class="text-slate-500 hover:text-blue-600 font-medium transition">&larr; Zpět na seznam</a>
    </div>
</header>

<main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
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
            
            <div class="mt-8 pt-6 border-t border-slate-100 flex gap-4">
                <a href="/WA-2026-SARA-KRISTANOVA/public/index.php?url=book/edit/<?= $book['id'] ?>" class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-xl shadow-sm transition duration-200">
                    Upravit tuto knihu
                </a>
            </div>
        </div>
    </div>
</main>
</body>
</html>