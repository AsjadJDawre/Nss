<?php
// handle-response.php

if (isset($_GET['response'])) {
    $response = $_GET['response'];

    // Perform actions based on the response
    if ($response === 'yes') {
        echo 'User clicked Yes. Perform action...';
        // Add your code for the "Yes" response action
    } elseif ($response === 'no') {
        echo 'User clicked No. Perform action...';
        // Add your code for the "No" response action
    } else {
        echo 'Invalid response.';
    }
} else {
    echo 'No response provided.';
}
?>
