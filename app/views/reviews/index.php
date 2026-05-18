<!DOCTYPE html>
<html lang="cs">
<head>
    <?php
    $page_title = 'CarRate – Skutečné recenze, skutečné zkušenosti';
    require __DIR__ . '/../partials/_head.php';
    ?>
    <style>
        .hero-bg {
            background-image: url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1400&q=80');
            background-size: cover;
            background-position: center;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp .55s ease both; }
        .fade-up-2 { animation: fadeUp .55s .1s ease both; }
        .fade-up-3 { animation: fadeUp .55s .2s ease both; }
        .fade-up-4 { animation: fadeUp .55s .3s ease both; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">

    <?php require __DIR__ . '/../partials/_navbar.php'; ?>

    <!-- ═══════════════════════════════════════════════
         HERO
    ════════════════════════════════════════════════ -->
    <section class="relative overflow-hidden bg-slate-900 min-h-[520px] flex flex-col">

        <!-- Fotka na pozadí -->
        <div class="hero-bg absolute inset-0 opacity-25"></div>
        <!-- Tmavý přechod -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/95 via-slate-900/80 to-blue-900/60"></div>

        <!-- Obsah -->
        <div class="relative z-10 flex-grow flex flex-col justify-center px-6 py-16 max-w-3xl mx-auto w-full">

            <!-- Odznak -->
            <div class="fade-up inline-flex items-center gap-2 self-start bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold px-4 py-1.5 rounded-full mb-6 tracking-wide uppercase">
                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span>
                Komunita řidičů
            </div>

            <h1 class="fade-up-2 text-5xl md:text-6xl font-extrabold text-white leading-tight mb-5 tracking-tight">
                Skutečné recenze.<br>
                <span class="text-blue-400">Skutečné zkušenosti.</span>
            </h1>

            <p class="fade-up-3 text-lg text-slate-400 leading-relaxed mb-8 max-w-xl">
                Hledáš spolehlivé auto? Nebo chceš ostatním říct, co jsi zažil?
                CarRate je místo, kde mají řidiči hlas – žádné PR, jen upřímné názory.
            </p>

            <div class="fade-up-4 flex flex-wrap gap-3">
                <a href="?url=review/create"
                   class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-7 rounded-full shadow-lg shadow-orange-500/30 transition hover:scale-105 text-base">
                    ✍️ Napsat recenzi
                </a>
                <a href="?url=catalog/index"
                   class="bg-white/10 hover:bg-white/16 text-white font-bold py-3 px-7 rounded-full border border-white/20 transition text-base">
                    🔍 Prozkoumat katalog
                </a>
            </div>
        </div>

        <!-- Stats bar -->
        <div class="relative z-10 border-t border-white/8 bg-white/5 backdrop-blur-sm">
            <div class="grid grid-cols-2 md:grid-cols-4 max-w-3xl mx-auto px-6">
                <?php
                $stats = [
                    ['num' => '1 200+', 'label' => 'Recenzí celkem'],
                    ['num' => '340+',   'label' => 'Modelů aut'],
                    ['num' => '60+',    'label' => 'Značek'],
                    ['num' => '98 %',   'label' => 'Spokojených čtenářů'],
                ];
                foreach ($stats as $s): ?>
                    <div class="py-5 px-4 text-center border-r border-white/8 last:border-0">
                        <div class="text-2xl font-extrabold text-white"><?php echo $s['num']; ?></div>
                        <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide mt-1"><?php echo $s['label']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         PROČ CARRATE
    ════════════════════════════════════════════════ -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-5xl">
            <div class="text-center mb-14">
                <p class="text-xs font-bold uppercase tracking-widest text-blue-600 mb-3">Proč CarRate?</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Recenze od lidí jako ty</h2>
                <p class="text-gray-500 mt-3 text-lg max-w-lg mx-auto">Žádní placení recenzenti. Jen majitelé, kteří ví, jaké to je jezdit každý den.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php
                $features = [
                    ['icon' => '🛡️', 'title' => '100% upřímné recenze',  'desc' => 'Každou recenzi píše skutečný majitel. Žádné sponzorované příspěvky, žádný marketing.'],
                    ['icon' => '🔍', 'title' => 'Pokročilé filtrování',   'desc' => 'Filtruj podle paliva, roku, hodnocení nebo verdiktu. Najdeš přesně to, co hledáš.'],
                    ['icon' => '💬', 'title' => 'Živá komunita',          'desc' => 'Komentuj a reaguj. Tvůj názor pomáhá ostatním udělat správné rozhodnutí.'],
                ];
                foreach ($features as $f): ?>
                    <div class="bg-gray-50 hover:bg-white border border-gray-100 hover:border-blue-100 hover:shadow-lg rounded-2xl p-7 transition-all duration-300">
                        <div class="text-3xl mb-4"><?php echo $f['icon']; ?></div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2"><?php echo $f['title']; ?></h3>
                        <p class="text-gray-500 text-sm leading-relaxed"><?php echo $f['desc']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         JAK TO FUNGUJE
    ════════════════════════════════════════════════ -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="text-center mb-14">
                <p class="text-xs font-bold uppercase tracking-widest text-blue-600 mb-3">Jak to funguje</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Tři kroky a jsi na cestě</h2>
                <p class="text-gray-500 mt-3 text-lg">Přidat recenzi trvá méně než 3 minuty.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 relative">
                <!-- Spojovací čára (jen desktop) -->
                <div class="hidden md:block absolute top-7 left-[calc(16.66%+16px)] right-[calc(16.66%+16px)] h-0.5 bg-blue-100 z-0"></div>

                <?php
                $steps = [
                    ['n' => '1', 'title' => 'Zaregistruj se',    'desc' => 'Rychlá registrace bez spamu. Stačí jméno a heslo.'],
                    ['n' => '2', 'title' => 'Ohodnoť své auto',  'desc' => 'Vyplň info, hvězdičky a popiš, jak auto opravdu jezdí.'],
                    ['n' => '3', 'title' => 'Pomoz ostatním',    'desc' => 'Tvoje recenze se okamžitě zobrazí tisícům hledačů.'],
                ];
                foreach ($steps as $step): ?>
                    <div class="relative z-10 text-center px-6 py-8 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="w-14 h-14 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-extrabold mx-auto mb-5 shadow-md shadow-blue-200">
                            <?php echo $step['n']; ?>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2"><?php echo $step['title']; ?></h3>
                        <p class="text-sm text-gray-500 leading-relaxed"><?php echo $step['desc']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         NEJNOVĚJŠÍ RECENZE (PHP data)
    ════════════════════════════════════════════════ -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-blue-600 mb-2">Nejnovější přírůstky</p>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Co řidiči přidali naposledy 🔥</h2>
                </div>
                <a href="?url=catalog/index" class="hidden sm:block text-blue-600 font-bold hover:underline text-sm">
                    Zobrazit vše &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
                <?php foreach ($top_reviews as $car): ?>
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-100 overflow-hidden hover:-translate-y-1 transition-all duration-300 flex flex-col">
                        <!-- Obrázek -->
                        <div class="relative h-48 bg-gray-100">
                            <?php if (!empty($car['image_path'])): ?>
                                <img src="<?php echo htmlspecialchars($car['image_path']); ?>"
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="flex items-center justify-center h-full text-5xl text-gray-300">🚗</div>
                            <?php endif; ?>
                            <!-- Verdikt badge -->
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
                            <h3 class="text-lg font-bold text-gray-900 mb-1">
                                <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>
                            </h3>
                            <p class="text-sm text-gray-400 mb-4">
                                📅 <?php echo htmlspecialchars($car['year']); ?> &nbsp;·&nbsp;
                                ⛽ <?php echo htmlspecialchars($car['fuel']); ?>
                            </p>
                            <a href="?url=review/show&id=<?php echo $car['id']; ?>"
                               class="mt-auto block w-full text-center bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold py-2.5 rounded-xl transition text-sm">
                                Číst recenzi &rarr;
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-8 text-center sm:hidden">
                <a href="?url=catalog/index" class="text-blue-600 font-bold hover:underline">Zobrazit celý katalog &rarr;</a>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         CTA BANNER
    ════════════════════════════════════════════════ -->
    <section class="py-20 bg-slate-900 relative overflow-hidden">
        <!-- Dekorativní světla -->
        <div class="absolute top-0 right-0 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 container mx-auto px-6 text-center max-w-2xl">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tight">
                Máš auto? Máš co říct. 💬
            </h2>
            <p class="text-slate-400 text-lg leading-relaxed mb-10">
                Každá recenze pomáhá tisícům lidí vybrat si správné auto.
                Přidej tu svoji – trvá to jen pár minut a hodně to znamená.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="?url=review/create"
                   class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 px-8 rounded-full shadow-lg shadow-orange-500/30 transition hover:scale-105 text-base">
                    ✍️ Napsat recenzi teď
                </a>
                <a href="?url=catalog/index"
                   class="bg-transparent hover:bg-white/8 text-slate-300 hover:text-white font-bold py-3.5 px-8 rounded-full border border-white/20 transition text-base">
                    Prozkoumat katalog &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         PARTNEŘI
    ════════════════════════════════════════════════ -->
    <section class="py-12 bg-white border-t border-gray-100">
        <div class="container mx-auto px-6 text-center">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-300 mb-6">Důvěřují nám profesionálové z oboru</p>
            <div class="flex flex-wrap justify-center gap-10 md:gap-16 grayscale opacity-40 hover:opacity-60 hover:grayscale-0 transition duration-500">
                <span class="text-xl font-black text-gray-700">AutoKelly</span>
                <span class="text-xl font-black text-gray-700">Mototechna</span>
                <span class="text-xl font-black text-gray-700">Škoda Auto</span>
                <span class="text-xl font-black text-gray-700">AAA Auto</span>
            </div>
        </div>
    </section>

    <?php require __DIR__ . '/../partials/_footer.php'; ?>

</body>
</html>
