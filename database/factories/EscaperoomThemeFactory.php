<?php

declare(strict_types=1);

namespace Tipoff\EscapeRoom\Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\EscapeRoom\Models\EscaperoomTheme;

class EscaperoomThemeFactory extends Factory
{
    protected $model = EscaperoomTheme::class;

    public function definition()
    {
        $name = $this->faker->name;

        return [
            'slug'            => Str::slug($name),
            'name'            => $name,
            'title'           => $name,
            'full_title'      => $name,
            'excerpt'         => $this->faker->sentences(1, true),
            'description'     => $this->faker->sentences(2, true),
            'synopsis'        => $this->faker->sentences(7, true),
            'story'           => $this->faker->paragraphs(3, true),
            'info'            => $this->faker->sentences(2, true),
            'duration'        => $this->faker->randomElement([45, 60, 60, 60, 60, 60, 75, 90, 120]),
            'occupied_time'   => $this->faker->randomElement([45, 60, 75, 75, 90, 90, 90, 90, 120]),
            'scavenger_level' => $this->faker->numberBetween(1, 5),
            'puzzle_level'    => $this->faker->numberBetween(1, 5),
            'escape_rate'     => $this->faker->numberBetween(1, 100),
            'supervision_id'  => randomOrCreate(app('supervision')),
            'poster_image_id' => randomOrCreate(app('image')),
            'icon_id'         => randomOrCreate(app('image')),
            'image_id'        => randomOrCreate(app('image')),
            'video_id'        => randomOrCreate(app('video')),
            'creator_id'      => randomOrCreate(app('user')),
            'updater_id'      => randomOrCreate(app('user'))
        ];
    }
}
