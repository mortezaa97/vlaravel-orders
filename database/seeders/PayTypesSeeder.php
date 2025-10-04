<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Mortezaa97\Orders\Models\PayType;

class PayTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payTypes = [
            [
                'id' => 1,
                'title' => 'درگاه اینترنتی',
                'desc' => 'پرداخت از طریق شبکه‌های کارت اعتباری',
                'logo' => 'files/credit-card.png',
                'created_by' => 1,
            ],
            [
                'id' => 2,
                'title' => 'کارت نقدی',
                'desc' => 'برداشت مستقیم از حساب بانکی با استفاده از کارت نقدی.',
                'logo' => 'files/debit-card.png',
                'created_by' => 1,
            ],
            [
                'id' => 3,
                'title' => 'پی‌پال',
                'desc' => 'پرداخت آنلاین از طریق حساب پی‌پال.',
                'logo' => 'files/paypal.png',
                'created_by' => 1,
            ],
            [
                'id' => 4,
                'title' => 'انتقال بانکی',
                'desc' => 'انتقال مستقیم بانکی.',
                'logo' => 'files/bank-transfer.png',
                'created_by' => 1,
            ],
        ];

        foreach ($payTypes as $payType) {
            PayType::updateOrCreate(
                ['title' => $payType['title']],
                $payType
            );
        }
    }
}
