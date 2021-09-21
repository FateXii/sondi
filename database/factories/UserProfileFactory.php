<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Storage::fake('public');
        $potentialImages = [
            "https://imgproxy.generated.photos/UpXg0wEw0O4Ryyv6sgURl_yRYCJyPPi40a8ELV9g-_E/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudF92My92/M18wNTA3MTA4LnBu/Zw.png",
            "https://imgproxy.generated.photos/6bXCSMyxd-hv52YQdk9kzwmzQsxihfZzI3dIGqAiAzo/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudF92My92/M18wODM5MjE2LnBu/Zw.png",
            "https://imgproxy.generated.photos/n9nN55s7IvjR7crgcNpFUeMQ88B5wqjm69cKBokGJTY/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudC8wMDkx/NjI2LnBuZw.png",
            "https://images.generated.photos/KWQbk6o29lsXqTmBxQqSQGVSh4_kMIcQSTup0ma-6Xw/rs:fit:256:256/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy92Ml8w/ODI2MTgxLmpwZw.jpg",
            "https://imgproxy.generated.photos/CTG41lmHf0YVkmRPiS7j8KSmi7HvatXgFY4AMahmGpk/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudC8wMTA3/OTcyLnBuZw.png",
            "https://imgproxy.generated.photos/n9nN55s7IvjR7crgcNpFUeMQ88B5wqjm69cKBokGJTY/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudC8wMDkx/NjI2LnBuZw.png",
            "https://imgproxy.generated.photos/n9nN55s7IvjR7crgcNpFUeMQ88B5wqjm69cKBokGJTY/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudC8wMDkx/NjI2LnBuZw.png",
            "https://imgproxy.generated.photos/V9RRsY5902BNwDaHMQ0BvfrfNjTyyw3kr43gP48_iAg/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudC8wMDMz/ODA4LnBuZw.png",
            "https://imgproxy.generated.photos/RKbfwnb_Kic4cbqy0h7BAgIiWCUSh_fiRr3CgxwoCEc/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudC8wMDM5/NjUxLnBuZw.png",
            "https://imgproxy.generated.photos/Cc_AMRHPOxEJQKdZlDf_9FDS8hY9zoHArKT5-FZByOA/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudC8wMjY0/ODYwLnBuZw.png",
            "https://imgproxy.generated.photos/mVlERvpiNwpkzfI2APEQRvAX9iKd3lggAbCyAhO9sMU/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudF92Mi92/Ml8wNjU4Nzc2LnBu/Zw.png",
            "https://imgproxy.generated.photos/dQfl-sJgzyXvnYLpBsr7XkCwC4kh_070zhpZp_yeKW0/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudC8wMTIx/OTEwLnBuZw.png",
            "https://imgproxy.generated.photos/Nn02-3PPakwMmWAFzpleDQW5OBEDt36dQc3uZ8ZtpYg/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudC8wMjE4/MTU4LnBuZw.png",
            "https://images.generated.photos/f_j-4ALIX-ap5fJQypgbVKMs1Zd9s01xDVUKKuIsUzU/rs:fit:256:256/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy8wMTc4/ODUwLmpwZw.jpg",
            "https://imgproxy.generated.photos/I7cwUQKdf3YNt5tQKS6qByViCLRQsUkmFmJd2knDwKo/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudC8wMTMz/NDI2LnBuZw.png",
            "https://imgproxy.generated.photos/CajF6S9B8C3LV9N9qPyDTiv3YaqloxHTq_s5x5jkYyo/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudC8wMjU4/ODc0LnBuZw.png",
            "https://imgproxy.generated.photos/hLoLDttEwISb3_QuGQBAwxmSlUV4Z7d5FxyQ9hplrPY/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudC8wMjIy/MjQyLnBuZw.png",
            "https://imgproxy.generated.photos/fM_0bwmIijZ8QE40GiSHDEygUs8UUiX7obkwznOeKyA/rs:fit:512:512/wm:0.95:sowe:18:18:0.33/czM6Ly9pY29uczgu/Z3Bob3Rvcy1wcm9k/LnBob3Rvcy90cmFu/c3BhcmVudF92Mi92/Ml8wMTM2NDYwLnBu/Zw.png",
        ];
        return [
            'photo' => $this->faker->randomElement($potentialImages),
            'bio' => $this->faker->text(),
            'phone_number' => $this->faker->phoneNumber(),
            'user_id' => User::factory(),
            'is_admin' => $this->faker->boolean,
            'is_agent' => $this->faker->boolean,
            'is_tenant' => $this->faker->boolean(70),
            'agent_registration_number' => $this->faker->text(10),
            'deleted_at' => null
        ];
    }
}
