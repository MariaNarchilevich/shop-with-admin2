<?php
include "services.php";

function register(): string
{
    redirect_to_index_user_if_logged_in($_COOKIE);
    $template_path = "templates/company/signup.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mysqli = get_db(); 
        
        if (does_user_already_exist($_POST["email"])) {
            $context = ["error_msg" => "Пользователь с такой электронной почтой уже суцествует"];
            return get_template($template_path, $context);
        }

        $sql = "INSERT INTO user (username, email, password, phone_number, role_id)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("SQL error: {$mysqli->error}");
        }

        $standard_role_id = 3;

        $stmt->bind_param(
            "ssssi",
            $_POST["username"],
            $_POST["email"],
            $_POST["password"],
            $_POST["phone-number"],
            $standard_role_id
        );

        try {
            $stmt->execute();
            $is_signup_successful = true;
            $template_path = "templates/company/ok-signup.php";
        } catch (Exception $e) {
            $is_signup_successful = false;
        }

        $context = ["is_signup_successful" => $is_signup_successful];
        return get_template($template_path, $context);

    }

    return get_template($template_path);
}

echo register();
