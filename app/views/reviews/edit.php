<!DOCTYPE html>
<html lang="cs">
<head>
    <?php $page_title = 'CarRate – Upravit recenzi'; require __DIR__ . '/../partials/_head.php'; ?>
    <style>
        .star-rating span { font-size:2rem; cursor:pointer; color:#D1D5DB; transition:color .15s; }
        .star-rating span.active { color:#FBBF24; }
        .star-group { display:flex; flex-direction:row-reverse; justify-content:flex-end; }
    </style>
</head>
<body class="bg-gray-100 flex flex-col" style="height:100vh">

    <?php require __DIR__ . '/../partials/_navbar.php'; ?>

    <div class="flex-1 overflow-y-auto py-8 px-4">
    <div class="bg-white p-7 rounded-2xl shadow-xl w-full max-w-3xl mx-auto border border-gray-100">

        <!-- Hlavička editace – vizuálně odlišná od create (viditelné ID + štítek "Úprava") -->
        <div class="flex items-start justify-between mb-6 pb-5 border-b border-gray-100">
            <div>
                <span class="inline-block bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full mb-2 tracking-wide uppercase">
                    ✏️ Úprava záznamu
                </span>
                <h1 class="text-2xl font-extrabold text-gray-900">
                    <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>
                </h1>
                <p class="text-gray-400 text-sm mt-0.5">Rok <?php echo htmlspecialchars($car['year']); ?></p>
            </div>
            <!-- Viditelné ID záznamu – rozdíl oproti formuláři pro přidání -->
            <div class="text-right shrink-0 ml-4">
                <span class="text-xs text-gray-400 font-semibold uppercase tracking-wide block">ID záznamu</span>
                <span class="text-2xl font-extrabold text-gray-200">#<?php echo htmlspecialchars($car['id']); ?></span>
            </div>
        </div>

        <form id="car-form" action="?url=review/update" method="POST" enctype="multipart/form-data" novalidate>

            <!-- Základní pole -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Značka <span class="text-red-500">*</span></label>
                    <input type="text" name="brand" value="<?php echo htmlspecialchars($car['brand']); ?>" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Model <span class="text-red-500">*</span></label>
                    <input type="text" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Rok výroby <span class="text-red-500">*</span></label>
                    <input type="number" name="year" value="<?php echo htmlspecialchars($car['year']); ?>" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Palivo <span class="text-red-500">*</span></label>
                    <select name="fuel" required class="w-full border border-gray-200 rounded-xl py-2.5 px-4 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <?php foreach (['Benzín','Nafta','Elektro','Hybrid'] as $f): ?>
                            <option value="<?php echo $f; ?>" <?php echo $car['fuel']===$f?'selected':''; ?>><?php echo $f; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Typ motoru <span class="text-red-500">*</span></label>
                    <input type="text" name="engine_volume" value="<?php echo htmlspecialchars($car['engine_volume']); ?>" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Výkon (kW) <span class="text-red-500">*</span></label>
                    <input type="number" name="power" value="<?php echo htmlspecialchars($car['power']); ?>" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>

            <!-- Fotka – s varováním o výměně -->
            <div class="mb-5 bg-amber-50 border border-amber-100 rounded-2xl p-4">
                <h3 class="text-sm font-bold text-gray-700 mb-3">📸 Fotografie vozu</h3>
                <div class="flex items-center gap-4 mb-3">
                    <?php if (!empty($car['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($car['image_path']); ?>"
                             class="w-24 h-16 object-cover rounded-xl border border-gray-200 shrink-0">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Aktuální fotka</p>
                            <p class="text-xs text-amber-600">Nahráním nové bude tato trvale smazána.</p>
                        </div>
                    <?php else: ?>
                        <div class="w-20 h-14 bg-gray-100 rounded-xl flex items-center justify-center text-2xl text-gray-300 shrink-0">🚗</div>
                        <p class="text-sm text-gray-500">Zatím bez fotky.</p>
                    <?php endif; ?>
                </div>
                <input type="file" name="image" id="photo-input" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-full
                              file:border-0 file:font-bold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                <p id="photo-warning" class="hidden text-xs text-amber-700 font-semibold mt-2">
                    ⚠️ Stávající fotka bude <strong>trvale smazána</strong> po uložení.
                </p>
            </div>

            <!-- Hvězdičky -->
            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 mb-5">
                <h3 class="text-sm font-bold text-gray-800 mb-3">Hodnocení ⭐</h3>
                <div class="grid grid-cols-3 gap-4">
                    <?php foreach (['rating_comfort'=>'Komfort','rating_performance'=>'Jízdní vlastnosti','rating_design'=>'Design'] as $key=>$label): ?>
                        <div class="text-center star-container" data-input-id="<?php echo $key; ?>">
                            <label class="block text-xs font-bold text-gray-600 mb-1"><?php echo $label; ?> <span class="text-red-500">*</span></label>
                            <input type="hidden" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo htmlspecialchars($car[$key]); ?>" required>
                            <div class="star-rating star-group">
                                <?php for ($i=5;$i>=1;$i--): ?>
                                    <span data-value="<?php echo $i; ?>" class="<?php echo $i<=$car[$key]?'active':''; ?>">★</span>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Text recenze -->
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Slovní hodnocení <span class="text-red-500">*</span></label>
                <textarea name="review_text" rows="3" required
                          class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none"><?php echo htmlspecialchars($car['review_text']); ?></textarea>
            </div>

            <!-- Doporučení -->
            <div class="mb-6 flex items-center bg-amber-50 p-3 rounded-xl border border-amber-100 hover:bg-amber-100 transition">
                <input type="checkbox" name="recommend" id="recommend" class="w-5 h-5 text-amber-600 rounded"
                       <?php echo $car['recommend']?'checked':''; ?>>
                <label for="recommend" class="ml-3 text-sm font-bold text-gray-900 cursor-pointer">
                    Doporučil/a bych toto auto ostatním 👍
                </label>
            </div>

            <!-- Tlačítka + hidden ID až zde dole (ne na začátku jako v create) -->
            <div class="flex gap-3">
                <a href="?url=review/show&id=<?php echo $car['id']; ?>"
                   class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl transition border border-gray-200">
                    Zrušit
                </a>
                <button type="submit"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition shadow-md shadow-orange-200">
                    💾 Uložit úpravy
                </button>
            </div>

            <!-- Hidden ID je záměrně AŽ ZDE – ne na začátku formuláře jako v create -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($car['id']); ?>">

        </form>
    </div>
    </div>

    <?php require __DIR__ . '/../partials/_footer.php'; ?>

<script>
// Hvězdičky
document.querySelectorAll('.star-rating').forEach(group => {
    const stars = group.querySelectorAll('span');
    const input = document.getElementById(group.parentElement.dataset.inputId);
    stars.forEach(star => {
        star.addEventListener('click', function() {
            input.value = this.dataset.value;
            stars.forEach(s => s.classList.remove('active'));
            this.classList.add('active');
            let n = this.nextElementSibling;
            while (n) { n.classList.add('active'); n = n.nextElementSibling; }
        });
    });
});

// Upozornění při výběru nové fotky
document.getElementById('photo-input')?.addEventListener('change', function() {
    document.getElementById('photo-warning').classList.toggle('hidden', !this.files.length);
});

// Validace → toast
document.getElementById('car-form').addEventListener('submit', function(e) {
    let hasError = false;
    this.querySelectorAll('[required]').forEach(f => {
        if (!f.value.trim()) {
            hasError = true;
            if (f.type === 'hidden') {
                f.closest('.star-container').classList.add('bg-red-50','border','border-red-400','rounded-xl');
            } else {
                f.classList.add('border-red-400','ring-2','ring-red-200');
            }
        }
    });
    if (hasError) {
        e.preventDefault();
        showToast('Vyplň prosím všechna povinná pole označená *', 'error');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
</script>
</body>
</html>
