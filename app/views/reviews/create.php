<!DOCTYPE html>
<html lang="cs">
<head>
    <?php $page_title = 'CarRate – Přidat recenzi'; require __DIR__ . '/../partials/_head.php'; ?>
    <style>
        .star-rating span { font-size:2rem; cursor:pointer; color:#D1D5DB; transition:color .15s; }
        .star-rating span.active { color:#FBBF24; }
        .star-group { display:flex; flex-direction:row-reverse; justify-content:flex-end; }
    </style>
</head>
<body class="bg-gray-100 flex flex-col" style="height:100vh">

    <?php require __DIR__ . '/../partials/_navbar.php'; ?>

    <!-- Scrollovatelný obsah pod navbarem -->
    <div class="flex-1 overflow-y-auto py-8 px-4">
    <div class="bg-white p-7 rounded-2xl shadow-xl w-full max-w-3xl mx-auto border border-gray-100">

        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-gray-900">Přidat novou recenzi 🚘</h1>
            <p class="text-gray-500 text-sm mt-1">Ohodnoťte vůz ve všech kategoriích</p>
        </div>

        <form id="car-form" action="?url=review/create" method="POST" enctype="multipart/form-data" novalidate>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Značka <span class="text-red-500">*</span></label>
                    <input type="text" name="brand" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Model <span class="text-red-500">*</span></label>
                    <input type="text" name="model" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Rok výroby <span class="text-red-500">*</span></label>
                    <input type="number" name="year" min="1900" max="2099" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Palivo <span class="text-red-500">*</span></label>
                    <select name="fuel" required class="w-full border border-gray-200 rounded-xl py-2.5 px-4 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <option value="" disabled selected>-- Vyberte --</option>
                        <?php foreach (['Benzín','Nafta','Elektro','Hybrid'] as $f): ?>
                            <option value="<?php echo $f; ?>"><?php echo $f; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Typ motoru <span class="text-red-500">*</span></label>
                    <input type="text" name="engine_volume" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Výkon (kW) <span class="text-red-500">*</span></label>
                    <input type="number" name="power" min="0" required
                           class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>

            <!-- Fotka + náhled -->
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Fotografie vozu</label>
                <input type="file" name="image" id="imageInput" accept="image/*"
                       onchange="previewImage(event)"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0
                              file:font-bold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                <div id="imagePreviewContainer" class="hidden mt-3">
                    <img id="imagePreview" src="" alt="Náhled" class="h-36 rounded-xl border border-gray-200 object-cover">
                </div>
            </div>

            <!-- Hodnocení -->
            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 mb-5">
                <h3 class="text-sm font-bold text-gray-800 mb-3">Hodnocení ⭐</h3>
                <div class="grid grid-cols-3 gap-4">
                    <?php foreach (['rating_comfort' => 'Komfort', 'rating_performance' => 'Jízdní vlastnosti', 'rating_design' => 'Design'] as $key => $label): ?>
                        <div class="text-center star-container" data-input-id="<?php echo $key; ?>">
                            <label class="block text-xs font-bold text-gray-600 mb-1"><?php echo $label; ?> <span class="text-red-500">*</span></label>
                            <input type="hidden" name="<?php echo $key; ?>" id="<?php echo $key; ?>" required>
                            <div class="star-rating star-group">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <span data-value="<?php echo $i; ?>">★</span>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Slovní hodnocení -->
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Slovní hodnocení <span class="text-red-500">*</span></label>
                <textarea name="review_text" rows="3" required
                          class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none"></textarea>
            </div>

            <!-- Doporučení -->
            <div class="mb-6 flex items-center bg-amber-50 p-3 rounded-xl border border-amber-100 hover:bg-amber-100 transition">
                <input type="checkbox" name="recommend" id="recommend" class="w-5 h-5 text-amber-600 rounded">
                <label for="recommend" class="ml-3 text-sm font-bold text-gray-900 cursor-pointer">
                    Doporučil/a bych toto auto ostatním 👍
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition shadow-md shadow-orange-200 text-base">
                Uložit recenzi 🚘
            </button>
        </form>
    </div>
    </div><!-- /scroll -->

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
            group.parentElement.classList.remove('bg-red-50','border-red-400');
        });
    });
});

// Náhled fotky
function previewImage(event) {
    const file = event.target.files[0];
    const wrap = document.getElementById('imagePreviewContainer');
    const img  = document.getElementById('imagePreview');
    if (file) {
        const r = new FileReader();
        r.onload = e => { img.src = e.target.result; wrap.classList.remove('hidden'); };
        r.readAsDataURL(file);
    } else { wrap.classList.add('hidden'); }
}

// Validace → toast
document.getElementById('car-form').addEventListener('submit', function(e) {
    let errors = [];
    this.querySelectorAll('[required]').forEach(f => {
        if (!f.value.trim()) {
            errors.push(f.name);
            if (f.type === 'hidden') {
                f.closest('.star-container').classList.add('bg-red-50','border','border-red-400','rounded-xl');
            } else {
                f.classList.add('border-red-400','ring-2','ring-red-200');
            }
        }
    });
    if (errors.length) {
        e.preventDefault();
        showToast('Vyplň prosím všechna povinná pole označená *', 'error');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

// Odstraň chybové styly při opravě
document.querySelectorAll('input:not([type="hidden"]),textarea,select').forEach(f => {
    f.addEventListener('input', () => f.classList.remove('border-red-400','ring-2','ring-red-200'));
});
</script>
</body>
</html>
