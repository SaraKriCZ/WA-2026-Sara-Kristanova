<!DOCTYPE html>
<html lang="cs">
<head>
    <?php $page_title = 'CarRate – Katalog vozů'; require __DIR__ . '/../partials/_head.php'; ?>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <?php $active_page = 'catalog'; require __DIR__ . '/../partials/_navbar.php'; ?>

    <div class="container mx-auto px-6 max-w-7xl pb-12 flex-grow mt-8">

        <div class="mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-1">Katalog vozů 🔍</h1>
            <p class="text-gray-500 text-lg">Vyhledej si auto podle svých představ.</p>
        </div>

        <!-- Filtr -->
        <form action="" method="GET" class="bg-white p-6 rounded-2xl shadow border border-gray-100 mb-10 flex flex-col md:flex-row gap-4 items-end">
            <input type="hidden" name="url" value="catalog/index">
            <div class="w-full md:w-1/3">
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Hledat značku nebo model</label>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search_term); ?>"
                       placeholder="např. Škoda..."
                       class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>
            <div class="w-full md:w-1/4">
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Palivo</label>
                <select name="fuel" class="w-full border border-gray-200 rounded-xl py-2.5 px-4 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">-- Všechna paliva --</option>
                    <?php foreach (['Benzín','Nafta','Elektro','Hybrid'] as $f): ?>
                        <option value="<?php echo $f; ?>" <?php echo $fuel_type === $f ? 'selected' : ''; ?>><?php echo $f; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="w-full md:w-1/4">
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Verdikt</label>
                <select name="recommend" class="w-full border border-gray-200 rounded-xl py-2.5 px-4 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">-- Všechny --</option>
                    <option value="1" <?php echo (isset($_GET['recommend']) && $_GET['recommend']==='1') ? 'selected' : ''; ?>>✅ Doporučeno</option>
                    <option value="0" <?php echo (isset($_GET['recommend']) && $_GET['recommend']==='0') ? 'selected' : ''; ?>>❌ Nedoporučeno</option>
                </select>
            </div>
            <div class="w-full md:w-auto flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow">
                    Filtrovat
                </button>
                <?php if (!empty($search_term) || !empty($fuel_type) || $recommend_status !== ''): ?>
                    <a href="?url=catalog/index" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-5 rounded-xl transition text-center">✖</a>
                <?php endif; ?>
            </div>
        </form>

        <?php if (empty($cars)): ?>
            <div class="bg-white p-14 rounded-2xl shadow border border-gray-100 text-center max-w-xl mx-auto">
                <p class="text-6xl mb-4">🏜️</p>
                <p class="text-2xl font-bold text-gray-700 mb-2">Nic jsme nenašli!</p>
                <p class="text-gray-400 mb-6">Žádné auto neodpovídá zadaným filtrům.</p>
                <a href="?url=catalog/index" class="text-blue-600 hover:underline font-bold">Zobrazit vše</a>
            </div>

        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                <?php foreach ($cars as $car): ?>

                    <!-- Celá karta = klikatelná -->
                    <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden
                                cursor-pointer hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col"
                         onclick="window.location='?url=review/show&id=<?php echo $car['id']; ?>'">

                        <!-- Obrázek -->
                        <div class="relative h-52 bg-gray-100 flex-shrink-0">
                            <?php if (!empty($car['image_path'])): ?>
                                <img src="<?php echo htmlspecialchars($car['image_path']); ?>"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-5xl text-gray-200">🚗</div>
                            <?php endif; ?>
                            <div class="absolute top-3 right-3">
                                <?php if ($car['recommend']): ?>
                                    <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">👍 Doporučeno</span>
                                <?php else: ?>
                                    <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">❌ Nebrat</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Text -->
                        <div class="p-5 flex flex-col flex-grow">
                            <h2 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition mb-1">
                                <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>
                            </h2>
                            <div class="flex gap-2 mb-3">
                                <span class="bg-blue-50 text-blue-700 text-xs font-bold px-2 py-1 rounded">⛽ <?php echo htmlspecialchars($car['fuel']); ?></span>
                                <span class="bg-gray-50 text-gray-600 text-xs font-bold px-2 py-1 rounded">📅 <?php echo htmlspecialchars($car['year']); ?></span>
                            </div>
                            <p class="text-gray-500 text-sm line-clamp-3 mb-4 flex-grow">
                                <?php echo htmlspecialchars($car['review_text']); ?>
                            </p>
                            <p class="text-xs text-gray-400 border-t pt-3 mt-auto">
                                👤 <?php echo htmlspecialchars($car['username']); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php require __DIR__ . '/../partials/_footer.php'; ?>

</body>
</html>
