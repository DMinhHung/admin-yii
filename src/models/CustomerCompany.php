<?php

namespace app\models;

use \app\models\base\CustomerCompany as BaseCustomerCompany;

/**
 * This is the model class for table "customer_company".
 */
class CustomerCompany extends BaseCustomerCompany
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    public function formName()
    {
        return "";
    }
}
