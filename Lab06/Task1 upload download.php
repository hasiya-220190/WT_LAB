<?php
// Task 1: File Upload and Download System

$uploadDir = 'uploads/';
$message = '';
$messageType = '';
$uploadedFile = '';

// Create uploads directory if it doesn't exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Handle Download Request
if (isset($_GET['download'])) {
    $fileName = basename($_GET['download']); // Security: basename prevents directory traversal
    $filePath = $uploadDir . $fileName;

    if (file_exists($filePath)) {
        // PHP headers to trigger file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        $message = "File not found!";
        $messageType = "error";
    }
}

// Handle Upload Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadedFile'])) {
    $file = $_FILES['uploadedFile'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $originalName = basename($file['name']);
        $destination = $uploadDir . $originalName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $message = "File uploaded successfully!";
            $messageType = "success";
            $uploadedFile = $originalName;
        } else {
            $message = "Failed to move uploaded file.";
            $messageType = "error";
        }
    } else {
        $message = "Upload error code: " . $file['error'];
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Task 1 – File Upload & Download</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        h1 {
            font-size: 1.6rem;
            color: #38bdf8;
            margin-bottom: 0.5rem;
        }

        p.sub {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .upload-area {
            border: 2px dashed #334155;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .upload-area:hover {
            border-color: #38bdf8;
        }

        .upload-area input[type="file"] {
            display: none;
        }

        .upload-area label {
            cursor: pointer;
            color: #38bdf8;
            font-weight: 600;
            display: block;
        }

        .upload-area p {
            color: #64748b;
            font-size: 0.85rem;
            margin-top: 0.4rem;
        }

        .btn {
            display: inline-block;
            padding: 0.7rem 1.8rem;
            border-radius: 8px;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 1.2rem;
            width: 100%;
            transition: opacity 0.2s;
        }

        .btn-upload {
            background: #38bdf8;
            color: #0f172a;
        }

        .btn-download {
            background: #22c55e;
            color: #fff;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1.5rem;
            font-size: 0.95rem;
        }

        .alert.success {
            background: #14532d;
            color: #86efac;
            border: 1px solid #166534;
        }

        .alert.error {
            background: #450a0a;
            color: #fca5a5;
            border: 1px solid #7f1d1d;
        }

        #file-name {
            margin-top: 0.8rem;
            color: #94a3b8;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>📁 File Upload & Download</h1>
        <p class="sub">Task 1 — Upload any file and download it back</p>

        <!-- UPLOAD FORM: enctype="multipart/form-data" is required for file uploads -->
        <form method="POST" enctype="multipart/form-data">
            <div class="upload-area">
                <label for="file-input">⬆ Click to Choose a File</label>
                <input type="file" id="file-input" name="uploadedFile"
                    onchange="document.getElementById('file-name').textContent = this.files[0]?.name || ''">
                <p>PDF, Image, Text, or any file type</p>
                <div id="file-name"></div>
            </div>
            <button type="submit" class="btn btn-upload">Upload File</button>
        </form>

        <?php if ($message): ?>
            <div class="alert <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
                <?php if ($uploadedFile): ?>
                    <br><br>
                    <!-- PHP header() download link -->
                    <a class="btn btn-download" href="?download=<?= urlencode($uploadedFile) ?>">
                        ⬇ Download "<?= htmlspecialchars($uploadedFile) ?>"
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
</div>


</body>
</html>