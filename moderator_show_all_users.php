<?php
include "services.php";

function moderator_show_all_orders(): string
{
    redirect_to_index_if_user_is_not_moderator($_COOKIE);
    $template_path = "templates/company/moderator-show-all-user.php";
    $context = ["all_users_data" => get_all_users_data_procedure()];
    return get_template($template_path, $context);
}

echo moderator_show_all_orders();