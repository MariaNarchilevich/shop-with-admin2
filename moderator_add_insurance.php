<?php
include "services.php";

function moderator_add_insurance(): string
{
    redirect_to_index_if_user_is_not_moderator($_COOKIE);
    $template_path = "templates/company/moderator-add-insurance.php";

    $user = new User($_COOKIE);
    $user_company_id = -1;
    if ($user->is_moderator()) {
        $user_company_id = $user->get_user_company_id();
    }

    $insurance_manipulation = new InsuranceManipulation();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $insurance_manipulation->create_new_insurance($_POST);
        $context = [
            "ok_new_value" => true
        ];
    } else {
        $object_handler = new ObjectHandler("insurance_company");

        $context = [
            "insurance_companys" => $object_handler->get_all_objects_with_given_attr(["id", "name"]),
            "user_company_id" => $user_company_id
        ];
    }



    return get_template($template_path, $context);
}

echo moderator_add_insurance();
