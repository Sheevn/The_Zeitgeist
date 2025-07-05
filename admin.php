<?php
// It is HIGHLY recommended to rename this file for security.
define('ADMIN_PASSWORD', 'change-this-to-a-very-strong-password!');
session_start();
$errorMessage = '';
$successMessage = '';
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: admin.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === ADMIN_PASSWORD) {
        $_SESSION['loggedin'] = true;
        header('Location: admin.php');
        exit();
    } else {
        $errorMessage = 'Invalid password.';
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_POST['title']) && isset($_POST['html_content'])) {
    $title = trim($_POST['title']);
    $commentary = trim($_POST['commentary'] ?? '');
    $htmlContent = $_POST['html_content'];
    if (empty($title) || empty($htmlContent)) {
        $errorMessage = 'Title and HTML content cannot be empty.';
    } else {
        $slug = strtolower($title);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
        $slug = trim($slug, '-');
        if (empty($slug)) {
            $errorMessage = 'Invalid title. Please use a title that contains letters or numbers.';
        } else {
            $pagePath = './pages/' . $slug . '.html';
            $commentsPath = './comments/' . $slug . '.json';
            if (file_exists($pagePath)) {
                $errorMessage = 'Error: A page with this title (slug: ' . htmlspecialchars($slug) . ') already exists.';
            } else {
                // --- Google Analytics Injection ---
                $ga_script = <<<HTML
                <!-- Google tag (gtag.js) - REPLACE WITH YOURS -->
                <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
                <script>
                  window.dataLayer = window.dataLayer || [];
                  function gtag(){dataLayer.push(arguments);}
                  gtag('js', new Date());
                  gtag('config', 'G-XXXXXXXXXX');
                </script>
                HTML;
                $finalHtmlContent = str_ireplace('</head>', $ga_script . "\n</head>", $htmlContent);
                file_put_contents($pagePath, $finalHtmlContent);
                $commentaryData = ['commentary' => $commentary];
                file_put_contents($commentsPath, json_encode($commentaryData, JSON_PRETTY_PRINT));
                $viewLink = 'view.php?page=' . urlencode($slug);
                $successMessage = 'Success! Page created with Analytics code injected. <a href="' . htmlspecialchars($viewLink) . '">View it here</a>.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
</head>
<body>
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
    <header class="fixed-header">
        <nav><a href="index.php">Home</a></nav>
        <div class="logout-link"><a href="admin.php?logout=true">Log Out</a></div>
    </header>
    <?php endif; ?>
    <main class="container">
        <h1>Admin Panel</h1>
        <?php if (!empty($errorMessage)) echo '<div class="message error">' . $errorMessage . '</div>'; ?>
        <?php if (!empty($successMessage)) echo '<div class="message success">' . $successMessage . '</div>'; ?>
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <h2>Add New Page</h2>
            <form action="admin.php" method="POST">
                <div><label for="title">Page Title:</label><input type="text" id="title" name="title" required></div>
                <div><label for="commentary">Your Commentary (Optional):</label><textarea id="commentary" name="commentary"></textarea></div>
                <div><label for="html_content">HTML Content:</label><textarea id="html_content" name="html_content" required></textarea></div>
                <button type="submit">Create Page</button>
            </form>
        <?php else: ?>
            <h2>Login</h2>
            <form action="admin.php" method="POST">
                <div><label for="password">Password:</label><input type="password" id="password" name="password" required></div>
                <button type="submit">Login</button>
            </form>
        <?php endif; ?>
    </main>
    <footer class="site-footer">
        <button id="theme-toggle" title="Toggle Theme">
            <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
            <svg class="moon-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
        </button>
    </footer>
    <script src="script.js"></script>
</body>
</html>
