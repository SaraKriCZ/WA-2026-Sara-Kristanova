<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 flex-grow w-full">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-slate-100">
        <div class="bg-slate-800 px-8 py-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-white">Přidat novou knihu</h2>
                <p class="text-slate-300 mt-1">Zadejte detaily pro zařazení nové knihy do databáze.</p>
            </div>
        </div>

        <form action="/WA-2026-SARA-KRISTANOVA/public/index.php?url=book/store" method="post" enctype="multipart/form-data" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Název knihy <span class="text-orange-500">*</span></label>
                    <input type="text" id="title" name="title" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Např. Pán prstenů">
                </div>

                <div>
                    <label for="author" class="block text-sm font-semibold text-slate-700 mb-2">Autor <span class="text-orange-500">*</span></label>
                    <input type="text" id="author" name="author" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Např. J. R. R. Tolkien">
                </div>

                <div>
                    <label for="isbn" class="block text-sm font-semibold text-slate-700 mb-2">ISBN</label>
                    <input type="text" id="isbn" name="isbn" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Např. 978-80-257-2315-7">
                </div>

                <div>
                    <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">Kategorie</label>
                    <input type="text" id="category" name="category" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Např. Fantasy">
                </div>

                <div>
                    <label for="subcategory" class="block text-sm font-semibold text-slate-700 mb-2">Podkategorie</label>
                    <input type="text" id="subcategory" name="subcategory" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Např. Epická fantasy">
                </div>

                <div>
                    <label for="year" class="block text-sm font-semibold text-slate-700 mb-2">Rok vydání <span class="text-orange-500">*</span></label>
                    <input type="number" id="year" name="year" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Např. 1954">
                </div>
                <div>
                    <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">Cena (Kč)</label>
                    <input type="number" id="price" name="price" step="0.5" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Např. 450">
                </div>

                <div class="md:col-span-2">
                    <label for="link" class="block text-sm font-semibold text-slate-700 mb-2">Odkaz</label>
                    <input type="url" id="link" name="link" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="https://...">
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Popis knihy</label>
                    <textarea id="description" name="description" rows="5" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Stručný děj nebo poznámky..."></textarea>
                </div>

                <div class="md:col-span-2 pt-4 border-t border-slate-100">
                    <label class="block text-sm font-semibold text-slate-500 mb-2 uppercase tracking-wider">Obrázky knihy</label>
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
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-md transition duration-200">
                        Přidat knihu do databáze
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