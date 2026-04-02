<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knihovna - Seznam knížek</title>
</head>
<body>
<header>
    <h1>Aplikace Knihovna</h1>
    <nav>
        <ul>
    <li><a href="/WA-2026-SARA-KRISTANOVA/public/index.php">Seznam knih (Domů)</a></li>
    <li><a href="/WA-2026-SARA-KRISTANOVA/public/index.php?url=book/create">Přidat novou knihu</a></li>
</ul>
</nav>
</header>

<main>
    <h2>Dostupné knihy</h2>
    
    <?php if (!empty($books)): ?>
        <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr>
                    <th>Název</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Rok vydání</th>
                    <th>Cena</th>
                    <th>Odkaz</th> </tr>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $b): ?>
                    <tr>
                        <td><?= htmlspecialchars($b['title']) ?></td>
                        <td><?= htmlspecialchars($b['author']) ?></td>
                        <td><?= htmlspecialchars($b['isbn']) ?></td>
                        <td><?= htmlspecialchars($b['year']) ?></td>
                        <td><?= htmlspecialchars($b['price']) ?> Kč</td>
                        
                        <td>
                            <a href="/WA-2026-SARA-KRISTANOVA/public/index.php?url=book/edit/<?= $b['id'] ?>">Upravit</a> | 
                            <a href="/WA-2026-SARA-KRISTANOVA/public/index.php?url=book/delete/<?= $b['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')">Smazat</a>
                        </td>
                        
                        <td>
                            <?php if (!empty($b['link'])): ?>
                                <a href="<?= htmlspecialchars($b['link']) ?>" target="_blank" style="color: blue; text-decoration: underline;">
                                    Zobrazit knihu
                                </a> <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Zatím tu nejsou žádné knihy. Běžte nějakou přidat! ^^</p>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; WA 2026 - Výukový projekt</p>
</footer>
</body>
</html>