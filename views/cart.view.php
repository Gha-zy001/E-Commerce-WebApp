<?php
ob_start();
require 'views/partials/header.php';
?>

<?php

        count(App::get('database')->getData('cart')) ? require 'partials/template/cart-template.view.php' :  require 'partials/template/notFound/cart_notFound.view.php';

        count(App::get('database')->getData('wishlist')) ? require 'partials/template/wishilist_template.view.php' :  require 'partials/template/notFound/wishlist_notFound.view.php';


        require 'partials/template/new-phones.view.php';

?>

<?php
require 'views/partials/footer.php';
?>


