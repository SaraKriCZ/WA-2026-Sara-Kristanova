<!DOCTYPE html>
<html lang="cs">
<head>
    <?php $page_title = 'CarRate – Detail vozu'; require __DIR__ . '/../partials/_head.php'; ?>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <?php require __DIR__ . '/../partials/_navbar.php'; ?>

    <div class="container mx-auto px-4 max-w-5xl pb-12 flex-grow mt-8">

        <a href="javascript:history.back()" class="inline-block mb-5 text-gray-400 hover:text-blue-600 font-semibold text-sm transition">
            &larr; Zpět
        </a>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 mb-8">
            <!-- Foto -->
            <div class="relative h-64 md:h-80 bg-gray-100">
                <?php if (!empty($car['image_path'])): ?>
                    <img src="<?php echo htmlspecialchars($car['image_path']); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                        <span class="text-7xl mb-2">🚗</span>
                        <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">Bez fotografie</span>
                    </div>
                <?php endif; ?>
                <div class="absolute bottom-4 right-4">
                    <?php if ($car['recommend']): ?>
                        <div class="bg-green-500 text-white text-sm font-black px-5 py-2 rounded-full shadow-lg border-2 border-white">✅ DOPORUČENO</div>
                    <?php else: ?>
                        <div class="bg-red-500 text-white text-sm font-black px-5 py-2 rounded-full shadow-lg border-2 border-white">❌ NEDOPORUČENO</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="p-7 md:p-10">
                <!-- Název + tagy -->
                <div class="mb-7 pb-6 border-b border-gray-100">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3 tracking-tight">
                        <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>
                    </h1>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-blue-50 text-blue-700 font-bold px-3 py-1.5 rounded-lg border border-blue-100 text-sm">⛽ <?php echo htmlspecialchars($car['fuel']); ?></span>
                        <?php if (!empty($car['engine_volume']) || !empty($car['power'])): ?>
                            <span class="bg-gray-50 text-gray-700 font-bold px-3 py-1.5 rounded-lg border border-gray-200 text-sm">⚙️ <?php echo htmlspecialchars($car['engine_volume'] . ' / ' . $car['power'] . ' kW'); ?></span>
                        <?php endif; ?>
                        <span class="bg-gray-50 text-gray-700 font-bold px-3 py-1.5 rounded-lg border border-gray-200 text-sm">📅 <?php echo htmlspecialchars($car['year']); ?></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Hodnocení -->
                    <div class="lg:col-span-1">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Hodnocení</h3>
                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 flex flex-col gap-5">
                            <?php foreach (['Komfort' => 'rating_comfort', 'Jízdní vlastnosti' => 'rating_performance', 'Design' => 'rating_design'] as $label => $key): ?>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold mb-1"><?php echo $label; ?></p>
                                    <div class="flex text-xl gap-0.5">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php echo $i <= $car[$key] ? '<span class="text-blue-500">★</span>' : '<span class="text-gray-200">★</span>'; ?>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Text + akce -->
                    <div class="lg:col-span-2 flex flex-col">
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Hodnocení majitele</h2>
                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 text-gray-700 leading-relaxed mb-6 flex-grow text-sm">
                            <?php echo nl2br(htmlspecialchars($car['review_text'])); ?>
                        </div>

                        <!-- Reakce -->
                        <div class="flex flex-wrap gap-2 mb-6 pb-5 border-b border-gray-100">
                            <?php
                            $reactionButtons = [
                                'agree'       => ['emoji' => '👍', 'label' => 'Souhlasím',   'active' => 'bg-green-100 border-green-300 text-green-800',   'badge' => 'bg-green-200 text-green-900'],
                                'disagree'    => ['emoji' => '👎', 'label' => 'Nesouhlasím', 'active' => 'bg-red-100 border-red-300 text-red-800',         'badge' => 'bg-red-200 text-red-900'],
                                'interesting' => ['emoji' => '💡', 'label' => 'Zajímavé',    'active' => 'bg-yellow-100 border-yellow-300 text-yellow-800', 'badge' => 'bg-yellow-200 text-yellow-900'],
                            ];
                            foreach ($reactionButtons as $type => $btn):
                                $isActive   = ($my_reaction === $type);
                                $btnClass   = $isActive ? $btn['active'] . ' font-bold shadow-inner' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50';
                                $badgeClass = $isActive ? $btn['badge'] : 'bg-gray-100 text-gray-500';
                            ?>
                                <button onclick="toggleReaction('<?php echo $type; ?>')"
                                        class="flex items-center gap-2 px-3 py-1.5 rounded-full border transition-all text-sm <?php echo $btnClass; ?>">
                                    <?php echo $btn['emoji']; ?> <span><?php echo $btn['label']; ?></span>
                                    <span class="<?php echo $badgeClass; ?> px-1.5 py-0.5 rounded text-xs font-mono">
                                        <?php echo $counts[$type]; ?>
                                    </span>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <!-- Autor + tlačítka -->
                        <div class="flex flex-wrap justify-between items-center gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-extrabold text-lg">
                                    <?php echo strtoupper(substr($car['username'], 0, 1)); ?>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Recenzi napsal(a)</p>
                                    <p class="font-bold text-gray-800"><?php echo htmlspecialchars($car['username']); ?></p>
                                    <p class="text-xs text-gray-400 mt-0.5">Zveřejněno <?php echo date('j.n.Y \v H:i', strtotime($car['created_at'])); ?>
                                    </p>
                                </div>
                            </div>

                            <?php
                            $isOwner = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $car['user_id'];
                            $isAdmin = isset($_SESSION['role'])    && $_SESSION['role'] === 'admin';
                            ?>

                            <div class="flex gap-2 flex-wrap">
                                <?php if ($isOwner): ?>
                                    <a href="?url=review/edit&id=<?php echo $car['id']; ?>"
                                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-1.5 px-4 rounded-lg text-sm transition border border-gray-200">
                                        ✏️ Upravit
                                    </a>
                                <?php endif; ?>
                                <?php if ($isOwner || $isAdmin): ?>
                                    <button onclick="confirmDeleteReview()"
                                            class="bg-red-50 hover:bg-red-100 text-red-600 font-bold py-1.5 px-4 rounded-lg text-sm transition border border-red-200">
                                        🗑️ Smazat
                                    </button>
                                <?php endif; ?>
                                <?php if ($isAdmin && !$isOwner): ?>
                                    <span class="text-xs text-red-400 font-semibold self-center">👑 Admin akce</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Komentáře -->
        <div class="bg-white rounded-3xl shadow-xl p-7 md:p-10 border border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 mb-5 flex items-center gap-2">
                💬 Komentáře <span class="text-base text-gray-400 font-normal">(<?php echo count($comments); ?>)</span>
            </h3>

            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="?url=comment/add" method="POST" class="mb-8">
                    <input type="hidden" name="review_id" value="<?php echo $car['id']; ?>">
                    <textarea name="comment_text" rows="3"
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition resize-none text-sm"
                              placeholder="Napište svůj komentář..." required></textarea>
                    <div class="flex justify-end mt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-xl text-sm transition shadow-md">
                            Odeslat
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="bg-blue-50 p-4 rounded-2xl text-blue-700 text-sm mb-7 text-center">
                    Pro přidání komentáře se prosím <a href="?url=user/login" class="font-bold underline">přihlaste</a>.
                </div>
            <?php endif; ?>

            <div class="space-y-4">
                <?php if (empty($comments)): ?>
                    <p class="text-gray-400 text-center py-6 text-sm italic">Zatím žádné komentáře. Buď první!</p>
                <?php else: ?>
                    <?php foreach ($comments as $c): ?>
                        <div class="flex gap-3 p-4 rounded-2xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                            <div class="w-9 h-9 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold uppercase text-sm flex-shrink-0">
                                <?php echo substr($c['username'], 0, 1); ?>
                            </div>
                            <div class="flex-grow min-w-0">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <span class="font-bold text-gray-900 text-sm"><?php echo htmlspecialchars($c['username']); ?></span>
                                    <span class="text-xs text-gray-400 flex-shrink-0"><?php echo date('j.n.Y H:i', strtotime($c['created_at'])); ?></span>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed"><?php echo htmlspecialchars($c['comment_text']); ?></p>
                                <?php
                                $isCommentOwner = ($c['user_id'] == ($_SESSION['user_id'] ?? null));
                                $canEditComment  = $isCommentOwner;
                                $canDeleteComment= $isCommentOwner || $isAdmin;
                                if ($canEditComment || $canDeleteComment): ?>
                                    <div class="flex gap-3 mt-1">
                                        <?php if ($canEditComment): ?>
                                            <a href="?url=comment/edit&id=<?php echo $c['id']; ?>"
                                               class="text-amber-500 hover:text-amber-700 text-xs font-semibold transition">
                                                ✏️ Upravit
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($canDeleteComment): ?>
                                            <button onclick="confirmDeleteComment(<?php echo $c['id']; ?>)"
                                                    class="text-red-400 hover:text-red-600 text-xs font-semibold transition">
                                                🗑️ Smazat
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php require __DIR__ . '/../partials/_footer.php'; ?>

