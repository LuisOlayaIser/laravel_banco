<?php

use App\AccountType;
use App\Bank;
use App\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Bank::truncate();
        AccountType::truncate();
        Status::truncate();

        DB::insert('insert into banks (name) values (?),(?),(?);', ['Banco bogota', 'Davibienda', 'Bancolombia']);
        DB::insert('insert into account_types (name) values (?), (?);', ['Cuenta corriente', 'Cuenta ahorro']);
        DB::insert('insert into statuses (name) values (?), (?), (?);', ['Approvado', 'Rechazado', 'Pendiente']);

    }
}
