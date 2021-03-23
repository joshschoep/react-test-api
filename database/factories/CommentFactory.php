<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all()->pluck('id')->toArray();
        $posts = BlogPost::all()->pluck('id')->toArray();
        $created = $this->faker->dateTimeThisDecade($max='now');
        if(mt_rand(0,2) == 0){
            $updated = $this->faker->dateTimeBetween($created, 'now');
        }else{
            $updated = Null;
        }
        return [
            'content' => $this->faker->text(400),
            'owner_id' => $this->faker->randomElement($users),
            'post_id' => $this->faker->randomElement($posts),
            'created_at' => $created,
            'updated_at' => $updated
        ];
    }
}
