<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::insert(
            [
                [
                    "uuid" => "7c691a23-44a0-35c8-a040-f08f2dd5de1a",
                    "products" => json_encode(
                        [
                            [
                                "uuid" => "2a6eacf2-7c97-3519-976d-a7989d7b138d",
                                "price" => 33.62,
                                "product" => "Fresh Step Scented Litter with The Power of Febreze, Clumping Cat Litter",
                                "quantity" => 1
                            ],
                            [
                                "uuid" => "8e3c6215-a51a-3a44-8213-72063f50f73d",
                                "price" => 31.73,
                                "product" => "Purina Friskies Gravy Wet Cat Food Variety Pack, Poultry Shreds, Meaty Bits & Prime Filets - (32) 5.5 oz.",
                                "quantity" => 5
                            ],
                            [
                                "uuid" => "1be491f6-abbf-3bd6-baf1-6d4d6ed7cd9a",
                                "price" => 42.97,
                                "product" => "Vetflix Natural Pet Supplement for Dogs and Cats - Immune System Support and Overall Wellbeing",
                                "quantity" => 2
                            ],
                            [
                                "uuid" => "2d405a98-c0a2-30cb-b1cb-9a86767f7396",
                                "price" => 17.16,
                                "product" => "Purina Beneful Wet Dog Food Variety Pack",
                                "quantity" => 4
                            ],
                            [
                                "uuid" => "a9f6d572-2c8f-360a-94a8-e929ab5f5a40",
                                "price" => 42.09,
                                "product" => "Purina Tidy Cats Clumping Cat Litter",
                                "quantity" => 5
                            ],
                            [
                                "uuid" => "eaf9b656-b763-3430-ad67-0b5126a92480",
                                "price" => 26.58,
                                "product" => "Wellness Natural Pet Food Treat",
                                "quantity" => 2
                            ]
                        ]
                    ),
                    "address" => json_encode(
                        [
                            "billing" => "863 Sauer Green\nKarimouth, ND 99232-8200",
                            "shipping" => "863 Sauer Green\nKarimouth, ND 99232-8200"
                        ]
                    ),
                    "delivery_fee" => 0,
                    "amount" => 610.46,
                    "order_status_uuid" => "41c92f2b-2d6d-34e3-a792-9e80d3ae4bc3",
                    "user_uuid" => "3ce8dd8d-0416-300b-bf11-e02d37b6c34d",
                    "payment_uuid" => "3ce8dd8d-0416-300b-bf11-e02d37b6c34d",
                    "created_at"=>now()
                ],
                [
                    "uuid" => "edb8e045-650c-3225-a27c-f31e7c78a3e4",
                    "products" => json_encode(
                        [
                            [
                                "uuid" => "f8f67958-19bc-302e-97ab-dcded42a571f",
                                "price" => 15.39,
                                "product" => "Nutramax Laboratories Dasuquin with MSM Soft Chews",
                                "quantity" => 5
                            ],
                            [
                                "uuid" => "2d405a98-c0a2-30cb-b1cb-9a86767f7396",
                                "price" => 17.16,
                                "product" => "Purina Beneful Wet Dog Food Variety Pack",
                                "quantity" => 1
                            ],
                            [
                                "uuid" => "a9f6d572-2c8f-360a-94a8-e929ab5f5a40",
                                "price" => 42.09,
                                "product" => "Purina Tidy Cats Clumping Cat Litter",
                                "quantity" => 3
                            ],
                            [
                                "uuid" => "def46310-1156-343f-9121-a71c970ccc00",
                                "price" => 18.64,
                                "product" => "Black Diamond Stoneworks Ur-in Control Eliminates Urine Odors – Removes Cat, Dog, Pet, Odors Human Smells from Carpet",
                                "quantity" => 5
                            ],
                            [
                                "uuid" => "6336bce2-09dd-37ca-8e67-bc36e6dbd112",
                                "price" => 31.24,
                                "product" => "TevraPet FirstAct Plus Cat Flea and Tick Treatment, Flea Medicine for Cats 1.5 lbs and up, 6 Months Prevention",
                                "quantity" => 1
                            ],
                            [
                                "uuid" => "cca56071-2bc5-3d5b-8031-86dddfb23288",
                                "price" => 12.31,
                                "product" => "Purina ONE SmartBlend Natural Adult Chicken & Rice Dry Dog Food",
                                "quantity" => 1
                            ],
                            [
                                "uuid" => "c18e1a67-40b4-356b-a397-88c5d6e5ca57",
                                "price" => 47.01,
                                "product" => "K9 Advantix II Flea and Tick Prevention for Dogs",
                                "quantity" => 5
                            ],
                            [
                                "uuid" => "8e3c6215-a51a-3a44-8213-72063f50f73d",
                                "price" => 31.73,
                                "product" => "Purina Friskies Gravy Wet Cat Food Variety Pack, Poultry Shreds, Meaty Bits & Prime Filets - (32) 5.5 oz.",
                                "quantity" => 4
                            ],
                            [
                                "uuid" => "c04f27ee-2d39-37a9-a231-80fb66034ea0",
                                "price" => 45.5,
                                "product" => "Arm & Hammer for Pets Tartar Control Kit for Dogs-Contains Toothpaste, Dog Toothbrush & Fingerbrush",
                                "quantity" => 3
                            ],
                            [
                                "uuid" => "5c268b90-b21a-3016-8b19-2167bf363120",
                                "price" => 47.98,
                                "product" => "ARM & Hammer Clump & Seal Platinum Cat Litter, Multi-Cat, 40 lb",
                                "quantity" => 4
                            ],
                            [
                                "uuid" => "9288d106-7039-3bf9-ac9e-5917771809ac",
                                "price" => 26.81,
                                "product" => "FRONTLINE Plus Flea and Tick Treatment for Cats",
                                "quantity" => 1
                            ],
                            [
                                "uuid" => "e91a6ade-fbe7-3eba-a4f7-97fdb7c82e6c",
                                "price" => 12.26,
                                "product" => "Nature’s Miracle Cage Cleaner 24 fl oz, Small Animal Formula, Cleans And Deodorizes Small Animal Cages, 2nd Edition",
                                "quantity" => 1
                            ],
                            [
                                "uuid" => "06cace7a-6886-37c2-b9bf-1ed0589623cf",
                                "price" => 39.34,
                                "product" => "Seresto Flea and Tick Collar for Dogs, 8-Month Flea and Tick Collar for Large Dogs Over 18 Pounds",
                                "quantity" => 2
                            ],
                            [
                                "uuid" => "30726c6d-b483-3b13-96ba-0c7df63cde8e",
                                "price" => 16.79,
                                "product" => "Shout for Pets Odor and Urine Eliminator - Effective Way to Remove Puppy & Dog Odors and Stains from Carpets & Rugs",
                                "quantity" => 5
                            ],
                            [
                                "uuid" => "eaf9b656-b763-3430-ad67-0b5126a92480",
                                "price" => 26.58,
                                "product" => "Wellness Natural Pet Food Treat",
                                "quantity" => 1
                            ],
                            [
                                "uuid" => "7b232a96-30cd-30bf-b994-1cd1d6f4b6fd",
                                "price" => 47.27,
                                "product" => "Pedigree Adult Dry Dog Food, Chicken Flavor, All Bag Sizes",
                                "quantity" => 2
                            ],
                            [
                                "uuid" => "f29b1fcb-7e35-3d8f-978c-48926db34162",
                                "price" => 39.23,
                                "product" => "Pet’s Choice Naturals Bully Spirals, Low Odor Bully Stick Chew Treat for Dogs, 9\" 2 ct",
                                "quantity" => 1
                            ],
                            [
                                "uuid" => "2a6eacf2-7c97-3519-976d-a7989d7b138d",
                                "price" => 33.62,
                                "product" => "Fresh Step Scented Litter with The Power of Febreze, Clumping Cat Litter",
                                "quantity" => 4
                            ],
                            [
                                "uuid" => "92761af3-20d0-36a1-a62c-c56996d3f24e",
                                "price" => 40.24,
                                "product" => "Precious Cat Unscented Ultra Clumping Cat Litter",
                                "quantity" => 5
                            ],
                            [
                                "uuid" => "15377f47-6dc8-3ed6-aa30-a3c9aad1a2ed",
                                "price" => 35.76,
                                "product" => "PetSafe ScoopFree Cat Litter Crystal Tray Refills for ScoopFree Self-Cleaning Cat Litter Boxes - 3-Pack - Non-Clumping, Less Mess",
                                "quantity" => 2
                            ],
                            [
                                "uuid" => "56af2cae-174f-3f90-b45d-be9fff282219",
                                "price" => 48.06,
                                "product" => "Blue Buffalo Life Protection Formula Natural Adult Dry Dog Food",
                                "quantity" => 1
                            ],
                            [
                                "uuid" => "a8e31d40-81b1-3033-a7c8-d42ec9edac2d",
                                "price" => 40.52,
                                "product" => "Newday 50 Pieces Double-Headed Dog Cat Pet Toothbrush , Super Soft Bristles Oral Care Teeth , pet tooth brush for dogs , dog toothbrushes",
                                "quantity" => 4
                            ],
                            [
                                "uuid" => "1be491f6-abbf-3bd6-baf1-6d4d6ed7cd9a",
                                "price" => 42.97,
                                "product" => "Vetflix Natural Pet Supplement for Dogs and Cats - Immune System Support and Overall Wellbeing",
                                "quantity" => 3
                            ],
                            [
                                "uuid" => "639b324c-bd1a-3bd0-a3f7-91fa85e3cafd",
                                "price" => 47.98,
                                "product" => "Amazon Basics Dog and Puppy Pads, Leak-proof 5-Layer Pee Pads with Quick-dry Surface for Potty Training",
                                "quantity" => 4
                            ],
                            [
                                "uuid" => "84914dbe-112d-374f-98c5-0d49e10259c0",
                                "price" => 40.91,
                                "product" => "Kaytee Food from The Wild Natural Snack",
                                "quantity" => 5
                            ],
                            [
                                "uuid" => "0f391e6e-7751-3da7-9bd2-b658b51fb98b",
                                "price" => 13.64,
                                "product" => "Cesar 36 count & 60 count Variety Pack Soft Wet Dog Food",
                                "quantity" => 3
                            ],
                            [
                                "uuid" => "1cfe1766-941d-3389-aad2-290666a8b316",
                                "price" => 19.88,
                                "product" => "Only Natural Pet RawNibs Freeze Dried Food",
                                "quantity" => 4
                            ]
                        ]
                    ),
                    "address" => json_encode(
                        [
                            "billing" => "2393 Lisette Valleys Suite 347\nSouth Tyrique, GA 54015",
                            "shipping" => "494 O'Conner Drives\nWest Eliezer, NH 49838-9209"
                        ]
                    ),
                    "delivery_fee" => 0,
                    "amount" => 2672.73,
                    "order_status_uuid" => "d2c9b721-13c3-35ba-a0b5-10e683958608",
                    "user_uuid" => "3ce8dd8d-0416-300b-bf11-e02d37b6c34d",
                    "payment_uuid" => "b0691c9f-ff47-33bf-a9dd-a7ca6077dc17",
                    "created_at"=>now()
                ]
            ]
        );
    }
}
