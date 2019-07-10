<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientOauthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users_count = DB::table('oauth_clients')->count();

        DB::table('oauth_clients')->delete();
        DB::table('oauth_personal_access_clients')->delete();

        if($users_count == 0){
            DB::table('oauth_clients')->delete();

            DB::table('oauth_clients')->insert([
                'id' => 1,
                'name' => 'Emergency Access Client',
                'secret' => 'ucGfcnkb5aTXMS3fcJEiAZlSp4KGKGahBZIgf2ro',
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::table('oauth_clients')->insert([
                'id' => 2,
                'name' => 'Emergency Personal Access Client',
                'secret' => 'NRCx71HwSJ0VCNCgRkw8wVI73vSmCwyWEIsb0qLG',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::table('oauth_personal_access_clients')->insert([
                'id' => 1,
                'client_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
