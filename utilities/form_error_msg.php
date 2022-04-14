<?php
if(isset($_SESSION['form_msg'])) {
    echo "<script>
        alert('{$_SESSION['form_msg']}');
    </script>";
    unset($_SESSION['form_msg']);
}
?>