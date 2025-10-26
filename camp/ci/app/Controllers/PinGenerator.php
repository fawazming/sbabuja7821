<?php

namespace App\Controllers;

use App\Models\Pins;
use CodeIgniter\Controller;

class PinGenerator extends Controller
{
    public function generate()
    {
        $pinModel = new Pins();
        $totalPins = 1800;
        $generatedPins = [];

        // Fetch existing pins to avoid duplicates
        $existingPins = array_column($pinModel->findAll(), 'pin');
        $existingSet = array_flip($existingPins);

        while (count($generatedPins) < $totalPins) {
            $pin = str_pad(random_int(0, 9999999), 7, '0', STR_PAD_LEFT);

            if (!isset($existingSet[$pin]) && !isset($generatedPins[$pin])) {
                $generatedPins[$pin] = ['pin' => $pin, 'used' => 0];
            }
        }

        // Insert in chunks for efficiency
        $chunks = array_chunk($generatedPins, 500);
        foreach ($chunks as $chunk) {
            $pinModel->insertBatch($chunk);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => '1800 unique pins generated successfully',
            'total' => $totalPins
        ]);
    }
}
