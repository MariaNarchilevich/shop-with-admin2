<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

const STATUS_ID_OF_BOUGHT = 2;
const STATUS_ID_OF_RESERVED = 1;
const STATUS_ID_OF_CANCELLED = 3;

class User
{
    const ROLE_OF_CUSTOMER_ID = 3;
    const ROLE_OF_MODERATOR_ID = 2;
    const ROLE_OF_ADMIN_ID = 1;

    public $id;
    public $is_authorized;

    public function __construct(array $cookie)
    {
        $this->id = $cookie["user_id"];
        $this->is_authorized = isset($cookie["user_id"]);
    }

    public function is_client(): bool
    {
        if (!$this->is_authorized) {
            return false;
        } else {
            return $this->get_users_role_id() == self::ROLE_OF_CUSTOMER_ID;
        }
    }

    public function is_moderator(): bool
    {
        if (!$this->is_authorized) {
            return false;
        } else {
            return $this->get_users_role_id() == self::ROLE_OF_MODERATOR_ID;
        }
    }

    private function get_users_role_id(): int
    {
        $query = "SELECT role_id FROM user WHERE id = {$this->id}";
        $mysqli = get_db();
        $user_id_as_query = $mysqli->query($query);
        $user_id = $user_id_as_query->fetch_assoc()["role_id"];
        return $user_id;
    }

    public function get_user_company_id(): int
    {
        $query = "SELECT company_id FROM user WHERE id = {$this->id}";
        $mysqli = get_db();
        $company_id_as_query = $mysqli->query($query);
        $company_id = $company_id_as_query->fetch_assoc()["company_id"];
        return $company_id;
    }
}

class ObjectHandler
{
    public $object_table_name;

    public function __construct($object_table_name)
    {
        $this->object_table_name = $object_table_name;
    }

    public function get_all_objects_with_given_attr(array $object_attr): array {
        $columns_for_query = $this->get_columns_for_query($object_attr);
        $query = "SELECT {$columns_for_query} FROM {$this->object_table_name}";
        $mysqli = get_db();
        $fields_as_query = $mysqli->query($query);

        $fields = [];
        while ($this_field = $fields_as_query->fetch_assoc()) {
            array_push($fields, $this_field);
        }

        return $fields;
    }

    public function get_all_fields_of_object(int $object_id): array {
        $query = "SELECT * FROM {$this->object_table_name} WHERE id = {$object_id}";
        $mysqli = get_db();
        $fields_as_query = $mysqli->query($query);
        return $fields_as_query->fetch_assoc();
    }

    public function get_all_fields_of_table(): array {
        $query = "SELECT * FROM {$this->object_table_name}";
        $mysqli = get_db();
        $fields_as_query = $mysqli->query($query);
        $table = [];
        while($arvalue = $fields_as_query->fetch_assoc()){
            $arvalue["company_name"] = get_object_field("insurance_company", "name", $arvalue["company_id"]);
            array_push($table,$arvalue);
        }
        return $table;
    }

    public function delete_object(int $object_id): void 
    {
        $query = "DELETE FROM {$this->object_table_name} WHERE id = {$object_id}";
        $mysqli = get_db();
        $mysqli->query($query);
    }

    public function delete_all_objects(): void
    {
        $all_object_ids = $this->get_all_objects_with_given_attr(["id"]);

        foreach ($all_object_ids as $this_object_id) {
            $id = $this_object_id["id"];
            $query = "DELETE FROM {$this->object_table_name} WHERE id = {$id}";
            $mysqli = get_db();
            $mysqli->query($query);
        }
    }

    private function get_columns_for_query(array $object_attrs): string
    {
        $columns_for_query = "";
        foreach ($object_attrs as $attr) {
            $columns_for_query .= "{$attr}, ";
        }
        $columns_for_query = substr($columns_for_query, 0, -2);
        return $columns_for_query;
    }
}

