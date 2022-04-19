<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 100件のダミー投稿を生成
        for($i = 1; $i <= 100; $i++) {
            DB::table('messages')->insert([
                'name' => 'テスト名前: ' . $i,
                'title' => 'テストタイトル: ' . $i,
                'body' => 'テスト内容: ' . $i,
                'image' => '1.jpg'
            
            ]);
        }
    }
}
