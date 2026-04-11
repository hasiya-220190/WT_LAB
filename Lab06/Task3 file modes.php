<?php
// Task 3: File Operation Modes – demonstrating all fopen() modes

$results = [];

// ── r  : Read only ──────────────────────────────────────────────────────────
file_put_contents('mode_r.txt', "Original content for r mode.\n");
$h = fopen('mode_r.txt', 'r');
$results['r'] = [
    'desc' => 'Read only. File must exist. Pointer at start.',
    'action' => 'Read file content',
    'output' => fread($h, 100),
    'note' => 'fwrite() would return false here — no writing allowed',
];
fclose($h);

// ── w  : Write only (erases old data) ───────────────────────────────────────
file_put_contents('mode_w.txt', "OLD DATA that will be erased.\n");
$h = fopen('mode_w.txt', 'w');
fwrite($h, "Fresh content written with 'w' mode.\n");
fclose($h);
$results['w'] = [
    'desc' => 'Write only. Creates file if not exists. Erases existing content.',
    'action' => 'Overwrote old content',
    'output' => file_get_contents('mode_w.txt'),
    'note' => 'Old data ("OLD DATA...") is gone forever',
];

// ── a  : Append only ────────────────────────────────────────────────────────
file_put_contents('mode_a.txt', "Line 1 (original)\n");
$h = fopen('mode_a.txt', 'a');
fwrite($h, "Line 2 (appended with 'a' mode)\n");
fclose($h);
$results['a'] = [
    'desc' => 'Append only. Pointer always at end. Creates file if not exists.',
    'action' => 'Appended a new line',
    'output' => file_get_contents('mode_a.txt'),
    'note' => 'Original content is preserved; new data added at end',
];

// ── x  : Create new file (fails if exists) ──────────────────────────────────
@unlink('mode_x.txt'); // make sure it doesn't exist
$h = @fopen('mode_x.txt', 'x');
if ($h) {
    fwrite($h, "Created fresh with 'x' mode.\n");
    fclose($h);
    $output_x = file_get_contents('mode_x.txt');
    $note_x = "File did not exist → created successfully";
} else {
    $output_x = "(file already existed — fopen returned false)";
    $note_x = "If you run this page twice, x mode fails on second run";
}
$results['x'] = [
    'desc' => "Create new file for writing. FAILS if file already exists.",
    'action' => 'Tried to create mode_x.txt',
    'output' => $output_x,
    'note' => $note_x,
];

// ── r+ : Read & Write ───────────────────────────────────────────────────────
file_put_contents('mode_rplus.txt', "ABCDEFGH\n");
$h = fopen('mode_rplus.txt', 'r+');
fseek($h, 0);          // pointer at start
$read = fread($h, 8);  // read first 8 chars
fseek($h, 0);          // go back to start
fwrite($h, "12345678"); // overwrite without erasing rest
fclose($h);
$results['r+'] = [
    'desc' => 'Read & Write. File must exist. Does NOT truncate.',
    'action' => 'Read "ABCDEFGH", then overwrote with "12345678"',
    'output' => "Read: '$read'\nAfter write: " . file_get_contents('mode_rplus.txt'),
    'note' => 'Pointer starts at beginning; content not erased',
];

// ── w+ : Read & Write (erases old data) ─────────────────────────────────────
file_put_contents('mode_wplus.txt', "OLD TEXT HERE\n");
$h = fopen('mode_wplus.txt', 'w+');
fwrite($h, "New content via w+ mode.\n");
rewind($h);
$read_wplus = fread($h, 100);
fclose($h);
$results['w+'] = [
    'desc' => 'Read & Write. Truncates (erases) file on open. Creates if needed.',
    'action' => 'Wrote new content, then rewound and read it back',
    'output' => "Read back: $read_wplus",
    'note' => 'Old text "OLD TEXT HERE" was erased on fopen()',
];

// ── a+ : Read & Append ──────────────────────────────────────────────────────
file_put_contents('mode_aplus.txt', "Existing line\n");
$h = fopen('mode_aplus.txt', 'a+');
fwrite($h, "Appended line via a+\n");
rewind($h);
$read_aplus = fread($h, 200);
fclose($h);
$results['a+'] = [
    'desc' => 'Read & Append. Pointer at end for writes; can rewind to read.',
    'action' => 'Appended a line, rewound, read entire file',
    'output' => $read_aplus,
    'note' => 'Writes always go to the end regardless of fseek()',
];

