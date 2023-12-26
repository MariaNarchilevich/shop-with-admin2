<?php
include "services.php";

function moderator_edit_insurance(): string
{
    redirect_to_index_if_user_is_not_moderator($_COOKIE);
    $template_path = "templates/company/moderator-edit-insurance.php";

    $user = new User($_COOKIE);

    $insurance_id = $_GET["insurance_id"];
    $insurance_object_handler = new ObjectHandler("insurance");
    $insurance_data = $insurance_object_handler->get_all_fields_of_object($insurance_id);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $insurance_manipulation = new InsuranceManipulation();
        $insurance_manipulation->update_existing_insurance($_POST, $insurance_id);
        header("Location: moderator_insurances_handler.php");
        exit;
    }

    $object_handler = new ObjectHandler("insurance_company");
    
    $context = [
        "insurance_data" => $insurance_data,
        "insurance_companys" => $object_handler->get_all_objects_with_given_attr(["id","name"]),
        "is_moderator" => $user->is_moderator()
    ];

    return get_template($template_path, $context);
}

echo moderator_edit_insurance();