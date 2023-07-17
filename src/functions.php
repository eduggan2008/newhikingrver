
<?php

// UTILITY FUNCTIONS
function is_admin($role)
{
    if ($role !== 'Admin') {                                   // If role is not admin
        header('Location: ' . DOC_ROOT);                       // Send to home page
        exit;                                                  // Stop code running
    }
}

function is_member($role)
{
    if ($role !== 'Member') {                                   // If role is not member
        header('Location: ' . DOC_ROOT);                       // Send to home page
        exit;                                                  // Stop code running
    }
}


function html_escape($text): string {
    $text = $text ?? ''; 
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); 
}

function format_date(string $string): string {
    $date = date_create_from_format('Y-m-d H:i:s', $string);    
    return $date->format('F d, Y');                             
}


function handle_error($error_type, $error_message, $error_file, $error_line) {
    throw new ErrorException($error_message, 0, $error_type, $error_file, $error_line); 
}


function handle_exception($e) {
    error_log($e);                        
    http_response_code(500);              
    echo "<h1>Sorry, a problem occurred</h1>   
          <p>Please try again later.</p>";
}

// Handle fatal errors
function handle_shutdown() {
    $error = error_get_last();            // Check for error in script
    if ($error !== null) {                // If there was an error next line throws exception
        $e = new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
        handle_exception($e);             // Call exception handler
    }
}


function redirect(string $location, array $parameters = [], $response_code = 302) {
    $qs = $parameters ? '?' . http_build_query($parameters) : '';
    $location = $location . $qs;
    header('Location: ' . $location, $response_code);
    /* header('Location: ' . DOC_ROOT . $location, true, $response_code); */
    exit;
}


function create_filename(string $filename, string $uploads): string {
    $basename  = pathinfo($filename, PATHINFO_FILENAME);          // Get basename
    $extension = pathinfo($filename, PATHINFO_EXTENSION);         // Get extension
    $cleanname = preg_replace("/[^A-z0-9]/", "-", $basename);     // Clean basename
    $filename  = $cleanname . '.' . $extension;                   // Destination
    $i         = 0;                                               // Counter
    while (file_exists($uploads . $filename)) {                   // If file exists
        $i        = $i + 1;                                       // Update counter
        $filename = $basename . '_' . $i . '.' . $extension;            // New filename
    }
    return $filename;                                             // Return filename
}


function resize_image_gd($orig_path, $new_path, $max_width, $max_height) {
    $image_data = getimagesize($orig_path);
    $orig_width = $image_data[0];
    $orig_height = $image_data[1];
    $media_type = $image_data['mime'];
    $new_width = $max_width;
    $new_height = $max_height;
    $orig_ratio = $orig_width / $orig_height;

    if ($orig_width > $orig_height) {
        $new_height = $new_width / $orig_ratio;
    } else {
        $new_width = $new_height * $orig_ratio;
    }

    switch ($media_type) {
        case 'image/jpeg' :
            $orig = imagecreatefromjpeg($orig_path);
            break;
        case 'image/png' :
            $orig = imagecreatefrompng($orig_path);
            break;
        case 'image/gif' :
            $orig = imagecreatefromgif($orig_path);
            break;
    }

    $new = imagecreatetruecolor($new_width, $new_height);

    imagecopyresampled($new, $orig, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);

    switch ($media_type) {
        case 'image/jpeg' : 
            $result = imagejpeg($new, $new_path);
            break;
        case 'image/png' : 
            $result = imagepng($new, $new_path);
            break;
        case 'image/gif' : 
            $result = imagegif($new, $new_path);
            break;
    }

    return $result;

}






