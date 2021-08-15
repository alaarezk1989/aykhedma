<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ActivitiesSeeder::class);
        $this->call(VendorsSeeder::class);
        $this->call(GroupsSeeder::class);
        $this->call(UsersTableSeeder::class);
        //$this->call(UserAddressesSeeder::class);
        $this->call(UnitsSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(BranchesSeeder::class);
        $this->call(ProductsSeeder::class);
        //$this->call(BranchProductsSeeder::class);
        //$this->call(OrdersSeeder::class);
        //$this->call(OrderProductsSeeder::class);
        $this->call(SubscribersSeeder::class);
        $this->call(TicketReasonsSeeder::class);
        //$this->call(TicketsSeeder::class);
        $this->call(SettingsTableSeeder::class);
        //$this->call(TicketReplySeeder::class);
        //$this->call(StocksSeeder::class);
        //$this->call(UserDevicesSeeder::class);
        $this->call(ShippingCompaniesSeeder::class);
        //$this->call(VehiclesSeeder::class);
        //$this->call(BranchZonesSeeder::class);
        $this->call(TradersSeeder::class);
        $this->call(BannersTableSeeder::class);
        //$this->call(LogsSeeder::class);
        //$this->call(CouponesSeeder::class);
        //$this->call(DiscountsTableSeeder::class);
        //$this->call(CompaniesSeeder::class);
        $this->call(GroupPermissionsSeeder::class);
        //$this->call(ShipmentsTableSeeder::class);
        //$this->call(ActualShipmentsTableSeeder::class);
    }
}
