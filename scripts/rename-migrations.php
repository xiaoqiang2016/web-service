<?php
$migrations = [
    '0001_01_01_000000_create_users_table.php',
    '0001_01_01_000001_create_cache_table.php',
    '0001_01_01_000002_create_jobs_table.php',
    '2026_06_16_101404_create_languages_table.php',
    '2026_06_16_101405_create_admin_roles_table.php',
    '2026_06_16_101406_create_admin_users_table.php',
    '2026_06_16_101407_create_site_configs_table.php',
    '2026_06_16_101408_create_categories_table.php',
    '2026_06_16_101409_create_articles_table.php',
    '2026_06_16_101410_create_products_table.php',
    '2026_06_16_101411_create_banners_table.php',
    '2026_06_16_101412_create_cases_table.php',
    '2026_06_16_101413_create_links_table.php',
    '2026_06_16_101414_create_jobs_table.php',
    '2026_06_16_101415_create_downloads_table.php',
    '2026_06_16_101416_create_messages_table.php',
    '2026_06_16_101417_create_site_config_translations_table.php',
    '2026_06_16_101418_create_category_translations_table.php',
    '2026_06_16_101419_create_article_translations_table.php',
    '2026_06_16_101420_create_product_translations_table.php',
    '2026_06_16_101421_create_banner_translations_table.php',
    '2026_06_16_101422_create_case_translations_table.php',
    '2026_06_16_101423_create_link_translations_table.php',
    '2026_06_16_101424_create_job_translations_table.php',
    '2026_06_16_101425_create_download_translations_table.php',
    '2026_06_16_101426_rename_default_jobs_table.php',
];

$currentFiles = glob('database/migrations/*.php');
$baseNames = array_map('basename', $currentFiles);

$mapping = [];
foreach ($baseNames as $file) {
    if (str_starts_with($file, '0001')) {
        $mapping[$file] = $file;
        continue;
    }
    
    $parts = explode('_', $file);
    $name = implode('_', array_slice($parts, 4));
    
    foreach ($migrations as $target) {
        $targetParts = explode('_', $target);
        $targetName = implode('_', array_slice($targetParts, 4));
        if ($name === $targetName) {
            $mapping[$file] = $target;
            break;
        }
    }
}

foreach ($mapping as $old => $new) {
    if ($old !== $new) {
        echo "Renaming $old -> $new\n";
        rename('database/migrations/' . $old, 'database/migrations/' . $new);
    }
}

echo "Done!\n";
