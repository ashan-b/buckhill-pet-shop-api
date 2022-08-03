<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert(
            [
                [
                    "uuid" => "aff5584a-e8e9-326d-80cb-eb4c983c72b0",
                    "title" => "pet clean-up and odor control",
                    "slug" => "pet-clean-up-and-odor-control"
                ],
                [
                    "uuid" => "c8af6dc5-929e-3b27-ae03-27de4e77a70a",
                    "title" => "cat litter",
                    "slug" => "cat-litter"
                ],
                [
                    "uuid" => "d8f9c77d-e9f0-30d3-b276-1b7154b77853",
                    "title" => "wet pet food",
                    "slug" => "wet-pet-food"
                ],
                [
                    "uuid" => "570fe69a-a880-358c-9244-d016970c9de4",
                    "title" => "pet oral care",
                    "slug" => "pet-oral-care"
                ],
                [
                    "uuid" => "15f72817-fd7f-3bb0-9d85-167469a974bd",
                    "title" => "heartworm medication",
                    "slug" => "heartworm-medication"
                ],
                [
                    "uuid" => "ec2d5d04-6989-3a4b-822a-e06ba86295a3",
                    "title" => "pet vitamins and supplements",
                    "slug" => "pet-vitamins-and-supplements"
                ],
                [
                    "uuid" => "864c349e-181f-3fe1-ab54-43a86ec40a27",
                    "title" => "pet grooming supplies",
                    "slug" => "pet-grooming-supplies"
                ],
                [
                    "uuid" => "26befe24-c4c5-3d9b-96aa-5928d42928c4",
                    "title" => "flea and tick medication",
                    "slug" => "flea-and-tick-medication"
                ],
                [
                    "uuid" => "5f29359c-2e8c-3406-8588-47d0c7a0f3c1",
                    "title" => "pet treats and chews",
                    "slug" => "pet-treats-and-chews"
                ],
                [
                    "uuid" => "cbd3d24c-9689-36c7-954c-20e2ff333ea7",
                    "title" => "dry dog food",
                    "slug" => "dry-dog-food"
                ]
            ]
        );
    }
}
