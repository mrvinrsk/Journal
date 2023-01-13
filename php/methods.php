<?php
function truncate_words($text, $max_words)
{
    $words = preg_split('/\s+/', $text);
    if (count($words) > $max_words) {
        return implode(' ', array_slice($words, 0, $max_words)) . ' <i class="text-muted">[...]</i>';
    }
    return $text;
}

function genStr($length, $pattern)
{
    $result = "";
    $regex = '/[' . $pattern . ']/';
    while (strlen($result) < $length) {
        $randomByte = random_bytes(1);
        $randomChar = bin2hex($randomByte);
        if (preg_match($regex, $randomChar)) {
            $result .= $randomChar;
        }
    }
    return $result;
}

function getLoggedInUser($pdo)
{
    // get session id by cookie "sessionId" and return the user id, when no session is found return -1
    $sessionId = $_COOKIE["sessionId"];

    $userId = $pdo->query("SELECT userId FROM LoginSession WHERE sessionId = '$sessionId';")->fetch()["userId"];
    if ($userId == null) {
        echo $userId;
        return -1;
    }
    return $userId;
}

function now()
{
    date_default_timezone_set('Europe/Berlin');
    return date("Y-m-d H:i:s");
}

function set_cookie($name, $value, $expire)
{
    setcookie($name, $value, time() + $expire, '/');
    $_COOKIE[$name] = $value;
}
