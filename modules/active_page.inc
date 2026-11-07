<?php
$current_page = basename($_SERVER['SCRIPT_NAME']);

function is_active($page_name, $current_page) {
    return ($current_page === $page_name) ? 'class="active"' : '';
}
?>