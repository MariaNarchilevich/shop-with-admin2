<?php
include "services.php";

function moderator_delete_all_insurances(): void
{
    redirect_to_index_if_user_is_not_moderator($_COOKIE);
    $object_handler = new ObjectHandler("insurance");
    $object_handler->delete_all_objects();
    header("Location: moderator_insurances_handler.php");
    exit;
} 

echo moderator_delete_all_insurances();