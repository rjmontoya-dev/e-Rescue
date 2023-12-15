<?php

namespace Database\Seeders;

use App\Models\Message_Content;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $messaging =[
        [
            'category'=>'lvl1',
            'body'=>'Level 1 Deafult Message',
        ],
        [
            'category'=>'lvl2',
            'body'=>'Level 2 Deafult Message',
        ],

        [
            'category'=>'lvl3',
            'body'=>'Level 3 Deafult Message',
        ],
       ];
       foreach($messaging as $message){
            $exist = Message_Content::where('category',$message['category'])->first();
            if(!$exist){
                Message_Content::create($message);
            }
       }
    }
}
