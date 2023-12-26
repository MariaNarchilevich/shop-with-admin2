<?php
include "services.php";

function client_my_insurance(): string
{
    redirect_to_index_if_user_is_not_client($_COOKIE);
    $template_path = "templates/company/client-my-orders.php";


    $user_id = intval($_COOKIE["user_id"]);
    $users_insurance_data = get_users_insurances_data($user_id);
    $insurances_data = get_insurances_data_from_db($users_insurance_data);

    $context = ["orders_for_output_data" => $insurances_data];
    return get_template($template_path, $context);
}

echo client_my_insurance();   