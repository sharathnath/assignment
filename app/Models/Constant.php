<?php

namespace App\Models;

class Constant
{
    CONST DATETIME_FORMAT_MYSQL = 'Y-m-d H:i:s';
    CONST DATETIME_WEBFORMAT_WITHOUT_YEAR = 'M d h:i A';

    CONST USER_TYPE_NORMAL = 'user';
    CONST USER_TYPE_ADMIN = 'admin';

    CONST CURRENCY_AED = 'AED';

    CONST SOURCE_TYPE_WEBSITE = 1;

    CONST PRODUCT_TYPE_ALL = 1;
    CONST PRODUCT_TYPE_PAST = 2;
    CONST PRODUCT_TYPE_UPCOMING = 3;
}