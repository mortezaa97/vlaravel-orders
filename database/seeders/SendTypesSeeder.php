<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Mortezaa97\Orders\Models\SendType;

class SendTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sendTypes = [
            [
                'id' => 1,
                'title' => 'ارسال عادی',
                'desc' => 'ارسال معمولی با زمان تحویل ۳-۵ روزه.',
                'logo' => 'files/standard-shipping.png',
                'default_price' => 50000,
                'created_by' => 1,
            ],
            [
                'id' => 2,
                'title' => 'ارسال اکسپرس',
                'desc' => 'تحویل سریع در ۱-۲ روز کاری.',
                'logo' => 'files/express-shipping.png',
                'default_price' => 100000,
                'created_by' => 1,
            ],
        ];

        foreach ($sendTypes as $payType) {
            SendType::updateOrCreate(
                ['title' => $payType['title']],
                $payType
            );
        }
    }
}
