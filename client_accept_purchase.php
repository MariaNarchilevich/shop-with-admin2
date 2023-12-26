<?php
include "services.php";

function client_accept_purchase(): string
{
    redirect_to_index_if_user_is_not_client($_COOKIE);
    $template_path = "templates/company/client-accept-purchase.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_POST["user-id"];
        $insurance_id = $_POST["insurance-id"];
         $date = $_POST["date"];
        reserve_insurance_for_user($user_id, $insurance_id);
    }

    return get_template($template_path);
}

echo client_accept_purchase();