<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 flex-grow w-full">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-slate-100">
        <div class="bg-slate-800 px-8 py-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-white">Upravit knihu</h2>
                <p class="text-slate-300 mt-1">Nyní upravujete: <strong class="text-white"><?= htmlspecialchars($book['title']) ?></strong></p>
            </div>
            <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">ID: <?= htmlspecialchars($book['id']) ?></span>
        </div>

        <form action="/WA-2026-SARA-KRISTANOVA/public/index.php?url=book/update/<?= htmlspecialchars($book['id']) ?>" method="post" enctype="multipart/form-data" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Název knihy <span class="text-orange-500">*</span></label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="author" class="block text-sm font-semibold text-slate-700 mb-2">Autor <span class="text-orange-500">*</span></label>
                    <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="isbn" class="block text-sm font-semibold text-slate-700 mb-2">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">Kategorie</label>
                    <input type="text" id="category" name="category" value="<?= htmlspecialchars($book['category']) ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="subcategory" class="block text-sm font-semibold text-slate-700 mb-2">Podkategorie</label>
                    <input type="text" id="subcategory" name="subcategory" value="<?= htmlspecialchars($book['subcategory']) ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="year" class="block text-sm font-semibold text-slate-700 mb-2">Rok vydání <span class="text-orange-500">*</span></label>
                    <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
                
                <div>
                    <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">Cena (Kč)</label>
                    <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($book['price']) ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div class="md:col-span-2">
                    <label for="link" class="block text-sm font-semibold text-slate-700 mb-2">Odkaz</label>
                    <input type="url" id="link" name="link" value="<?= htmlspecialchars($book['link']) ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Popis knihy</label>
                    <textarea id="description" name="description" rows="5" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"><?= htmlspecialchars($book['description']) ?></textarea>
                </div>

                <div class="md:col-span-2 pt-4 border-t border-slate-100">
                    <label class="block text-sm font-semibold text-slate-500 mb-2 uppercase tracking-wider">Obrázky knihy</label>
                    
                    <?php 
                    // Převod JSONu z databáze zpět na pole
                    $existingImages = !empty($book['images']) ? json_decode($book['images'], true) : []; 
                    ?>
                    
                    <?php if (!empty($existingImages) && is_array($existingImages)): ?>
                        <div class="mb-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <p class="text-sm text-slate-700 font-semibold mb-3">Aktuálně nahrané obrázky:</p>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <?php foreach ($existingImages as $img): ?>
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-white border border-slate-200 text-slate-600 shadow-sm">
                                        🖼️ <?= htmlspecialchars($img) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                            <p class="text-xs text-orange-600 font-bold flex items-center gap-1 bg-orange-50 p-2 rounded-lg border border-orange-100 mt-2">
                                ⚠️ Upozornění: Pokud nyní nahrajete nové soubory, tyto staré budou trvale přepsány.
                            </p>
                        </div>
                    <?php endif; ?>

                    <div class="w-full">
                        <label for="images" class="flex flex-col items-center justify-center w-full h-24 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-orange-50 hover:border-orange-400 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <span id="file-title" class="text-sm text-slate-500 font-semibold">Klikni pro výběr souborů</span>
                                <span id="file-info" class="text-xs text-slate-400 mt-1 text-center px-4">Žádné soubory nebyly vybrány</span>
                            </div>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                        </label>
                    </div>
                </div>
                <div class="md:col-span-2 pt-4 flex gap-4">
                    <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-xl shadow-md transition duration-200">
                        Uložit změny
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
    const fileInput = document.getElementById('images');
    const fileTitle = document.getElementById('file-title');
    const fileInfo = document.getElementById('file-info');

    fileInput.addEventListener('change', function(event) {
        const files = event.target.files;
        
        if (files.length === 0) {
            fileTitle.textContent = 'Klikni pro výběr souborů';
            fileTitle.className = 'text-sm text-slate-500 font-semibold';
            fileInfo.textContent = 'Žádné soubory nebyly vybrány';
        } else if (files.length === 1) {
            fileTitle.textContent = 'Soubor připraven';
            fileTitle.className = 'text-sm text-orange-500 font-bold'; 
            fileInfo.textContent = files[0].name;
        } else {
            fileTitle.textContent = 'Soubory připraveny';
            fileTitle.className = 'text-sm text-orange-500 font-bold';
            fileInfo.textContent = 'Vybráno celkem: ' + files.length + ' souborů';
        }
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>