<?php
// ═══════════════════════════════════════════════════════
//  Mini File Manager — combining all three lab tasks
//  Features: Upload, List, File Info, Download, Delete
// ═══════════════════════════════════════════════════════

$uploadDir = 'uploads/';
$message = '';
$msgType = '';

// Create uploads/ folder if it doesn't exist (mkdir)
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// ─── ACTION: Download ────────────────────────────────────────────────────────
if (isset($_GET['action']) && $_GET['action'] === 'download' && isset($_GET['file'])) {
    $file = $uploadDir . basename($_GET['file']); // basename = security
    if (file_exists($file) && is_file($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        header('Pragma: public');
        readfile($file);
        exit;
    }
}

// ─── ACTION: Delete ──────────────────────────────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['file'])) {
    $file = $uploadDir . basename($_POST['file']);
    if (file_exists($file) && is_file($file)) {
        unlink($file); // unlink() — deletes file
        $message = 'File "' . htmlspecialchars(basename($file)) . '" deleted successfully.';
        $msgType = 'success';
    } else {
        $message = 'File not found.';
        $msgType = 'error';
    }
}

// ─── ACTION: Upload ──────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadFile'])) {
    $f = $_FILES['uploadFile'];
    if ($f['error'] === UPLOAD_ERR_OK) {
        $dest = $uploadDir . basename($f['name']);
        if (move_uploaded_file($f['tmp_name'], $dest)) {
            $message = 'File "' . htmlspecialchars(basename($f['name'])) . '" uploaded successfully!';
            $msgType = 'success';
        } else {
            $message = 'Upload failed — could not move file.';
            $msgType = 'error';
        }
    } else {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds server size limit.',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds form size limit.',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was selected.',
            UPLOAD_ERR_NO_TMP_DIR => 'No temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write to disk.',
        ];
        $message = $errors[$f['error']] ?? 'Unknown upload error.';
        $msgType = 'error';
    }
}

// ─── LIST FILES using scandir() ──────────────────────────────────────────────
$files = [];
$rawList = scandir($uploadDir); // scandir returns array of entries
foreach ($rawList as $entry) {
    $path = $uploadDir . $entry;
    if (is_file($path)) { // is_file() to skip . and ..
        $files[] = [
            'name' => $entry,
            'size' => filesize($path),           // filesize()
            'modified' => filemtime($path),           // filemtime()
            'type' => mime_content_type($path),   // MIME type
            'ext' => strtolower(pathinfo($entry, PATHINFO_EXTENSION)),
        ];
    }
}

// Sort by modified time descending
usort($files, fn($a, $b) => $b['modified'] - $a['modified']);

// ─── Helper: human-readable file size ────────────────────────────────────────
function formatSize(int $bytes): string
{
    if ($bytes < 1024)
        return $bytes . ' B';
    if ($bytes < 1048576)
        return round($bytes / 1024, 1) . ' KB';
    if ($bytes < 1073741824)
        return round($bytes / 1048576, 1) . ' MB';
    return round($bytes / 1073741824, 1) . ' GB';
}

// ─── Helper: icon by extension ───────────────────────────────────────────────
function fileIcon(string $ext): string
{
    $map = [
        'pdf' => '📄',
        'doc' => '📝',
        'docx' => '📝',
        'xls' => '📊',
        'xlsx' => '📊',
        'ppt' => '📋',
        'pptx' => '📋',
        'jpg' => '🖼',
        'jpeg' => '🖼',
        'png' => '🖼',
        'gif' => '🖼',
        'svg' => '🖼',
        'mp4' => '🎬',
        'mov' => '🎬',
        'avi' => '🎬',
        'mp3' => '🎵',
        'wav' => '🎵',
        'zip' => '🗜',
        'rar' => '🗜',
        'tar' => '🗜',
        'gz' => '🗜',
        'php' => '🐘',
        'js' => '📜',
        'css' => '🎨',
        'html' => '🌐',
        'txt' => '📃',
        'csv' => '📊',
        'json' => '📦',
    ];
    return $map[$ext] ?? '📎';
}

