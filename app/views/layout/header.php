<!DOCTYPE html>
<html lang="cs" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knihovna - Výuková aplikace</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col">

<header class="bg-white shadow-sm border-b border-slate-200 mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
        <h1 class="text-2xl font-extrabold text-blue-600 tracking-tight">Knihovna<span class="text-orange-500">.</span></h1>
        <nav class="flex items-center space-x-6">
            <a href="/WA-2026-SARA-KRISTANOVA/public/index.php" class="text-slate-500 hover:text-blue-600 font-medium transition">Domů</a>
            <a href="/WA-2026-SARA-KRISTANOVA/public/index.php?url=book/create" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg font-medium shadow-sm transition duration-150 ease-in-out">
                + Přidat novou knihu
            </a>
        </nav>
    </div>
</header>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
        <div class="space-y-3 mb-6">
            <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                <?php 
                    $styles = [
                        'success' => 'bg-green-100 border-green-500 text-green-800',
                        'error'   => 'bg-red-100 border-red-500 text-red-800',
                        'notice'  => 'bg-blue-100 border-blue-500 text-blue-800',
                    ];
                    $style = $styles[$type] ?? 'bg-slate-100 border-slate-500 text-slate-800';
                ?>
                <?php foreach ($messages as $message): ?>
                    <div class="<?= $style ?> border-l-4 p-4 rounded shadow-sm">
                        <p class="font-semibold text-sm"><?= htmlspecialchars($message) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <?php unset($_SESSION['messages']); ?>
        </div>
    <?php endif; ?>
</div>