class InsuranceManipulation
{
    public function create_new_insurance(array $post): void
    {
        $company_id = (int)$post["company-id"];
        $price = (int)$post["price"];
        $query = "INSERT INTO insurance (
            name,
            company_id,
            price,
            capacity,
            type,
            description
        ) VALUES (
            '{$post["name"]}',
            {$company_id} ,
            {$price},
            '{$post["capacity"]}',
            '{$post["type"]}',
            '{$post["description"]}'
        )";
        $mysqli = get_db();
        $mysqli->query($query);
    }

    public function update_existing_insurance(array $post, int $insurance_id): void
    {
        $company_id = (int)$post["company-id"];
        $price = (int)$post["price"];
        $query = "UPDATE insurance
        SET name='{$post["insurance-name"]}',
        company_id=$company_id,
            price=$price,
            capacity='{$post["capacity"]}',
            type='{$post["type"]}',
            description='{$post["description"]}'
        WHERE id = {$insurance_id}";
        $mysqli = get_db();
        $mysqli->query($query);
    }

    public function delete_existing_insurance(int $insurance_id): void
    {
        $query = "DELETE FROM insurance WHERE id = {$insurance_id}";
        $mysqli = get_db();
        $mysqli->query($query);
    }

    public function accept_insurance(int $user_id, int $order_id): void
    {
        $status_id_of_bought_insurances = STATUS_ID_OF_BOUGHT;
        $query = "UPDATE users_insurances
            SET insurance_status_id = {$status_id_of_bought_insurances}
            WHERE user_id = {$user_id} AND order_id = {$order_id}";
        $mysqli = get_db();
        $mysqli->query($query);
    }

    public function decline_insurance(int $user_id, int $order_id): void
    {
        $status_id_of_bought_insurances = STATUS_ID_OF_CANCELLED;
        $query = "UPDATE users_insurances
            SET insurance_status_id = {$status_id_of_bought_insurances}
            WHERE user_id = {$user_id} AND order_id = {$order_id}";
        $mysqli = get_db();
        $mysqli->query($query);
    }
}

function get_template($template_path, $context = null): string
{
    if (!is_null($context)) {
        foreach ($context as $key => $value) {
            $$key = $value;
        }
    }

    ob_start();
    require($template_path);
    $template = ob_get_clean();

    return $template;
}

function get_reserved_data(): array
{
    $status_id_of_reserved = STATUS_ID_OF_RESERVED;
    $query = "SELECT user_id, order_id, insurance_id, order_number, order_date FROM users_insurances
        WHERE insurance_status_id = {$status_id_of_reserved}";
    $mysqli = get_db();
    $reserved_data_as_query = $mysqli->query($query);

    $reserved_data = [];
    while ($this_reserved_data = $reserved_data_as_query->fetch_assoc()) {
        array_push($reserved_data, $this_reserved_data);
    }

    return $reserved_data;
}

function get_human_readable_reserved_insurance_data(
    array $reserved_data, $user_company_id
): array {
    $human_readable_reserved_data = [];

    foreach ($reserved_data as $this_reserved_insurance_data) {
        $user_id = $this_reserved_insurance_data["user_id"];
        $user_name = get_object_field("user", "username", $user_id);
        $order_number = $this_reserved_insurance_data["order_number"];
        $order_id = $this_reserved_insurance_data["order_id"];
        $order_date = $this_reserved_insurance_data["order_date"];
        $insurance_id = $this_reserved_insurance_data["insurance_id"];
        $insurance_name = get_object_field("insurance", "name", $insurance_id);
        $this_company = get_object_field("insurance", "company_id", $insurance_id);
        if($user_company_id == $this_company || $user_company_id==-1){
            $this_human_readable_reserved_insurance_data = [
                "user_id" => $user_id,
                "insurance_id" => $insurance_id,
                "user_name" => $user_name,
                "insurance_name" => $insurance_name,
                "order_number" => $order_number,
                "order_id" => $order_id,
                "order_date" => $order_date
            ];
            array_push(
                $human_readable_reserved_data,
                $this_human_readable_reserved_insurance_data
            );
        }
    }

    return $human_readable_reserved_data;
}

function get_db()
{
    return require __DIR__ . "/database.php";
}