$totalSize = array_sum(array_column($files, 'size'));
$totalCount = count($files);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini File Manager</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Inter:wght@400;500;600;700&display=swap');

        :root {
            --bg: #06080f;
            --surface: #0d1117;
            --card: #111827;
            --border: #1f2937;
            --border2: #374151;
            --accent: #6366f1;
            --accent2: #818cf8;
            --green: #10b981;
            --red: #ef4444;
            --yellow: #f59e0b;
            --blue: #3b82f6;
            --text: #f9fafb;
            --muted: #6b7280;
            --muted2: #9ca3af;
            --mono: 'JetBrains Mono', monospace;
            --sans: 'Inter', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--sans);
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── NAV ── */
        nav {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            height: 56px;
        }

        .logo {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--accent2);
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo span {
            color: var(--muted2);
            font-weight: 400;
            font-size: 0.85rem;
        }

        .nav-stats {
            margin-left: auto;
            display: flex;
            gap: 1.5rem;
            font-size: 0.82rem;
            color: var(--muted2);
        }

        .nav-stat strong {
            color: var(--accent2);
        }

        /* ── LAYOUT ── */
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* ── UPLOAD SECTION ── */
        .upload-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.8rem;
            margin-bottom: 2rem;
        }

        .upload-card h2 {
            font-size: 1rem;
            color: var(--muted2);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 1.2rem;
        }

        .drop-zone {
            border: 2px dashed var(--border2);
            border-radius: 12px;
            padding: 2.5rem 2rem;
            text-align: center;
            transition: border-color .2s, background .2s;
            cursor: pointer;
            position: relative;
        }

        .drop-zone:hover {
            border-color: var(--accent);
            background: rgba(99, 102, 241, .04);
        }

        .drop-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .drop-icon {
            font-size: 2.5rem;
            margin-bottom: 0.6rem;
        }

        .drop-label {
            color: var(--accent2);
            font-weight: 600;
            font-size: 1rem;
        }

        .drop-sub {
            color: var(--muted);
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }

        #chosen-name {
            margin-top: 0.7rem;
            font-family: var(--mono);
            font-size: 0.82rem;
            color: var(--yellow);
        }

        .upload-row {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            align-items: center;
        }

        .btn-upload {
            background: linear-gradient(135deg, var(--accent), #4f46e5);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity .2s, transform .1s;
            font-family: var(--sans);
        }

        .btn-upload:hover {
            opacity: .88;
            transform: translateY(-1px);
        }

        .btn-upload:active {
            transform: translateY(0);
        }

        /* ── ALERT ── */
        .alert {
            padding: 0.9rem 1.2rem;
            border-radius: 10px;
            font-size: 0.92rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .alert-success {
            background: #052e16;
            border: 1px solid #166534;
            color: #86efac;
        }

        .alert-error {
            background: #450a0a;
            border: 1px solid #991b1b;
            color: #fca5a5;
        }

        /* ── FILE TABLE ── */
        .files-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
        }

        .files-header {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }

        .files-header h2 {
            font-size: 1rem;
            color: var(--muted2);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .count-badge {
            background: var(--accent);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.15rem 0.55rem;
            border-radius: 9999px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #0d1117;
        }

        th {
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--muted);
            font-weight: 600;
        }

        tbody tr {
            border-top: 1px solid var(--border);
            transition: background .15s;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, .025);
        }

        td {
            padding: 0.9rem 1rem;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .file-name-cell {
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }

        .file-icon {
            font-size: 1.3rem;
            line-height: 1;
        }

        .file-name {
            font-family: var(--mono);
            font-size: 0.88rem;
            color: var(--text);
            word-break: break-all;
        }

        .file-size {
            color: var(--muted2);
            font-family: var(--mono);
            font-size: 0.82rem;
        }

        .file-date {
            color: var(--muted);
            font-family: var(--mono);
            font-size: 0.8rem;
        }

        .file-mime {
            color: var(--muted);
            font-size: 0.78rem;
            max-width: 160px;
            word-break: break-all;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-dl,
        .btn-del {
            border: none;
            border-radius: 7px;
            padding: 0.4rem 0.9rem;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-family: var(--sans);
            transition: opacity .15s;
        }

        .btn-dl {
            background: #064e3b;
            color: #6ee7b7;
        }

        .btn-del {
            background: #450a0a;
            color: #fca5a5;
        }

        .btn-dl:hover,
        .btn-del:hover {
            opacity: .8;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--muted);
        }

        .empty-state .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 0.95rem;
        }

        /* ── FOOTER ── */
        footer {
            text-align: center;
            padding: 2rem;
            color: var(--muted);
            font-size: 0.8rem;
            border-top: 1px solid var(--border);
            margin-top: 3rem;
        }

        footer code {
            font-family: var(--mono);
            background: var(--border);
            padding: 0.1rem 0.4rem;
            border-radius: 4px;
            font-size: 0.78rem;
            color: var(--accent2);
        }
    </style>
