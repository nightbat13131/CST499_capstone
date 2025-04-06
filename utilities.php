<?php

function func_redirect(string $url, string $message = null, string $level = 'warning') {
    header("Location: $url");
    exit();
}