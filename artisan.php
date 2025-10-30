<?php
// artisan.php — Web-based Artisan menu for shared hosting (use with caution)
/*
  Instructions:
  1. Put this file in your public_html folder.
  2. Set $SECRET to a long random string (not guessable).
  3. Set $PROJECT_ROOT to the absolute path of your Laravel project root (where artisan is).
     e.g. /home/mixtop/project_root
  4. Open in browser: https://yourdomain.com/artisan.php?token=YOUR_SECRET
  5. Run a command and then delete this file immediately.
*/

ini_set('display_errors', 1);
error_reporting(E_ALL);

// ---------- CONFIG ----------
$SECRET = 'paste_a_long_random_token_here_ChangeMe123!'; // <--- ضع توكن قوي هنا
// If you don't know exact absolute path, you can try relative paths like:
// __DIR__ . '/../project_root' if this file is inside public_html and project_root is sibling
$PROJECT_ROOT = __DIR__ . '/../project_root'; // <--- عدّله لمسار مشروعك
// ---------- END CONFIG ----------

// Security: require token
$token = $_GET['token'] ?? '';
if ($token !== $SECRET) {
    http_response_code(403);
    echo "Forbidden. Invalid token.";
    exit;
}

// Helper
function run($cmd)
{
    echo "<pre style='background:#111;color:#dcdcdc;padding:12px;border-radius:6px;'>";
    echo "<b>\$ $cmd</b>\n\n";
    // Use passthru so we see live output
    passthru($cmd . " 2>&1", $exit);
    echo "\n\nExit code: $exit\n";
    echo "</pre>";
}

// Ensure project root exists and artisan is present
$artisan = rtrim($PROJECT_ROOT, "/") . '/artisan';
if (!file_exists($artisan)) {
    echo "<h3 style='color:red'>Error: artisan not found at: " . htmlspecialchars($artisan) . "</h3>";
    echo "<p>تأكد إنك ضبطت <code>\$PROJECT_ROOT</code> في أعلى الملف لمسار صحيح.</p>";
    exit;
}

// Simple UI
$cmd = $_POST['cmd'] ?? null;

echo "<h2>Artisan Web Menu — Use Carefully</h2>";
echo "<p>Project root: <code>" . htmlspecialchars($PROJECT_ROOT) . "</code></p>";
echo "<p style='color:darkred'><b>تحذير:</b> بعد الانتهاء احذف هذا الملف نهائياً.</p>";

if ($cmd) {
    // map friendly names to actual shell commands
    switch ($cmd) {
        case 'storage_link':
            // create storage link (may fail on some hosts if symlink disabled)
            run("php " . escapeshellarg($artisan) . " storage:link");
            break;
        case 'optimize':
            run("php " . escapeshellarg($artisan) . " optimize");
            break;
        case 'config_cache':
            run("php " . escapeshellarg($artisan) . " config:cache");
            break;
        case 'route_cache':
            run("php " . escapeshellarg($artisan) . " route:cache");
            break;
        case 'mig':
            // WARNING: migrations might modify DB — confirm you want this
            run("php " . escapeshellarg($artisan) . " migrate --force");
            break;
        case 'clear_cache':
            run("php " . escapeshellarg($artisan) . " cache:clear");
            run("php " . escapeshellarg($artisan) . " view:clear");
            run("php " . escapeshellarg($artisan) . " route:clear");
            run("php " . escapeshellarg($artisan) . " config:clear");
            break;
        case 'composer_install':
            // only works if composer is installed on server
            run("cd " . escapeshellarg($PROJECT_ROOT) . " && composer install --no-dev --optimize-autoloader");
            break;
        case 'composer_dump':
            run("cd " . escapeshellarg($PROJECT_ROOT) . " && composer dump-autoload -o");
            break;
        case 'seed':
            run("php " . escapeshellarg($artisan) . " db:seed --force");
            break;
        case 'queue_restart':
            run("php " . escapeshellarg($artisan) . " queue:restart");
            break;
        default:
            echo "<p>Unknown command</p>";
    }
}

// Menu form
?>

<form method="post" style="margin-top:20px">
    <label>Choose command:&nbsp;</label>
    <select name="cmd">
        <option value="storage_link">php artisan storage:link</option>
        <option value="optimize">php artisan optimize</option>
        <option value="config_cache">php artisan config:cache</option>
        <option value="route_cache">php artisan route:cache</option>
        <option value="clear_cache">Clear all caches (cache:view:route:config)</option>
        <option value="composer_install">composer install (if composer exists on server)</option>
        <option value="composer_dump">composer dump-autoload -o</option>
        <option value="mig">php artisan migrate --force (BE CAREFUL)</option>
        <option value="seed">php artisan db:seed --force</option>
        <option value="queue_restart">php artisan queue:restart</option>
    </select>
    <button type="submit">Run</button>
</form>

<hr>
<p><b>Usage:</b> open <code>https://mixjo.top/artisan.php?token=YOUR_SECRET</code></p>
<p><b>Important:</b> Delete this file after finishing. Or change $SECRET to an unguessable string and keep the file only when needed.</p>