// ── x+ : Create new for Read & Write ────────────────────────────────────────
@unlink('mode_xplus.txt');
$h = @fopen('mode_xplus.txt', 'x+');
if ($h) {
    fwrite($h, "Read/Write on fresh file via x+\n");
    rewind($h);
    $read_xplus = fread($h, 100);
    fclose($h);
    $output_xplus = "Read back: $read_xplus";
    $note_xplus = "File created fresh; both read and write work";
} else {
    $output_xplus = "fopen returned false — file already existed";
    $note_xplus = "x+ fails silently if file exists";
}
$results['x+'] = [
    'desc' => 'Create new file for Read & Write. FAILS if already exists.',
    'action' => 'Created mode_xplus.txt and wrote + read',
    'output' => $output_xplus,
    'note' => $note_xplus,
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Task 3 – File Open Modes</title>
    <style>
        :root {
            --bg: #0d1117;
            --card: #161b22;
            --border: #30363d;
            --accent: #58a6ff;
            --green: #3fb950;
            --orange: #e3b341;
            --red: #f85149;
            --text: #c9d1d9;
            --muted: #8b949e;
            --code-bg: #0d1117;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            padding: 2rem;
            line-height: 1.7;
        }

        h1 {
            color: var(--accent);
            font-size: 1.8rem;
            margin-bottom: 0.25rem;
        }

        .subtitle {
            color: var(--muted);
            margin-bottom: 2rem;
        }

        .mode-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 1.2rem;
        }

        .mode-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.4rem;
        }

        .mode-header {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            margin-bottom: 0.8rem;
        }

        .mode-badge {
            font-family: monospace;
            font-size: 1.1rem;
            font-weight: bold;
            background: #1c2d3f;
            color: var(--accent);
            border: 1px solid var(--accent);
            padding: 0.15rem 0.7rem;
            border-radius: 6px;
            letter-spacing: 0.05em;
        }

        .mode-desc {
            color: var(--muted);
            font-size: 0.88rem;
        }

        .mode-action {
            color: var(--orange);
            font-size: 0.85rem;
            margin: 0.5rem 0;
        }

        .mode-output {
            background: var(--code-bg);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.7rem 1rem;
            font-family: monospace;
            font-size: 0.82rem;
            color: var(--green);
            white-space: pre-wrap;
            word-break: break-all;
            margin-bottom: 0.6rem;
        }

        .mode-note {
            font-size: 0.8rem;
            color: var(--muted);
            background: #1a1f26;
            border-left: 3px solid var(--orange);
            padding: 0.4rem 0.7rem;
            border-radius: 0 4px 4px 0;
        }

        .legend {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1.2rem 1.5rem;
            margin-bottom: 2rem;
        }

        .legend h2 {
            color: var(--orange);
            margin-bottom: 0.8rem;
            font-size: 1rem;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 0.88rem;
        }

        th {
            background: #1c2430;
            color: var(--accent);
            padding: 0.4rem 0.8rem;
            text-align: left;
        }

        td {
            padding: 0.4rem 0.8rem;
            border-bottom: 1px solid var(--border);
        }

        td:first-child {
            font-family: monospace;
            color: var(--accent);
            font-weight: bold;
        }

        .yes {
            color: var(--green);
        }

        .no {
            color: var(--red);
        }
    </style>
</head>

<body>

    <h1>📄 Task 3 — File Open Modes</h1>
    <p class="subtitle">All 8 fopen() modes demonstrated with live code execution</p>

    <!-- Quick Reference Table -->
    <div class="legend">
        <h2>⚡ Quick Reference Table</h2>
        <table>
            <tr>
                <th>Mode</th>
                <th>Read</th>
                <th>Write</th>
                <th>Create</th>
                <th>Truncate</th>
                <th>Pointer</th>
                <th>Fail if exists</th>
            </tr>
            <tr>
                <td>r</td>
                <td class="yes">✓</td>
                <td class="no">✗</td>
                <td class="no">✗</td>
                <td class="no">✗</td>
                <td>Start</td>
                <td class="no">—</td>
            </tr>
            <tr>
                <td>w</td>
                <td class="no">✗</td>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
                <td>Start</td>
                <td class="no">—</td>
            </tr>
            <tr>
                <td>a</td>
                <td class="no">✗</td>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
                <td class="no">✗</td>
                <td>End</td>
                <td class="no">—</td>
            </tr>
            <tr>
                <td>x</td>
                <td class="no">✗</td>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
                <td class="no">✗</td>
                <td>Start</td>
                <td class="yes">✓</td>
            </tr>
            <tr>
                <td>r+</td>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
                <td class="no">✗</td>
                <td class="no">✗</td>
                <td>Start</td>
                <td class="no">—</td>
            </tr>
            <tr>
                <td>w+</td>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
                <td>Start</td>
                <td class="no">—</td>
            </tr>
            <tr>
                <td>a+</td>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
                <td class="no">✗</td>
                <td>End</td>
                <td class="no">—</td>
            </tr>
            <tr>
                <td>x+</td>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
                <td class="yes">✓</td>
                <td class="no">✗</td>
                <td>Start</td>
                <td class="yes">✓</td>
            </tr>
        </table>
    </div>

    <!-- Mode Cards -->
    <div class="mode-grid">
        <?php foreach ($results as $mode => $data): ?>
            <div class="mode-card">
                <div class="mode-header">
                    <span class="mode-badge">"<?= $mode ?>"</span>
                </div>
                <div class="mode-desc"><?= htmlspecialchars($data['desc']) ?></div>
                <div class="mode-action">▶ <?= htmlspecialchars($data['action']) ?></div>
                <div class="mode-output"><?= htmlspecialchars($data['output']) ?></div>
                <div class="mode-note">💡 <?= htmlspecialchars($data['note']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>