<script>
function toggleReaction(type) {
    const userId   = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;
    const authorId = <?php echo $car['user_id']; ?>;

    if (!userId) {
        showToast('Pro hodnocení se musíte nejprve přihlásit! 🔑', 'warning');
        setTimeout(() => window.location.href = '?url=user/login', 1800);
        return;
    }
    if (userId == authorId) {
        showToast('Na své vlastní recenze nelze reagovat 😉', 'info');
        return;
    }

    fetch('?url=reaction/toggle', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ review_id: "<?php echo $car['id']; ?>", reaction_type: type })
    })
    .then(r => r.json())
    .then(data => {
        if (data.status === 'success') window.location.reload();
        else showToast('Chyba: ' + (data.message ?? 'Neznámý problém'), 'error');
    })
    .catch(() => showToast('Chyba komunikace se serverem.', 'error'));
}

function confirmDeleteReview() {
    showConfirm(
        'Opravdu chceš smazat tuto recenzi? Akce je nevratná.',
        () => { window.location.href = '?url=review/delete&id=<?php echo $car['id']; ?>'; },
        { icon: '🗑️', confirmLabel: 'Ano, smazat' }
    );
}

function confirmDeleteComment(id) {
    showConfirm(
        'Opravdu chceš smazat tento komentář?',
        () => { window.location.href = '?url=comment/delete&id=' + id; },
        { icon: '💬', confirmLabel: 'Ano, smazat' }
    );
}
</script>
</body>
</html>