function does_user_already_exist(string $email): bool 
{
    $mysqli = get_db();
    $mysqli->query("DROP PROCEDURE IF EXISTS `USER EXIST`");
    $mysqli->query("CREATE PROCEDURE `USER EXIST`()
                     BEGIN 
                        SELECT email FROM user; 
                     END");
    $all_emails_as_query = $mysqli->query("CALL `USER EXIST`();");

    $all_emails = [];
    while ($this_email = $all_emails_as_query->fetch_assoc()) {
        array_push($all_emails, $this_email["email"]);
    }

    return in_array($email, $all_emails);
}

function redirect_to_index_user_if_logged_in(array $cookie): void
{
    $user = new User($cookie);

    if ($user->is_authorized) {
        header("Location: index.php");
        exit;
    }
}

function redirect_to_index_if_user_is_not_moderator(array $cookie): void
{
    $user = new User($cookie);
    if (!$user->is_authorized || $user->is_client()) {
        header("Location: index.php");
        exit;
    }
}

function redirect_to_index_if_user_is_not_client(array $cookie): void
{
    $user = new User($cookie);
    if (!$user->is_authorized || !$user->is_client()) {
        header("Location: index.php");
        exit;
    }
}

function add_user_to_cookie(array $user): void 
{
    setcookie("user_id", $user["id"], time() + 3600);
}

function remove_user_from_cookie(array &$cookie): void
{
    if (isset($cookie["user_id"])) {
        unset($cookie["user_id"]);
        setcookie("user_id", "", time() - 1); 
    }
}

function is_given_auth_data_correct(array $user, array $post): bool
{
    return $user && $user["password"] == $post["password"];
}

function get_users_insurances_data(int $user_id): array
{
    $query = "SELECT * FROM users_insurances WHERE user_id = {$user_id}";
    $mysqli = get_db();
    $users_insurances_as_query = $mysqli->query($query);

    $users_insurances_data = [];
    while ($this_users_insurances_data = $users_insurances_as_query->fetch_assoc()) {
        array_push($users_insurances_data, $this_users_insurances_data);
    }

    return $users_insurances_data;
}


function get_insurances_data_from_db(array $users_insurances_data): array
{
    $insurances_data = [];

    foreach ($users_insurances_data as $value) {
        $this_insurance_id = $value["insurance_id"];
        $query = "SELECT * FROM insurance WHERE id = {$this_insurance_id}";
        $mysqli = get_db();
        $insurance_as_query = $mysqli->query($query);
        $this_insurance_data = $insurance_as_query->fetch_assoc();
        $this_insurance_data["company_name"] = get_object_field("insurance_company", "name", $this_insurance_data["company_id"]);
        $this_insurance_data["insurance_status"] = get_object_field("insurance_status", "name", $value["insurance_status_id"]);
        array_push($insurances_data, $this_insurance_data);
    }

    return $insurances_data;
}

function get_all_users_data_procedure(): array 
{
    $mysqli = get_db();
    $mysqli->query("DROP PROCEDURE IF EXISTS `Select Users`");
    $mysqli->query("CREATE PROCEDURE `Select Users`()
                    BEGIN
                        SELECT * FROM user;
                    END");
    $all_users_as_query = $mysqli->query("CALL `Select Users`();");
    $all_users = [];
    while ($this_user = $all_users_as_query->fetch_assoc()) {
        array_push($all_users, $this_user);
    }
    return $all_users; 
}


function get_users_insurance_status(int $insurance_id, int $user_id): int
{
    $query = "SELECT insurance_status_id FROM users_insurances 
        WHERE user_id = {$user_id} AND insurance_id = {$insurance_id}";
    $mysqli = get_db();
    $users_insurance_status_id_as_query = $mysqli->query($query);
    $users_insurance_status_id_as_fetch = $users_insurance_status_id_as_query->fetch_assoc();
    return $users_insurance_status_id_as_fetch["insurance_status_id"];
}


function get_object_field(
    string $object_table_name,
    string $object_attr,
    int $object_id
): string {
    $query = "SELECT {$object_attr} 
        FROM {$object_table_name} 
        WHERE id = {$object_id}";
    $mysqli = get_db();
    $field_as_query = $mysqli->query($query);
    return $field_as_query->fetch_assoc()[$object_attr];
}


function reserve_insurance_for_user(int $user_id, int $insurance_id): void
{
    $order_number = count(get_users_insurances_data($user_id))+1;
    $status_id_of_reserved_insurance = STATUS_ID_OF_RESERVED;
    $query = "INSERT INTO users_insurances (user_id, insurance_id, insurance_status_id, order_date, order_number)
        VALUES ({$user_id}, {$insurance_id}, {$status_id_of_reserved_insurance}, CURDATE(), {$order_number})";
    $mysqli = get_db();
    $mysqli->query($query);
}

function send_application_checking_email(string $email, string $message): void
{
    $recipient = $email;
    $subject = "Notification from NCD";

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Host = "smtp.mail.ru";
    $mail->SMTPAuth = true;
    $mail->Username = "m.narchilevich@webinspace.ru";
    $mail->Password = "feWyPfhxLdJjtrLJLpJf";
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;

    $mail->setFrom("m.narchilevich@webinspace.ru", 'РеСтрах');
    // Почта закомментирована, тк нет актуальных почт пользователей
    // $mail->addAddress($recipient);
    $mail->addAddress("mnarchilevich24@gmail.com");
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
}
