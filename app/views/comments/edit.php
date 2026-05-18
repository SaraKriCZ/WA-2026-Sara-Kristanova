<!DOCTYPE html>
<html lang="cs">
<head>
    <?php $page_title = 'CarRate – Upravit komentář'; require __DIR__ . '/../partials/_head.php'; ?>
</head>
<body class="bg-gray-100 flex flex-col" style="height:100vh">

    <?php require __DIR__ . '/../partials/_navbar.php'; ?>

    <div class="flex-1 flex items-center justify-center px-4 overflow-y-auto py-6">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg border border-gray-100 p-8">

            <div class="mb-6">
                <span class="inline-block bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full mb-3 tracking-wide uppercase">
                    ✏️ Úprava komentáře
                </span>
                <h1 class="text-2xl font-extrabold text-gray-900">Upravit komentář</h1>
                <p class="text-gray-400 text-sm mt-1">
                    K recenzi:
                    <a href="?url=review/show&id=<?php echo $comment['review_id']; ?>"
                       class="font-semibold text-blue-600 hover:underline">
                        <?php echo htmlspecialchars(($review['brand'] ?? '') . ' ' . ($review['model'] ?? '')); ?>
                    </a>
                </p>
            </div>

            <form action="?url=comment/update" method="POST" id="comment-form" novalidate>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($comment['id']); ?>">

                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">
                        Text komentáře <span class="text-red-500">*</span>
                    </label>
                    <textarea name="comment_text" id="comment-text" rows="5" required
                              class="w-full border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none"
                    ><?php echo htmlspecialchars($comment['comment_text']); ?></textarea>
                    <p class="text-xs text-gray-400 mt-1 text-right">
                        <span id="char-count"><?php echo mb_strlen($comment['comment_text']); ?></span> znaků
                    </p>
                </div>

                <div class="flex gap-3">
                    <a href="?url=review/show&id=<?php echo $comment['review_id']; ?>"
                       class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl transition border border-gray-200">
                        Zrušit
                    </a>
                    <button type="submit"
                            class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition shadow-md shadow-orange-100">
                        💾 Uložit změny
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php require __DIR__ . '/../partials/_footer.php'; ?>

<script>
const textarea  = document.getElementById('comment-text');
const charCount = document.getElementById('char-count');
textarea.addEventListener('input', () => charCount.textContent = textarea.value.length);

document.getElementById('comment-form').addEventListener('submit', function(e) {
    if (!textarea.value.trim()) {
        e.preventDefault();
        showToast('Komentář nesmí být prázdný.', 'error');
        textarea.classList.add('border-red-400', 'ring-2', 'ring-red-200');
    }
});
textarea.addEventListener('input', () =>
    textarea.classList.remove('border-red-400', 'ring-2', 'ring-red-200'));
</script>
</body>
</html>
