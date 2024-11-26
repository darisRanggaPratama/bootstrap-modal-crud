<!DOCTYPE html>
<html>
<head>
    <title>Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            right: -250px;
            width: 250px;
            height: 100%;
            background-color: #f8f9fa;
            transition: 0.3s;
            z-index: 1000;
            padding: 20px;
        }
        .sidebar.show {
            right: 0;
        }
        .toggle-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1001;
        }
    </style>
</head>
<body>
    <button class="btn btn-primary toggle-btn" id="sidebarToggle">☰ Menu</button>
    
    <div class="sidebar" id="sidebar">
        <h3>Navigasi</h3>
        <ul class="list-unstyled">
            <li><a href="upload.php" class="btn btn-outline-primary w-100 mb-2">Upload CSV</a></li>
            <li><a href="download.php" class="btn btn-outline-primary w-100 mb-2">Download CSV</a></li>
            <li><a href="index.php" class="btn btn-outline-primary w-100 mb-2">Home</a></li>
        </ul>
    </div>

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        });
    </script>
</body>
</html>