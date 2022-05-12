<?php
session_start();
include 'core/functions.php';
session_destroy();
redierct("index.php");
die;
