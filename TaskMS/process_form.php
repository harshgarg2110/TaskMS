<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define CSV file path
    $csvFile = "credit_analysis_data2.csv";

    // Extract data 
    $data = array();
    foreach ($_POST as $key => $value) {
        // validation
        $value = floatval($value);
        if (!is_numeric($value) || $value < 0) {
            die("Invalid value for $key. Please enter a valid value.");
        }
        // Append variable name and value to data array
        $data[$key] = $value;
    }

    // Determine the value of the 'default' variable 
    if ($data['income'] > 70 && $data['ed'] > 3 && $data['employ'] > 4 && $data['address'] > 4 && $data['age'] > 21) {
        $data['default'] = 0;
    } else {
        $data['default'] = 1;
    }

    // Open  CSV file for writing (overwrite mode)
    $handle = fopen($csvFile, "w");

    // Check if the file was opened successfully
    if ($handle === false) {
        die("Failed to open CSV file for writing.");
    }

    // Write header row
    fputcsv($handle, array_keys($data));

    // Write data to the CSV file
    if (fputcsv($handle, $data) === false) {
        // Failed to write data to the CSV file
        fclose($handle); 
        // Close the file handle
        die("Failed to write data to CSV file.");
    }

    // Close the CSV file handle
    fclose($handle);

    // Redirect back to the form page
    header("Location: index.html");
    exit;
}
?>
