<!DOCTYPE html>
<html lang="en">
<head>
    <title>Number to String Conversion</title>
</head>
<body>
<h1>Number to String Conversion</h1>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="number">Enter a number:</label>
    <input type="number" id="number" name="number" required>
    <button type="submit">Convert</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted

    // Get the input number from the form
    $number = $_POST["number"];

    // Call the function to convert the number to string
    $result = convertNumberToString($number);

    // Display the result
    echo "<p>The number $number is converted to: $result</p>";
}
?>

<?php
function convertNumberToString($number)
{
    // Define arrays for number-to-word mappings
    $units = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');
    $tens = array('', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety');
    $thousands = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion', 'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion', 'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion');

    // Handle special cases for zero and negative numbers
    if ($number == 0) {
        return 'zero';
    } elseif ($number < 0) {
        return 'negative ' . convertNumberToString(abs($number));
    }

    // Initialize variables
    $string = '';

    // Split the number into groups of three digits
    $groups = array_reverse(str_split(str_pad($number, ceil(strlen($number) / 3) * 3, '0', STR_PAD_LEFT), 3));

    // Iterate over each group and convert it to words
    foreach ($groups as $groupIndex => $group) {
        $groupString = '';

// Split the group into hundreds, tens, and units
        $hundreds = floor($group / 100);
        $tensAndUnits = $group % 100;

// Convert hundreds to words
        if ($hundreds > 0) {
            $groupString .= $units[$hundreds] . ' hundred ';
        }

// Convert tens and units to words
        if ($tensAndUnits > 0) {
            if ($tensAndUnits < 20) {
                $groupString .= $units[$tensAndUnits];
            } else {
                $tensDigit = floor($tensAndUnits / 10);
                $unitDigit = $tensAndUnits % 10;
                $groupString .= $tens[$tensDigit] . ' ' . $units[$unitDigit];
            }
        }

// Add the appropriate thousand/million/billion suffix
        if ($groupString != '') {
            $groupString .= ' ' . $thousands[$groupIndex];
        }

// Append the group string to the final string
        $string = $groupString . ' ' . $string;
    }

// Clean up extra spaces and return the final string
    return trim($string);
}

?>
</body>
</html>
