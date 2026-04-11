<?php
// Task 2: Demonstrate All Major PHP File Functions

// ─── Setup: create sample files to work with ─────────────────────────────────
$sampleFile = 'sample.txt';
$sampleDir = 'demo_folder';
$copyFile = 'sample_copy.txt';
$renameFile = 'sample_renamed.txt';

file_put_contents($sampleFile, "Hello, PHP File Functions!\nLine 2\nLine 3\n");
if (!is_dir($sampleDir))
    mkdir($sampleDir, 0755);

// ─── Collect all demo data ───────────────────────────────────────────────────

// 1. FILE READ / WRITE
ob_start();

// fopen / fwrite / fclose
$handle = fopen('fopen_demo.txt', 'w');
fwrite($handle, "Written with fopen + fwrite\n");
fclose($handle);

// fopen / fread / fclose
$handle = fopen('fopen_demo.txt', 'r');
$freadResult = fread($handle, filesize('fopen_demo.txt'));
fclose($handle);

// file_get_contents
$fgcResult = file_get_contents($sampleFile);

// file_put_contents
file_put_contents('fpc_demo.txt', "Written with file_put_contents\n");
$fpcRead = file_get_contents('fpc_demo.txt');

// file() — reads into array
$fileArray = file($sampleFile);

$rw = ob_get_clean();

// 2. FILE INFORMATION
$fileInfoData = [
    'file_exists' => file_exists($sampleFile) ? 'true' : 'false',
    'filesize' => filesize($sampleFile) . ' bytes',
    'filetype' => filetype($sampleFile),
    'fileatime' => date('Y-m-d H:i:s', fileatime($sampleFile)),
    'filemtime' => date('Y-m-d H:i:s', filemtime($sampleFile)),
    'filectime' => date('Y-m-d H:i:s', filectime($sampleFile)),
    'fileperms' => decoct(fileperms($sampleFile) & 0777),
    'fileowner' => fileowner($sampleFile),
    'filegroup' => filegroup($sampleFile),
    'fileinode' => fileinode($sampleFile),
];

// 3. FILE & FOLDER MANAGEMENT
copy($sampleFile, $copyFile);
$copyExists = file_exists($copyFile) ? 'true' : 'false';

rename($copyFile, $renameFile);
$renameExists = file_exists($renameFile) ? 'true' : 'false';

unlink($renameFile);
$afterUnlink = file_exists($renameFile) ? 'still exists' : 'deleted';

mkdir($sampleDir . '/subdir', 0755);
$mkdirDone = is_dir($sampleDir . '/subdir') ? 'created' : 'failed';

rmdir($sampleDir . '/subdir');
$rmdirDone = is_dir($sampleDir . '/subdir') ? 'still exists' : 'removed';

$isFile = is_file($sampleFile) ? 'true' : 'false';
$isDir = is_dir($sampleDir) ? 'true' : 'false';

// 4. DIRECTORY HANDLING
$scandirResult = scandir('.');

$opendirResult = [];
$dh = opendir('.');
while (($entry = readdir($dh)) !== false) {
    $opendirResult[] = $entry;
}
closedir($dh);

$cwd = getcwd();
chdir($sampleDir);
$newCwd = getcwd();
chdir('..');

