<?php
session_start();
session_destroy();

header("location:loginform.php"); // Redirect to the login page after logout
exit();
?>
<script>
    window.history.forward();

    function noBack() {
        window.history.forward();
    }
</script>