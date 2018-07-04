<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Model::unguard();   //临时取消批量赋值（mass assignment）保护 为了批量填充数据，当然要暂时性关闭安全保护，填充完毕后重新打开保护。


        $this->call(UsersTableSeeder::class);
        $this->call(TeachersTableSeeder::class);
        $this->call(BranchTableSeeder::class);
        $this->call(GradeTableSeeder::class);
        $this->call(WordTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(TopicTableSeeder::class);

        Model::reguard();
    }
}
