<?php

namespace Database\Seeders;

use App\Models\PaymentChannel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channels = [
            [
                'code' => 'MYBVA',
                'name' => 'Maybank Virtual Account',
                'min_amount' => 10000,
                'max_amount' => 10000000,
                'min_expired' => 15,
                'max_expired' => 43200,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 4250,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/ZT91lrOEad1582929126.png'
            ],
            [
                'code' => 'PERMATAVA',
                'name' => 'Permata Virtual Account',
                'min_amount' => 10000,
                'max_amount' => 10000000,
                'min_expired' => 60,
                'max_expired' => 43200,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 4250,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/szezRhAALB1583408731.png'
            ],
            [
                'code' => 'BNIVA',
                'name' => 'BNI Virtual Account',
                'min_amount' => 10000,
                'max_amount' => 10000000,
                'min_expired' => 15,
                'max_expired' => 1440,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 4250,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/n22Qsh8jMa1583433577.png'
            ],
            [
                'code' => 'BRIVA',
                'name' => 'BRI Virtual Account',
                'min_amount' => 10000,
                'max_amount' => 10000000,
                'min_expired' => 60,
                'max_expired' => 43200,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 4250,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/8WQ3APST5s1579461828.png'
            ],
            [
                'code' => 'MANDIRIVA',
                'name' => 'Mandiri Virtual Account',
                'min_amount' => 10000,
                'max_amount' => 10000000,
                'min_expired' => 60,
                'max_expired' => 43200,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 4250,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/T9Z012UE331583531536.png'
            ],
            [
                'code' => 'BCAVA',
                'name' => 'BCA Virtual Account',
                'min_amount' => 10000,
                'max_amount' => 10000000,
                'min_expired' => 15,
                'max_expired' => 43200,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 5500,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/ytBKvaleGy1605201833.png'
            ],
            [
                'code' => 'MUAMALATVA',
                'name' => 'Muamalat Virtual Account',
                'min_amount' => 10000,
                'max_amount' => 10000000,
                'min_expired' => 60,
                'max_expired' => 180,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 4250,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/GGwwcgdYaG1611929720.png'
            ],
            [
                'code' => 'CIMBVA',
                'name' => 'CIMB Niaga Virtual Account',
                'min_amount' => 10000,
                'max_amount' => 10000000,
                'min_expired' => 15,
                'max_expired' => 43200,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 4250,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/WtEJwfuphn1614003973.png'
            ],
            [
                'code' => 'BSIVA',
                'name' => 'BSI Virtual Account',
                'min_amount' => 10000,
                'max_amount' => 10000000,
                'min_expired' => 60,
                'max_expired' => 180,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 4250,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/tEclz5Assb1643375216.png'
            ],
            [
                'code' => 'OCBCVA',
                'name' => 'OCBC NISP Virtual Account',
                'min_amount' => 10000,
                'max_amount' => 10000000,
                'min_expired' => 15,
                'max_expired' => 43200,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 4250,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/ysiSToLvKl1644244798.png'
            ],
            [
                'code' => 'DANAMONVA',
                'name' => 'Danamon Virtual Account',
                'min_amount' => 10000,
                'max_amount' => 10000000,
                'min_expired' => 15,
                'max_expired' => 43200,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 4250,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/F3pGzDOLUz1644245546.png'
            ],
            [
                'code' => 'OTHERBANKVA',
                'name' => 'Other Bank Virtual Account',
                'min_amount' => 10000,
                'max_amount' => 10000000,
                'min_expired' => 15,
                'max_expired' => 1440,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 4250,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/qQYo61sIDa1702995837.png'
            ],
            [
                'code' => 'ALFAMART',
                'name' => 'Alfamart',
                'min_amount' => 10000,
                'max_amount' => 2500000,
                'min_expired' => 60,
                'max_expired' => 1440,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 3500,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/jiGZMKp2RD1583433506.png'
            ],
            [
                'code' => 'INDOMARET',
                'name' => 'Indomaret',
                'min_amount' => 10000,
                'max_amount' => 2500000,
                'min_expired' => 15,
                'max_expired' => 43200,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 3500,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/zNzuO5AuLw1583513974.png'
            ],
            [
                'code' => 'ALFAMIDI',
                'name' => 'Alfamidi',
                'min_amount' => 5000,
                'max_amount' => 2500000,
                'min_expired' => 60,
                'max_expired' => 1440,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 3500,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/aQTdaUC2GO1593660384.png'
            ],
            [
                'code' => 'OVO',
                'name' => 'OVO',
                'min_amount' => 1000,
                'max_amount' => 10000000,
                'min_expired' => 15,
                'max_expired' => 43200,
                'time_expired' => 'minute',
                'type' => 'redirect',
                'tax' => 0.03,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/fH6Y7wDT171586199243.png'
            ],
            [
                'code' => 'QRIS',
                'name' => 'QRIS by ShopeePay',
                'min_amount' => 1000,
                'max_amount' => 5000000,
                'min_expired' => 60,
                'max_expired' => 60,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 750,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/BpE4BPVyIw1605597490.png'
            ],
            [
                'code' => 'QRISC',
                'name' => 'QRIS (Customizable)',
                'min_amount' => 1000,
                'max_amount' => 5000000,
                'min_expired' => 60,
                'max_expired' => 1440,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 750,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/m9FtFwaBCg1623157494.png'
            ],
            [
                'code' => 'QRIS2',
                'name' => 'QRIS',
                'min_amount' => 1000,
                'max_amount' => 5000000,
                'min_expired' => 60,
                'max_expired' => 60,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 750,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/8ewGzP6SWe1649667701.png'
            ],
            [
                'code' => 'DANA',
                'name' => 'DANA',
                'min_amount' => 1000,
                'max_amount' => 10000000,
                'min_expired' => 15,
                'max_expired' => 1440,
                'time_expired' => 'minute',
                'type' => 'redirect',
                'tax' => 0.03,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/sj3UHLu8Tu1655719621.png'
            ],
            [
                'code' => 'SHOPEEPAY',
                'name' => 'ShopeePay',
                'min_amount' => 1000,
                'max_amount' => 10000000,
                'min_expired' => 15,
                'max_expired' => 60,
                'time_expired' => 'minute',
                'type' => 'redirect',
                'tax' => 0.03,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/d204uajhlS1655719774.png'
            ],
            [
                'code' => 'QRIS_SHOPEEPAY',
                'name' => 'QRIS Custom by ShopeePay',
                'min_amount' => 1000,
                'max_amount' => 5000000,
                'min_expired' => 60,
                'max_expired' => 60,
                'time_expired' => 'minute',
                'type' => 'direct',
                'tax' => 750,
                'icon_url' => 'https://assets.tripay.co.id/upload/payment-icon/DM8sBd1i9y1681718593.png'
            ],
        ];

        foreach($channels as $channel){
            PaymentChannel::create($channel);
        }
    }
}