// 5. FILE LOCKING
$lockHandle = fopen('lock_demo.txt', 'w');
$lockResult = flock($lockHandle, LOCK_EX) ? 'Lock acquired (LOCK_EX)' : 'Lock failed';
fwrite($lockHandle, "Data written under exclusive lock\n");
flock($lockHandle, LOCK_UN);
fclose($lockHandle);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Task 2 – PHP File Functions</title>
    <style>
        :root {
            --bg: #0a0e1a;
            --surface: #111827;
            --card: #1a2235;
            --border: #2d3748;
            --accent: #f59e0b;
            --green: #10b981;
            --blue: #60a5fa;
            --text: #e2e8f0;
            --muted: #6b7280;
            --code: #fbbf24;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Consolas', 'Courier New', monospace;
            background: var(--bg);
            color: var(--text);
            padding: 2rem;
            line-height: 1.7;
        }

        h1 {
            color: var(--accent);
            font-size: 1.8rem;
            margin-bottom: 0.3rem;
        }

        .subtitle {
            color: var(--muted);
            margin-bottom: 2rem;
            font-family: sans-serif;
        }

        .section {
            background: var(--card);
            border: 1px solid var(--border);
            border-left: 4px solid var(--accent);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section h2 {
            color: var(--accent);
            font-size: 1.1rem;
            margin-bottom: 1rem;
            font-family: sans-serif;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .fn-block {
            margin-bottom: 1rem;
        }

        .fn-name {
            color: var(--blue);
            font-weight: bold;
        }

        .fn-result {
            color: var(--green);
        }

        .fn-desc {
            color: var(--muted);
            font-size: 0.85rem;
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        th {
            background: var(--border);
            color: var(--accent);
            padding: 0.5rem 0.8rem;
            text-align: left;
        }

        td {
            padding: 0.5rem 0.8rem;
            border-bottom: 1px solid var(--border);
        }

        td:first-child {
            color: var(--blue);
        }

        td:last-child {
            color: var(--green);
        }

        .array-list {
            color: var(--green);
        }

        .array-list span {
            display: inline-block;
            background: #162032;
            border: 1px solid var(--border);
            padding: 0.15rem 0.6rem;
            border-radius: 4px;
            margin: 2px;
            font-size: 0.82rem;
        }

        .badge {
            display: inline-block;
            padding: 0.15rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.78rem;
            font-family: sans-serif;
        }

        .badge-green {
            background: #064e3b;
            color: #6ee7b7;
        }

        .badge-yellow {
            background: #451a03;
            color: #fcd34d;
        }
    </style>
</head>

<body>

    <h1>📂 Task 2 — PHP File Functions</h1>
    <p class="subtitle">Demonstrating all major PHP file functions with live output</p>

    <!-- ── 1. FILE READ / WRITE ── -->
    <div class="section">
        <h2>📝 1. File Read / Write Functions</h2>

        <div class="fn-block">
            <div class="fn-name">fopen() + fwrite() + fclose()</div>
            <div class="fn-desc">Opens a file handle, writes text, then closes it</div>
            <div class="fn-result">✔ Written: "Written with fopen + fwrite"</div>
        </div>

        <div class="fn-block">
            <div class="fn-name">fopen() + fread() + fclose()</div>
            <div class="fn-desc">Opens a file in read mode, reads its content</div>
            <div class="fn-result">✔ Read: <?= htmlspecialchars(trim($freadResult)) ?></div>
        </div>

        <div class="fn-block">
            <div class="fn-name">file_get_contents()</div>
            <div class="fn-desc">Reads entire file into a string in one call</div>
            <div class="fn-result">✔ Content:<br><?= nl2br(htmlspecialchars($fgcResult)) ?></div>
        </div>

        <div class="fn-block">
            <div class="fn-name">file_put_contents()</div>
            <div class="fn-desc">Writes a string to a file in one call (creates if needed)</div>
            <div class="fn-result">✔ Written & read back: <?= htmlspecialchars(trim($fpcRead)) ?></div>
        </div>

        <div class="fn-block">
            <div class="fn-name">file()</div>
            <div class="fn-desc">Reads file into an indexed array — one line per element</div>
            <div class="fn-result">
                Array with <?= count($fileArray) ?> lines:<br>
                <?php foreach ($fileArray as $i => $line): ?>
                    [<?= $i ?>] → <?= htmlspecialchars(rtrim($line)) ?><br>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- ── 2. FILE INFORMATION ── -->
    <div class="section">
        <h2>🔍 2. File Information Functions</h2>
        <table>
            <tr>
                <th>Function</th>
                <th>Result for "<?= $sampleFile ?>"</th>
            </tr>
            <?php foreach ($fileInfoData as $fn => $val): ?>
                <tr>
                    <td><?= $fn ?>()</td>
                    <td><?= htmlspecialchars($val) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- ── 3. FILE & FOLDER MANAGEMENT ── -->
    <div class="section">
        <h2>🗂 3. File & Folder Management</h2>

        <div class="fn-block">
            <div class="fn-name">copy('<?= $sampleFile ?>', '<?= $copyFile ?>')</div>
            <div class="fn-result">Copy exists: <span class="badge badge-green"><?= $copyExists ?></span></div>
        </div>

        <div class="fn-block">
            <div class="fn-name">rename('<?= $copyFile ?>', '<?= $renameFile ?>')</div>
            <div class="fn-result">Renamed file exists: <span class="badge badge-green"><?= $renameExists ?></span>
            </div>
        </div>

        <div class="fn-block">
            <div class="fn-name">unlink('<?= $renameFile ?>')</div>
            <div class="fn-result">After delete: <span class="badge badge-yellow"><?= $afterUnlink ?></span></div>
        </div>

        <div class="fn-block">
            <div class="fn-name">mkdir('<?= $sampleDir ?>/subdir')</div>
            <div class="fn-result">Directory: <span class="badge badge-green"><?= $mkdirDone ?></span></div>
        </div>

        <div class="fn-block">
            <div class="fn-name">rmdir('<?= $sampleDir ?>/subdir')</div>
            <div class="fn-result">After remove: <span class="badge badge-yellow"><?= $rmdirDone ?></span></div>
        </div>

        <div class="fn-block">
            <div class="fn-name">is_file() / is_dir()</div>
            <div class="fn-result">
                is_file('<?= $sampleFile ?>') → <span class="badge badge-green"><?= $isFile ?></span> &nbsp;
                is_dir('<?= $sampleDir ?>') → <span class="badge badge-green"><?= $isDir ?></span>
            </div>
        </div>
    </div>

    <!-- ── 4. DIRECTORY HANDLING ── -->
    <div class="section">
        <h2>📁 4. Directory Handling</h2>

        <div class="fn-block">
            <div class="fn-name">scandir('.')</div>
            <div class="fn-desc">Returns array of all files in current directory</div>
            <div class="fn-result array-list">
                <?php foreach ($scandirResult as $f): ?>
                    <span><?= htmlspecialchars($f) ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="fn-block">
            <div class="fn-name">opendir() + readdir() + closedir()</div>
            <div class="fn-desc">Manual directory iteration</div>
            <div class="fn-result array-list">
                <?php foreach ($opendirResult as $f): ?>
                    <span><?= htmlspecialchars($f) ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="fn-block">
            <div class="fn-name">getcwd()</div>
            <div class="fn-result">Current directory: <?= htmlspecialchars($cwd) ?></div>
        </div>

        <div class="fn-block">
            <div class="fn-name">chdir('<?= $sampleDir ?>')</div>
            <div class="fn-result">After chdir: <?= htmlspecialchars($newCwd) ?></div>
        </div>
    </div>

    <!-- ── 5. FILE LOCKING ── -->
    <div class="section">
        <h2>🔒 5. File Locking — flock()</h2>
        <div class="fn-block">
            <div class="fn-name">flock($handle, LOCK_EX)</div>
            <div class="fn-desc">Acquires an exclusive lock so no other process can write simultaneously</div>
            <div class="fn-result">✔ <?= $lockResult ?> → wrote data → LOCK_UN released</div>
        </div>
        <div class="fn-desc" style="margin-top:0.8rem; font-family:sans-serif; font-size:0.85rem;">
            💡 Real-world use: log files, counters, any file written by multiple processes.
        </div>
    </div>

</body>

</html>