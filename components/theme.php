<?php

class Theme{
    private $cookieName = 'theme';
    private $defaultTheme = 'light';
    private $cookieExpire;
    private $cookiePath = '/';

    public function __construct(){
        $this->cookieExpire = time() + (86400 * 30);
    }

    public function getCurrentTheme(){
        if (isset($_COOKIE[$this->cookieName])) {
            return $_COOKIE[$this->cookieName];
        }
        return $this->defaultTheme;
    }

    public function setTheme($theme) {
        setcookie($this->cookieName, $theme, $this->cookieExpire, $this->cookiePath);
        $_COOKIE[$this->cookieName] = $theme;
    }

    public function toggleTheme() {
        $currentTheme = $this->getCurrentTheme();
        $newTheme = ($currentTheme === 'light') ? 'dark' : 'light';
        $this->setTheme($newTheme);
        return $newTheme;
    }
}

$themeManager = new Theme();

if(isset($_GET['toggle_theme'])){
    $themeManager->toggleTheme();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

?>