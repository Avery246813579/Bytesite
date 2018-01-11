<!DOCTYPE html>
<html>
<body>
<footer class="main-footer">
    <div class="container">
        <?php
        require_once(dirname(__FILE__) . '../../FileHandler.php');
        $file_handler = new FileHandler();

        echo '<strong>Copyright &copy; 2014-2015 <a href="">' . $file_handler->getValue('../info.txt', 'FIRST_PART') . $file_handler->getValue('../info.txt', 'SECOND_PART') . '</a>.</strong> All rights reserved.';
        ?>

        <div class="pull-right hidden-xs">
            <b><a href="http://frostbytedev.com">Byte Site </b></a>v1.0.0 developed by <b><a href="https://twitter.com/Avery246813579">Avery Durrant</a></b>
        </div>
    </div>
</footer>
</body>
</html>