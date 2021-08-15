<?php

namespace App\Constants;

use phpDocumentor\Reflection\Types\Self_;

final class ObjectTypes
{
    const PRODUCT = 'App\Models\Product';
    const ORDER = 'App\Models\Order';
    const CATEGORY = 'App\Models\Category';
    const UNIT = 'App\Models\Unit';
    const USER = 'App\Models\User';
    const ADDRESS = 'App\Models\Address';
    const VENDOR = 'App\Models\Vendor';
    const LOCATION = 'App\Models\Location';
    const BRANCH = 'App\Models\Branch';
    const BRANCH_PRODUCT = 'App\Models\BranchProduct';
    const BRANCH_ZONE = 'App\Models\BranchZone';
    const VEHICLES = 'App\Models\Vehicle';
    const TICKET = 'App\Models\Ticket';
    const TICKET_REPLY = 'App\Models\TicketReply';
    const REVIEW = 'App\Models\Review';
    const ACTIVITY = 'App\Models\Activity';
    const GROUP = 'App\Models\Group';
    const GROUPPERMISSION = 'App\Models\GroupPermission';
    const PRODUCT_REVIEW = 'App\Models\ProductReview';
    const SHIPPING_COMPANY = 'App\Models\ShippingCompany';

    public static function getKeyList()
    {
        return array_keys(self::getList());
    }

    public static function getList()
    {
        return [
            ObjectTypes::PRODUCT => trans("products"),
            ObjectTypes::ORDER => trans("orders"),
            ObjectTypes::CATEGORY => trans("categories"),
            ObjectTypes::UNIT => trans("units"),
            ObjectTypes::USER => trans("users"),
            ObjectTypes::ADDRESS => trans("address"),
            ObjectTypes::VENDOR => trans("vendors"),
            ObjectTypes::LOCATION => trans("locations"),
            ObjectTypes::BRANCH => trans("branches"),
            ObjectTypes::BRANCH_PRODUCT => trans("branch_products"),
            ObjectTypes::BRANCH_ZONE => trans("branch_zones"),
            ObjectTypes::VEHICLES => trans("vehicles"),
            ObjectTypes::TICKET => trans("tickets"),
            ObjectTypes::TICKET_REPLY => trans("ticket_replies"),
            ObjectTypes::REVIEW => trans("reviews"),
            ObjectTypes::PRODUCT_REVIEW => trans("product_review"),
            ObjectTypes::ACTIVITY => trans("activities"),
            ObjectTypes::GROUP => trans("groups"),
            ObjectTypes::GROUPPERMISSION => trans("groupPermissions"),
            ObjectTypes::PRODUCT_REVIEW => trans("product_review"),
            ObjectTypes::SHIPPING_COMPANY => trans("shipping_company"),
        ];
    }

    public static function getOne($index = '')
    {
        $list = self::getList();
        $list_one = '';
        if ($index) {
            $list_one = $list[$index];
        }
        return $list_one;
    }
}
