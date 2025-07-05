<?php
$pagesDir = './pages/';
$all_files = glob($pagesDir . '*.html');
if ($all_files === false) { $all_files = []; }
if (!empty($all_files)) {
    usort($all_files, function($a, $b) { return filemtime($b) - filemtime($a); });
}
$items_per_page = 10;
$total_items = count($all_files);
$total_pages = ceil($total_items / $items_per_page);
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
if ($current_page < 1) { $current_page = 1; }
if ($current_page > $total_pages && $total_pages > 0) { $current_page = $total_pages; }
$offset = ($current_page - 1) * $items_per_page;
$files_for_this_page = array_slice($all_files, $offset, $items_per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Zeitgeist</title>
    <link rel="stylesheet" href="style.css">
    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    <!-- Google tag (gtag.js) - REPLACE WITH YOURS -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-XXXXXXXXXX');
    </script>
</head>
<body>
    <main class="container">
        <h1>The Zeitgeist</h1>
        <div class="list-header">
            <div class="header-title">The Artifact</div>
            <div class="header-commentary">The Provenance</div>
        </div>
        <div class="page-list">
            <?php if (empty($files_for_this_page)): ?>
                <p class="no-pages">No pages have been created yet. Go to the <a href="admin.php">admin panel</a> to create one.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($files_for_this_page as $file): ?>
                        <?php
                            $slug = basename($file, '.html');
                            $title = ucwords(str_replace('-', ' ', $slug));
                            $modTime = filemtime($file);
                            $link = 'view.php?page=' . urlencode($slug);
                            $commentary = '';
                            $commentsPath = './comments/' . $slug . '.json';
                            if (file_exists($commentsPath)) {
                                $jsonContent = file_get_contents($commentsPath);
                                $data = json_decode($jsonContent, true);
                                if (isset($data['commentary'])) { $commentary = trim($data['commentary']); }
                            }
                        ?>
                        <li>
                            <div class="page-info">
                                <a href="<?php echo htmlspecialchars($link); ?>"><?php echo htmlspecialchars($title); ?></a>
                                <span class="date">Posted on: <?php echo date('F j, Y', $modTime); ?></span>
                            </div>
                            <?php if (!empty($commentary)): ?>
                                <div class="page-commentary"><?php echo htmlspecialchars($commentary); ?></div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($current_page > 1): ?><a href="?p=<?php echo $current_page - 1; ?>">Previous</a><?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <?php if ($i == $current_page): ?><span class="current"><?php echo $i; ?></span><?php else: ?><a href="?p=<?php echo $i; ?>"><?php echo $i; ?></a><?php endif; ?>
                <?php endfor; ?>
                <?php if ($current_page < $total_pages): ?><a href="?p=<?php echo $current_page + 1; ?>">Next</a><?php endif; ?>
            </div>
        <?php endif; ?>
    </main>
    <div id="about-modal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-button">×</span>
            <h2>About The Zeitgeist</h2>
            <blockquote>"Social media didn’t invent stupidity—but it industrialised it. It turned identity into a brand, belief into status, and thinking into a threat."</blockquote>
            <p>This site was born from that sentiment—from a deep frustration with the modern digital town square. It is an antidote to the endless cycle of performative outrage, the ephemeral arguments you are dragged back into, and the pressure to have a brand instead of a voice.</p>
            <p>This is not a platform for dialogue; it is a platform for declaration. It's a space to simply <em>say something</em> without the expectation of a fight, a "like," or a reply. It's a place to post a thought and let it stand on its own, immune to the churn of public commentary.</p>
            <p>Here, each entry is a permanent part of a collection.</p>
            <ul>
                <li><strong>The Artifact</strong> is the creation—the digital object.</li>
                <li><strong>The Provenance</strong> is the context—the thought, the story, the reason it exists.</li>
            </ul>
            <p>This space is for the record. The conversation, should you wish to have one, happens elsewhere. You can find me on <a href="https://twitter.com/your_handle" target="_blank" rel="noopener noreferrer">X</a>.</p>
        </div>
    </div>
    <footer class="site-footer">
        <p>© <?php echo date('Y'); ?> [Your Name] · <a href="#" id="about-link">About this site</a>
            <button id="theme-toggle" title="Toggle Theme">
                <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                <svg class="moon-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
            </button>
        </p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
