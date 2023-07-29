<?php
require "core/Bootstrap.php";
require 'core/Router.php';
require 'core/Request.php';

require Router::load('routes.php')

->direct(Request::uri());