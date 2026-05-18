<?php
/**
 * PARTIAL: _head.php
 * Společná hlavička – meta, font, Tailwind.
 * Proměnné: $page_title (volitelné)
 */
$page_title = $page_title ?? 'CarRate';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($page_title); ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<style>
  body { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>
