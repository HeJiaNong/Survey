<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //生成数据
        //times 要生成记录的数量
        //make 生成数据
        $users = factory(User::class)->times(200)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        //指定一条数据
        $user = User::find(1);
        $user->name = 'Admin';
        $user->sex = '男';
        $user->email = 'admin@qq.com';
        $user->password = bcrypt('123456');
        $user->number = 18818881888;
        $user->addr = '成都';
        $user->status = 1;
        //保存数据
        $user->save();
    }
}
