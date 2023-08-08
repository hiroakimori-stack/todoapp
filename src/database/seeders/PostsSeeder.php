<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PostsSeeder extends Seeder
// {

//     /**
//     * Run the database seeds.
//     *
//     * @return void
//     */
    
//     public function run()
//     {
//         $now = Carbon::now();

//         DB::table('posts')->insert([
//             [
//                 'id'=> '1',
//                 'text' => 'タスク1',
//                 'complete_flag' => 0,
//                 'created_at' => $now,
//                 'updated_at' => $now,
//             ],[
//                 'id'=> '2',
//                 'text' => 'タスク2',
//                 'complete_flag' => 0,
//                 'created_at' => $now,
//                 'updated_at' => $now,
//             ],
//         ]);
//     }
// }

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    
    {
        $now = Carbon::now();

        Post::create([
            'text' => 'タスク1',
            'complete_flag' => 0,
            'deleted_at' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Post::create([
            'text' => 'タスク2',
            'complete_flag' => 0,
            'deleted_at' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
