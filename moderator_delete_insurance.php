<?php
include "services.php";

function moderator_delete_insurance(): void 
{
    redirect_to_index_if_user_is_not_moderator($_COOKIE);
    $insurance_id = $_GET["insurance_id"];
    $insurance_manipulation = new InsuranceManipulation();
    $insurance_manipulation->delete_existing_insurance($insurance_id);
    header("Location: moderator_insurances_handler.php");
    exit;
}

echo moderator_delete_insurance();