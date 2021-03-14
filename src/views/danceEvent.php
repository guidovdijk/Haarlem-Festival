<?php
    include '../classes/autoloader.php';
    include '../controller/DanceEventController.php';

    $controller = new DanceEventController();

    $head = new head("homepage", "");
    $head->render();

    $navigation = new navigation("Home");
    $navigation->render();
?>

<section class="container section">
<?php
    $controller->render();
?>
</section>

<?php
    $footer = new footer();
    $footer->renderFooter();
?>
