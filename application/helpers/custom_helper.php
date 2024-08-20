<?php
    function removeFlashData()
    {

        unset($_SESSION['__ci_vars']);
        unset($_SESSION['flashmsg']);
    }

    ?>