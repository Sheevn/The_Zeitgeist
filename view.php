<?php
if (!isset($_GET['page']) || empty(trim($_GET['page']))) { http_response_code(404); die("<h1>404 - Page Not Found</h1>"); }
$pageName = $_GET['page'];
if (!preg_match('/^[a-zA-Z0-9-]+$/', $pageName)) { http_response_code(400); die("<h1>400 - Invalid Page Name</h1>"); }
$htmlFilePath = './pages/' . $pageName . '.html';
$commentsFilePath = './comments/' . $pageName . '.json';
if (!file_exists($htmlFilePath)) { http_response_code(404); die("<h1>404 - Page Not Found</h1>"); }
$pageTitle = ucwords(str_replace('-', ' ', $pageName));
$commentary = '';
if (file_exists($commentsFilePath)) {
    $jsonContent = file_get_contents($commentsFilePath);
    if ($jsonContent) {
        $data = json_decode($jsonContent, true);
        if (is_array($data) && isset($data['commentary'])) { $commentary = $data['commentary']; }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - The Zeitgeist</title>
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
    <header class="fixed-header">
        <nav><a href="index.php">Home</a></nav>
    </header>
    <main class="container">
        <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
        <h2>The Provenance</h2>
        <div id="commentary-section">
            <?php if (!empty(trim($commentary))): ?><p><?php echo htmlspecialchars($commentary); ?></p><?php else: ?><p>No commentary was provided.</p><?php endif; ?>
        </div>
        <div class="content-header">
            <h2>The Artifact</h2>
            <a href="<?php echo htmlspecialchars($htmlFilePath); ?>" target="_blank" class="button-link">Open Full Page</a>
        </div>
        <iframe src="<?php echo htmlspecialchars($htmlFilePath); ?>" title="The Artifact"></iframe>
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
