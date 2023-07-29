<?php
require 'App.php';
require 'database/QueryBuilder.php';
require 'database/connection.php';
App::bind('config' , require 'config.php');



App::bind('database', new QueryBuilder(
    connection::make(App::get('config')['database'])
));
