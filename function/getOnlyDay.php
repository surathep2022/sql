<?php
function getOnlyDay($Date)
{
    if ($Date != '' && $Date != null) {
        $DateTimeParts = explode(' ', $Date);
        $Day = $DateTimeParts[0];
        $Time = $DateTimeParts[1];
        return $Day;
    } else {
        return "";
    }
}
