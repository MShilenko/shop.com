<?php

define("PRODUCTS_IMAGE_FOLDER", 'img/products/');
define("PRODUCTS_UPLOAD_FOLDER", $_SERVER['DOCUMENT_ROOT'] . PRODUCTS_IMAGE_FOLDER);
define("ALLOWED_FILE_TYPES", 'image/jpeg,image/png');
define("ALLOWED_FILE_SIZE", 5000000);
define("PRODUCTS_CATEGORIES_PATH", '/categories/');
define("ALLOWED_TABLES_NAMES", 'categories, pages, products');