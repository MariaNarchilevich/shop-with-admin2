<?php
include "services.php";

function index(): string
{
    $template_path = "templates/company/index.php";
    $user = new User($_COOKIE);

    $context = [
        "is_user_authorized" => $user->is_authorized,
        "is_user_client" => $user->is_client(),
        "is_user_moderator" => $user->is_moderator()
    ];

    return get_template($template_path, $context);
}

echo index();