</head>

<body>

    <!-- NAV -->
    <nav>
        <div class="logo">
            📁 FileManager
            <span>/ PHP Lab Project</span>
        </div>
        <div class="nav-stats">
            <div><strong><?= $totalCount ?></strong> files</div>
            <div><strong><?= formatSize($totalSize) ?></strong> total</div>
            <div>📂 <code><?= htmlspecialchars($uploadDir) ?></code></div>
        </div>
    </nav>

    <div class="container">

        <!-- ALERT -->
        <?php if ($message): ?>
            <div class="alert alert-<?= $msgType ?>">
                <?= $msgType === 'success' ? '✅' : '❌' ?>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- UPLOAD SECTION -->
        <div class="upload-card">
            <h2>⬆ Upload File</h2>
            <!-- enctype="multipart/form-data" is REQUIRED for file uploads -->
            <form method="POST" enctype="multipart/form-data">
                <div class="drop-zone">
                    <input type="file" name="uploadFile" id="fileInput"
                        onchange="document.getElementById('chosen-name').textContent = this.files[0]?.name ?? ''">
                    <div class="drop-icon">☁️</div>
                    <div class="drop-label">Click or drag a file here</div>
                    <div class="drop-sub">Any file type — PDF, image, text, video, etc.</div>
                    <div id="chosen-name"></div>
                </div>
                <div class="upload-row">
                    <button type="submit" class="btn-upload">⬆ Upload Now</button>
                </div>
            </form>
        </div>

        <!-- FILE LIST -->
        <div class="files-card">
            <div class="files-header">
                <h2>📋 Uploaded Files</h2>
                <span class="count-badge"><?= $totalCount ?></span>
            </div>

            <?php if (empty($files)): ?>
                <div class="empty-state">
                    <div class="empty-icon">🗂</div>
                    <p>No files uploaded yet. Upload your first file above!</p>
                </div>

            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Size</th>
                            <th>Last Modified</th>
                            <th>MIME Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($files as $f): ?>
                            <tr>
                                <!-- filesize() | filemtime() | mime_content_type() | scandir() used here -->
                                <td>
                                    <div class="file-name-cell">
                                        <span class="file-icon"><?= fileIcon($f['ext']) ?></span>
                                        <span class="file-name"><?= htmlspecialchars($f['name']) ?></span>
                                    </div>
                                </td>
                                <td class="file-size"><?= formatSize($f['size']) ?></td>
                                <td class="file-date"><?= date('d M Y, H:i', $f['modified']) ?></td>
                                <td class="file-mime"><?= htmlspecialchars($f['type']) ?></td>
                                <td>
                                    <div class="actions">
                                        <!-- Download: PHP header() redirect -->
                                        <a class="btn-dl" href="?action=download&file=<?= urlencode($f['name']) ?>">
                                            ⬇ Download
                                        </a>
                                        <!-- Delete: POST form → unlink() -->
                                        <form method="POST" style="display:inline"
                                            onsubmit="return confirm('Delete \'<?= htmlspecialchars($f['name']) ?>\'?')">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="file" value="<?= htmlspecialchars($f['name']) ?>">
                                            <button class="btn-del" type="submit">🗑 Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

    </div>

    <footer>
        Built with PHP &bull;
        Uses: <code>$_FILES</code> <code>move_uploaded_file()</code>
        <code>scandir()</code> <code>filesize()</code>
        <code>filemtime()</code> <code>unlink()</code>
        <code>header()</code> <code>readfile()</code>
        <code>is_file()</code> <code>mkdir()</code>
    </footer>

</body>

</html>