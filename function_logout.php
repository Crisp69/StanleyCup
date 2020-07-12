<?php
function parselogout($nick) {
    setcookie("login_session", " ", time()-3600);
}
?>