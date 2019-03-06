<?php
function h($string)
{
    return htmlspecialchars($string,ENT_QUOTES);
}

function getToken()
{
    // セッション ID を作成し、hash で暗号化(sha256)する
    return hash('sha256',session_id());
}