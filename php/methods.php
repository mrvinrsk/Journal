<?php
function truncate_words($text, $max_words) {
    $words = preg_split('/\s+/', $text);
    if (count($words) > $max_words) {
        return implode(' ', array_slice($words, 0, $max_words)) . ' [...]';
    }
    return $text;
}
