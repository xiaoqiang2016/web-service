<?php

$viewsDir = __DIR__ . '/../resources/views/admin';
$files = glob($viewsDir . '/**/*.blade.php');

$replacements = [
    // Common text replacements
    'Categories' => '__(\'admin.categories.index.header\')',
    'Add Category' => '__(\'admin.actions.create\')',
    'Category' => '__(\'admin.common.category\')',
    'Categories' => '__(\'admin.categories.index.header\')',
    'Name' => '__(\'admin.common.name\')',
    'Type' => '__(\'admin.common.type\')',
    'Parent' => '__(\'admin.common.parent\')',
    'Show' => '__(\'admin.common.show\')',
    'Actions' => '__(\'admin.actions\')',
    'Edit' => '__(\'admin.actions.edit\')',
    'Delete' => '__(\'admin.actions.delete\')',
    'Are you sure?' => '__(\'admin.actions.confirm_delete\')',
    'None' => '__(\'admin.common.none\')',
    'Yes' => '__(\'admin.common.yes\')',
    'No' => '__(\'admin.common.no\')',
    'Create Category' => '__(\'admin.categories.create.title\')',
    'Edit Category' => '__(\'admin.categories.edit.title\')',
    'Slug' => '__(\'admin.common.slug\')',
    'Description' => '__(\'admin.common.description\')',
    'Sort Order' => '__(\'admin.common.sort_order\')',
    'Create' => '__(\'admin.actions.create\')',
    'Update' => '__(\'admin.actions.update\')',
    
    // Articles
    'Articles' => '__(\'admin.articles.index.header\')',
    'Add Article' => '__(\'admin.actions.create\')',
    'Title' => '__(\'admin.common.title\')',
    'Content' => '__(\'admin.common.content\')',
    'Status' => '__(\'admin.common.status\')',
    'Created At' => '__(\'admin.common.created_at\')',
    'Create Article' => '__(\'admin.articles.create.title\')',
    'Edit Article' => '__(\'admin.articles.edit.title\')',
    'Meta Title' => '__(\'admin.common.meta_title\')',
    'Meta Description' => '__(\'admin.common.meta_description\')',
    'Meta Keywords' => '__(\'admin.common.meta_keywords\')',
    
    // Products
    'Products' => '__(\'admin.products.index.header\')',
    'Add Product' => '__(\'admin.actions.create\')',
    'Price' => '__(\'admin.common.price\')',
    'SKU' => '__(\'admin.common.sku\')',
    'Stock' => '__(\'admin.common.stock\')',
    'Image' => '__(\'admin.common.image\')',
    'Create Product' => '__(\'admin.products.create.title\')',
    'Edit Product' => '__(\'admin.products.edit.title\')',
    
    // Banners
    'Banners' => '__(\'admin.banners.index.header\')',
    'Add Banner' => '__(\'admin.actions.create\')',
    'Position' => '__(\'admin.common.position\')',
    'URL' => '__(\'admin.common.url\')',
    'Create Banner' => '__(\'admin.banners.create.title\')',
    'Edit Banner' => '__(\'admin.banners.edit.title\')',
    
    // Cases
    'Cases' => '__(\'admin.cases.index.header\')',
    'Add Case' => '__(\'admin.actions.create\')',
    'Create Case' => '__(\'admin.cases.create.title\')',
    'Edit Case' => '__(\'admin.cases.edit.title\')',
    
    // Messages
    'Messages' => '__(\'admin.messages.index.header\')',
    'View Message' => '__(\'admin.messages.show.title\')',
    'Email' => '__(\'admin.common.email\')',
    'Subject' => '__(\'admin.common.subject\')',
    'Date' => '__(\'admin.common.date\')',
    'Read' => '__(\'admin.messages.read\')',
    'Unread' => '__(\'admin.messages.unread\')',
    
    // Links
    'Links' => '__(\'admin.links.index.header\')',
    'Add Link' => '__(\'admin.actions.create\')',
    'Create Link' => '__(\'admin.links.create.title\')',
    'Edit Link' => '__(\'admin.links.edit.title\')',
    
    // Jobs
    'Jobs' => '__(\'admin.jobs.index.header\')',
    'Add Job' => '__(\'admin.actions.create\')',
    'Job Title' => '__(\'admin.common.job_title\')',
    'Job Type' => '__(\'admin.common.job_type\')',
    'Location' => '__(\'admin.common.location\')',
    'Salary' => '__(\'admin.common.salary\')',
    'Deadline' => '__(\'admin.common.deadline\')',
    'Company' => '__(\'admin.common.company\')',
    'Create Job' => '__(\'admin.jobs.create.title\')',
    'Edit Job' => '__(\'admin.jobs.edit.title\')',
    
    // Downloads
    'Downloads' => '__(\'admin.downloads.index.header\')',
    'Add Download' => '__(\'admin.actions.create\')',
    'File' => '__(\'admin.common.file\')',
    'Filename' => '__(\'admin.common.filename\')',
    'File Size' => '__(\'admin.common.filesize\')',
    'Download Count' => '__(\'admin.common.download_count\')',
    'Create Download' => '__(\'admin.downloads.create.title\')',
    'Edit Download' => '__(\'admin.downloads.edit.title\')',
    
    // Site Configs
    'Site Configs' => '__(\'admin.site_configs.index.header\')',
    'Add Site Config' => '__(\'admin.actions.create\')',
    'Config Key' => '__(\'admin.common.config_key\')',
    'Config Value' => '__(\'admin.common.config_value\')',
    'Create Site Config' => '__(\'admin.site_configs.create.title\')',
    'Edit Site Config' => '__(\'admin.site_configs.edit.title\')',
    
    // Dashboard
    'Dashboard' => '__(\'admin.dashboard.title\')',
    'Articles' => '__(\'admin.dashboard.articles\')',
    'Products' => '__(\'admin.dashboard.products\')',
    'Cases' => '__(\'admin.dashboard.cases\')',
    'Unread Messages' => '__(\'admin.dashboard.messages\')',
    'Jobs' => '__(\'admin.dashboard.jobs\')',
    'Recent Messages' => '__(\'admin.dashboard.recent_messages\')',
    'Recent Articles' => '__(\'admin.dashboard.recent_articles\')',
    'Published' => '__(\'admin.dashboard.published\')',
    'Draft' => '__(\'admin.dashboard.draft\')',
    
    // Login
    'Admin Login' => '__(\'admin.login.title\')',
    'Username' => '__(\'admin.login.username\')',
    'Password' => '__(\'admin.login.password\')',
    'Login' => '__(\'admin.login.submit\')',
    
    // Sidebar
    'Logout' => '__(\'admin.sidebar.logout\')',
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    foreach ($replacements as $old => $new) {
        $content = str_replace(">$old<", ">$new<", $content);
        $content = str_replace(">$old ", ">$new ", $content);
        $content = str_replace("'$old'", "'$new'", $content);
        $content = str_replace('"' . $old . '"', '"' . $new . '"', $content);
    }
    
    file_put_contents($file, $content);
    echo "Updated: " . basename($file) . "\n";
}

echo "\nAll views updated!\n";
