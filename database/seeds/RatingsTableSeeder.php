<?php
use Illuminate\Database\Seeder;
class RatingsTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('cour_user')->insert([
            0 => [
                'cour_id' => 39,
                'user_id' => 3,
                'rating' => 1,
            ],
            1 => [
                'cour_id' => 40,
                'user_id' => 3,
                'rating' => 2,
            ],
            2 => [
                'cour_id' => 37,
                'user_id' => 3,
                'rating' => 2,
            ],
            3 => [
                'cour_id' => 43,
                'user_id' => 3,
                'rating' => 2,
            ],
            4 => [
                'cour_id' => 39,
                'user_id' => 2,
                'rating' => 5,
            ],
            5 => [
                'cour_id' => 37,
                'user_id' => 2,
                'rating' => 5,
            ],
            6 => [
                'cour_id' => 41,
                'user_id' => 2,
                'rating' => 3,
            ],
            7 => [
                'image_id' => 36,
                'user_id' => 2,
                'rating' => 2,
            ],
            7 => [
                'cour_id' => 31,
                'user_id' => 3,
                'rating' => 3,
            ],
            8 => [
                'cour_id' => 32,
                'user_id' => 3,
                'rating' => 3,
            ]
        ]);
    }
}
