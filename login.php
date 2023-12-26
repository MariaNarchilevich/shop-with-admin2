<?php
include "services.php";

function login(): string
{
    $template_path = "templates/company/login.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mysqli = get_db(); 

        $sql = sprintf("SELECT * FROM user
                        WHERE email = '%s'",
                        $mysqli->real_escape_string($_POST["email"]));
                
        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();

        if($user){
            if (is_given_auth_data_correct($user, $_POST)) {
                add_user_to_cookie($user);
                header("Location: index.php");
            }else {
                $context = ["error_msg" => "Неверный логин или пароль"];
                return get_template($template_path, $context);
            }
        }else {
            $context = ["error_msg" => "Неверный логин или пароль"];
            return get_template($template_path, $context);
        }
    }

    redirect_to_index_user_if_logged_in($_COOKIE);

    return get_template($template_path);
}

echo login();