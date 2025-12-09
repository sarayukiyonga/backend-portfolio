<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $page_title ?? $titulo ?? 'Admin Panel' ?> - Portfolio</title>

<!-- CSS Principal -->
<link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">

<?php if (isset($extra_css) && is_array($extra_css)): ?>
    <?php foreach ($extra_css as $css): ?>
        <link rel="stylesheet" href="<?= base_url($css) ?>">
    <?php endforeach; ?>
    
<?php endif; ?>
