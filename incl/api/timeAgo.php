<?php
// yep, this is now implemented
//credits: https://github.com/MrRare2
function timeAgo($timestamp) {
    $dateTime = new DateTime();
    $dateTime->setTimestamp($timestamp);
    $now = new DateTime();
    $interval = $now->diff($dateTime);

    if ($interval->y > 0) {
        return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . '';
    } elseif ($interval->m > 0) {
        return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . '';
    } elseif ($interval->d >= 28) {
        // Since all months have at least 28 days, we consider 4 weeks as 1 month for simplicity.
        return '1 month';
    } elseif ($interval->d >= 7) {
        $weeks = floor($interval->d / 7);
        return $weeks . ' week' . ($weeks > 1 ? 's' : '') . '';
    } elseif ($interval->d > 0) {
        return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . '';
    } elseif ($interval->h > 0) {
        return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ';
    } elseif ($interval->i > 0) {
        return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . '';
    } else {
        return $interval->s . ' second' . ($interval->s > 1 ? 's' : '') . '';
    }
}
?>
