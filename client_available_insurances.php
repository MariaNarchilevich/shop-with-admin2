<?php
include "services.php";

function client_available_insurances(): string
{
    redirect_to_index_if_user_is_not_client($_COOKIE);
    $template_path = "templates/company/client-available-insurances.php";

    $user_id = intval($_COOKIE["user_id"]); 

    $table = new ObjectHandler("insurance");

    $all_insurances = $table->get_all_fields_of_table();
    
    $context = [
        "all_insurances" => $all_insurances,
        "user_id" => $user_id,
    ];

    return get_template($template_path, $context);
}

echo client_available_insurances();