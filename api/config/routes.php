<?php
return array(
    'app/api/login' => 'user/login',
    'app/api/logout' => 'user/logout',
    'app/api/register' => 'user/register',
    'app/api/users/([0-9]+)' => 'user/index/$1',
    'app/api/books/create' => 'book/create',
    'app/api/books' => 'book/index',
    'app/api/books/([0-9]+)' => 'book/index/$1',
    'app/api/books/update/([0-9]+)' => 'book/update/$1',
    'app/api/books/delete/([0-9]+)' => 'book/delete/$1'
);
