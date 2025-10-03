<?php


namespace app\modules\v1\admin\customer\models;

use app\models\CustomerCompany as BaseCustomerCompany;

class CustomerCompany extends BaseCustomerCompany
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'group',
        ]);
    }

    public function getGroup()
    {
        return $this->hasOne(GroupCustomer::class, ['id' => 'group_customer']);
    }
}