<?php

function getCurrentTheme(){
    if(isset($_COOKIE['theme'])){
        return $_COOKIE['theme'];
    }
    return 'light';
}

function setTheme($theme){
    setcookie('theme', $theme, time() + (86400 * 30), "/"); // 30 days
}

function toggleTheme(){
    $current = getCurrentTheme();
    $newTheme = ($current === 'light') ? 'dark' : 'light';
    setTheme($newTheme);
    return $newTheme;
}

if(isset($_GET['toggle_theme'])){
    toggleTheme();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

?>