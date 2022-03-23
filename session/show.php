<?php
session_set_cookie_params(3);
session_start();
var_dump($_SESSION)."<hr>";
var_dump($_COOKIE);