<?php

namespace app\modules\v1\admin\supplier\models;

use app\models\Vendor as BaseVendor;
class Vendor extends BaseVendor
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'group'
        ]);
    }

    public function getGroup()
    {
        return $this->hasOne(GroupVendor::class, ['id' => 'group_vendor']);
    }
}