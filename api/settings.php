<?php
//Define DB credentials
const DB_HOST = '127.0.0.1';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'tle1-map-app';

//DB variable to use normal method
define("db", mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME));
