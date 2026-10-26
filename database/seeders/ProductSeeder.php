<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Illustratieve catalogusgegevens en demo-richtprijzen, geen actuele winkelprijzen.
        $products = [
            ['Logitech', 'G Pro X Superlight', 'Muizen', 'Een lichte draadloze gamingmuis voor een rustige, snelle setup.', '129.99'],
            ['Logitech', 'G502 Hero', 'Muizen', 'Een gamingmuis met extra knoppen voor je favoriete acties.', '59.99'],
            ['Logitech', 'G Pro X', 'Headsets', 'Een gamingheadset voor teamcommunicatie en lange speelsessies.', '99.99'],
            ['Corsair', 'K70 RGB', 'Toetsenborden', 'Een mechanisch gamingtoetsenbord met kleurrijke verlichting.', '149.99'],
            ['Corsair', 'Harpoon RGB', 'Muizen', 'Een compacte gamingmuis voor een overzichtelijke bureauopstelling.', '39.99'],
            ['Corsair', 'HS80', 'Headsets', 'Een headset voor games, muziek en gesprekken met je team.', '119.99'],
            ['HyperX', 'Cloud III', 'Headsets', 'Een comfortabele gamingheadset met microfoon voor teamspel.', '89.99'],
            ['HyperX', 'Alloy Origins', 'Toetsenborden', 'Een mechanisch toetsenbord voor dagelijks gebruik en gaming.', '109.99'],
            ['HyperX', 'Pulsefire Haste', 'Muizen', 'Een lichte gamingmuis voor snelle bewegingen.', '49.99'],
            ['Razer', 'DeathAdder V3', 'Muizen', 'Een ergonomisch gevormde gamingmuis voor je desktopsetup.', '79.99'],
            ['Razer', 'BlackShark V2', 'Headsets', 'Een gamingheadset gericht op geluid en heldere teamcommunicatie.', '99.99'],
            ['Razer', 'Huntsman Mini', 'Toetsenborden', 'Een compact gamingtoetsenbord dat ruimte op je bureau vrijhoudt.', '119.99'],
        ];

        foreach ($products as [$brand, $title, $category, $description, $price]) {
            Product::firstOrCreate(
                ['brand' => $brand, 'title' => $title],
                compact('category', 'description', 'price'),
            );
        }
    }
}
