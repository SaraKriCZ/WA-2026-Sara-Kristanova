<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidat knihu</title>
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
        <div class="bg-blue-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white">Přidat novou knihu</h2>
            <p class="text-blue-100 mt-1">Vyplňte údaje níže a uložte knihu do databáze.</p>
        </div>

        <form action="/WA-2026-SARA-KRISTANOVA/public/index.php?url=book/store" method="post" enctype="multipart/form-data" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Název knihy <span class="text-orange-500">*</span></label>
                    <input type="text" id="title" name="title" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="author" class="block text-sm font-semibold text-slate-700 mb-2">Autor <span class="text-orange-500">*</span></label>
                    <input type="text" id="author" name="author" placeholder="např. Petr Houba" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="isbn" class="block text-sm font-semibold text-slate-700 mb-2">ISBN</label>
                    <input type="text" id="isbn" name="isbn" placeholder="978-..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">Kategorie</label>
                    <input type="text" id="category" name="category" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="subcategory" class="block text-sm font-semibold text-slate-700 mb-2">Podkategorie</label>
                    <input type="text" id="subcategory" name="subcategory" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label for="year" class="block text-sm font-semibold text-slate-700 mb-2">Rok vydání <span class="text-orange-500">*</span></label>
                    <input type="number" id="year" name="year" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
                <div>
                    <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">Cena (Kč)</label>
                    <input type="number" id="price" name="price" step="0.5" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div class="md:col-span-2">
                    <label for="link" class="block text-sm font-semibold text-slate-700 mb-2">Odkaz na e-shop / info</label>
                    <input type="url" id="link" name="link" placeholder="https://" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div class="md:col-span-2">
                    <label for="desc" class="block text-sm font-semibold text-slate-700 mb-2">Popis knihy</label>
                    <textarea name="desc" id="desc" rows="4" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
                </div>

                <div class="md:col-span-2 pt-4 border-t border-slate-100">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-md transition duration-200">
                        Uložit knihu do databáze
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>
</body>
</html>