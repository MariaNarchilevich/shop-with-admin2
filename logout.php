<?php
include "services.php";

function logout(): string
{
    remove_user_from_cookie($_COOKIE);
    header("Location: index.php");
    exit;
}

echo logout();