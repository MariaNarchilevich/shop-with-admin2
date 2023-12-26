<?php
include "services.php";

function moderator_checked_application(): string
{
    redirect_to_index_if_user_is_not_moderator($_COOKIE);
    $template_path = "templates/company/moderator-checked-application.php";
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $user_id = (int)$_GET["user-id"];
        $order_id=(int)$_GET["order_id"];
        $insurance_id = (int)$_GET["insurance-id"];
        $checking_status = $_GET["checking-status"]; 
        $user_email = get_object_field("user", "email", $user_id);
        $application_comment = $_GET["application-comment"];
        $insurance_manipulation = new InsuranceManipulation();

        if ($checking_status == "accept-btn") {
            $insurance_manipulation->accept_insurance($user_id, $order_id);
        } else if ($checking_status == "decline-btn") {
            $insurance_manipulation->decline_insurance($user_id, $order_id);
        }

        send_application_checking_email($user_email, $application_comment);
       
    }

    return get_template($template_path);
}

echo moderator_checked_application();