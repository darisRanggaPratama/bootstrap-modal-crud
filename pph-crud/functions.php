<?php
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

function formatNumber($number) {
    return number_format($number, 0, ',', '.');
}

function displayAlert($type, $message) {
    return "
    <div class='alert alert-{$type} alert-dismissible fade show' role='alert'>
        {$message}
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}


