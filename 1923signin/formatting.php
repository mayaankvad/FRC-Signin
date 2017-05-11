<?php


// seconds -> hr:min:sec
function formatSeconds($seconds) {
    return ($seconds == null)? 0: gmdate("H:i:s", intval($seconds));
}

// date -> m/d/y
function formatDate($date) {
    return ($date == null)? "Never": date("m / d / Y", strtotime($date));
}

// time -> hr: min
function formatTime($time) {
    return ($time== null)? 0: date("h:i:sa", strtotime($time));
}

/*
 * Returns a nameID from an inputed name
 * nameID is always lowercase with no spaces
 */
function toNameID($name) {
    return strtolower(str_replace(' ', '', $name));
}
