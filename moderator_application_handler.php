<?php
include "services.php";

function moderator_application_handler(): string
{
    redirect_to_index_if_user_is_not_moderator($_COOKIE);
    $template_path = "templates/company/moderator-application-handler.php";

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $user_id = $_GET["user_id"];
        $insurance_id = $_GET["insurance_id"];
        $order_id = $_GET["order_id"];
        $company_id = get_object_field("insurance", "company_id", $insurance_id);

        $context = [
            "user_id" => $user_id,
            "company_id" => $company_id,
            "insurance_id" => $insurance_id,
            "order_id" => $order_id,
            "user_name" => get_object_field("user", "username", $user_id),
            "insurance_name" => get_object_field("insurance", "name", $insurance_id),
            "company_name" => get_object_field("insurance_company", "name", $company_id),
            "insurance_description" => get_object_field("insurance", "description", $insurance_id),
            "insurance_type" => get_object_field("insurance", "type", $insurance_id),
            "insurance_capacity" => get_object_field("insurance", "capacity", $insurance_id),
            "insurance_price" => get_object_field("insurance", "price", $insurance_id),
            "phone_number" => get_object_field("user", "phone_number", $user_id),
        ];

        return get_template($template_path, $context);
    }

    return get_template($template_path);
}

echo moderator_application_handler();