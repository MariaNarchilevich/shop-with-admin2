<?php
include "services.php";

function moderator_insurances_handler(): string
{
    redirect_to_index_if_user_is_not_moderator($_COOKIE);
    $user = new User($_COOKIE);
    $user_company_id = -1;
    if($user->is_moderator()){
        $user_company_id = $user->get_user_company_id();
    }

    $template_path = "templates/company/moderator-insurances-handler.php";
    $object_handler = new ObjectHandler("insurance");
    $insurances_data = $object_handler->get_all_objects_with_given_attr(["id", "name","company_id"]);
    $context = [
        "insurance_data" => $insurances_data,
        "is_user_moderator" => $user->is_moderator(),
        "user_company_id" => $user_company_id
    ];
    return get_template($template_path, $context);
}

echo moderator_insurances_handler();