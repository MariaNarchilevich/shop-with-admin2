<?php
include "services.php";

function moderator_application_panel(): string
{
    redirect_to_index_if_user_is_not_moderator($_COOKIE);
    $template_path = "templates/company/moderator-application-panel.php";

    $user = new User($_COOKIE);
    $user_company_id = -1;
    if($user->is_moderator()){
        $user_company_id = $user->get_user_company_id();
    }


    $reserved_data = get_reserved_data();
    $reserved_data_for_output = get_human_readable_reserved_insurance_data(
        $reserved_data, $user_company_id
    );

    $context = [
        "reserved_data_for_output" => $reserved_data_for_output
    ];

    return get_template($template_path, $context);
}

echo moderator_application_panel();