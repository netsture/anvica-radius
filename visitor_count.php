<?php
// Path to the counter file
$counterFile = 'counter.txt';

// Check if the counter file exists
if (!file_exists($counterFile)) {
    // If the counter file doesn't exist, create it and initialize the count to 0
    file_put_contents($counterFile, '0');
}

// Read the current count from the file
$visitorCount = (int)file_get_contents($counterFile);

// Increment the count by 1
$visitorCount++;

// Write the updated count back to the file
file_put_contents($counterFile, $visitorCount);

// Return the visitor count as JSON (to be used by JavaScript)
echo json_encode(['visitorCount' => $visitorCount]);
?>
