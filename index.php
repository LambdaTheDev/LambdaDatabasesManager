<?php
require 'modules/modules_loader.php';

if(Security::isAuthorized(false))
{
    header('Location: showDatabases.php');
}
else
{
    header('Location: login.php#3');
}