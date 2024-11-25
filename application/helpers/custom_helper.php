<?php
    function removeFlashData()
    {

        unset($_SESSION['__ci_vars']);
        unset($_SESSION['flashmsg']);
    }
	
	
	function timeAgoHelper($timestamp) {
    // Get the current time
    $currentTime = time();
    
    // Calculate the difference between the current time and the given timestamp
    $timeDifference = $currentTime - $timestamp;
    
    // Define the time units and their corresponding values in seconds
    $units = [
        'second' => 60,
        'minute' => 60,
        'hour' => 24,
        'day' => 30,
        'month' => 12,
        'year' => INF
    ];
    
    // Iterate through the units to find the appropriate time unit
    $result = '';
    foreach ($units as $unit => $value) {
        if ($timeDifference < $value) {
            $quantity = floor($timeDifference);
            $result = ($quantity == 1) ? '1 ' . $unit . ' ago' : $quantity . ' ' . $unit . 's ago';
            break;
        }
        $timeDifference /= $value;
    }
    
    return $result;
}

function toSentenceCaseHelper($text) {
    // Ensure the input text is in UTF-8 encoding
    $text = mb_convert_encoding($text, 'UTF-8', 'auto');

    // Convert the entire string to lowercase
    $text = mb_strtolower($text, 'UTF-8');

    // Capitalize the first letter of the first word
    $text = mb_convert_case($text, MB_CASE_TITLE, 'UTF-8');

    // Fix capitalization of the first letter of the first word only
    $text = ucfirst($text);

    return $text;
}

function numberToWordsHelper($number) {
    $words = [
        '0' => 'zero', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four',
        '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen',
        '14' => 'fourteen', '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty', '30' => 'thirty',
        '40' => 'forty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety',
    ];
    
    $units = [
        '', 'thousand', 'lakh', 'crore',
    ];

    if ($number < 0) {
        return 'minus ' . numberToWordsHelper(-$number);
    }

    if ($number < 21) {
        return $words[$number];
    }

    if ($number < 100) {
        return $words[floor($number / 10) * 10] . ($number % 10 ? ' ' . numberToWordsHelper($number % 10) : '');
    }

    if ($number < 1000) {
        return numberToWordsHelper(floor($number / 100)) . ' hundred' . ($number % 100 ? ' ' . numberToWordsHelper($number % 100) : '');
    }

    if ($number < 100000) { // Up to 99,999
        return numberToWordsHelper(floor($number / 1000)) . ' thousand' . ($number % 1000 ? ' ' . numberToWordsHelper($number % 1000) : '');
    }

    // Handling numbers in lakhs and crores
    if ($number < 10000000) { // Up to 99,99,999 (Lakh)
        return numberToWordsHelper(floor($number / 100000)) . ' lakh' . ($number % 100000 ? ' ' . numberToWordsHelper($number % 100000) : '');
    }

    return numberToWordsHelper(floor($number / 10000000)) . ' crore' . ($number % 10000000 ? ' ' . numberToWordsHelper($number % 10000000) : '');
}




    ?>