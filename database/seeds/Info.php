<?php

use Illuminate\Database\Seeder;

class Info extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('info')->delete();
        DB::table('info')->insert([
            ['id'=>1,'address'=>'Thường tín','phone'=>'0356653301','user_id'=>1],
            ['id'=>2,'address'=>'Bắc giang','phone'=>'0356654487','user_id'=>2],
            ['id'=>3,'address'=>'Huế','phone'=>'0352264487','user_id'=>1],
            ['id'=>4,'address'=>'Nghệ An','phone'=>'0357846659','user_id'=>2],
        ]);
    }
}
