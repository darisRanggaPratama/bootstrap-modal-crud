<?php
require_once 'csv_handler.php';

if(isset($_POST['bupload']) && isset($_FILES['csvFile'])) {
    $result = handleCsvUpload($_FILES['csvFile']);
    echo "<script>
            alert('$result');
            document.location = 'index.php';
          </script>";
} else {
    header("Location: index.php");
}
?>
