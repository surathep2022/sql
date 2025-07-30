<?php
// function getOnlyTime($Date)
// {
//     if ($Date != '' && $Date != null) {
//         $DateTimeParts = explode(' ', $Date);
//         $Day = $DateTimeParts[0];
//         $Time = $DateTimeParts[1];
//         return $Time;
//     } else {
//         return "";
//     }
// }

function getOnlyTime($date)
{
    // Validate if the input date is not empty and is a string
    if (!empty($date) && is_string($date)) {
        // Split the date into date and time parts
        $dateTimeParts = explode(' ', $date);

        // Check if the expected parts are present
        if (count($dateTimeParts) === 2) {
            $time = $dateTimeParts[1];
            return $time;
        } else {
            // Handle invalid date format
            throw new InvalidArgumentException('Invalid date format');
        }
    } else {
        // Handle empty or non-string input
        throw new InvalidArgumentException('Invalid input date');
    }
}

function getFormattedTime($date)
{
    // Validate if the input date is not empty and is a string
    if (!empty($date) && is_string($date)) {
        // Convert the date string to a DateTime object
        $dateTime = new DateTime($date);
        
        // Format the time with AM/PM indicator
        $formattedTime = $dateTime->format('h:i A');
        
        return $formattedTime;
    } else {
        // Handle empty or non-string input
        throw new InvalidArgumentException('Invalid input date');
    }
}