<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all()->pluck('id')->toArray();
        $content = $this->faker->paragraphs($nb = 5, $asText = true);
        $lead = substr($content, 0, 200);
        $created = $this->faker->dateTimeThisDecade($max='now');
        if(mt_rand(0,1) != 0){
            $updated = $this->faker->dateTimeBetween($created, 'now');
        }else{
            $updated = $created;
        }  

        return [
            'title' => $this->faker->sentence,
            'lead' => $lead,
            'content' => $content,
            'owner_id' => $this->faker->randomElement($users),
            'created_at' => $created,
            'updated_at' => $updated
        ];
    }

    public function has_owner()
    {
        return $this->state(function (array $attributes) {
            return [
                'owner_id' => $attributes['owner_id']
            ];
        });
    }
}
