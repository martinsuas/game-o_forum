<?php

# Script 9.2 mysqli_connect.php
# 6/27/2016 by Martin Suarez
# This scripts connects to the database and sets the encoding.
# To be included in all subpages.

// Defined as constants for security reasons.
DEFINE( 'DB_USER', 'a8862084_admin');
DEFINE( 'DB_PASSWORD', 'hello123');
DEFINE( 'DB_HOST', 'mysql11.000webhost.com');
DEFINE( 'DB_NAME', 'a8862084_db01');

$dbc = @mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR
        die ( 'Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding
mysqli_set_charset($dbc, 'utf8');

