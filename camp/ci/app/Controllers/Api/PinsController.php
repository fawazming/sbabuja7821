<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Pins;

class PinsController extends BaseController
{
    protected $pins;

    public function __construct()
    {
        $this->pins = new Pins();
    }

    /**
     * Verify a PIN: check if it exists and is not used.
     * Endpoint: GET /api/verify-pin?pin=xxxx
     */
    public function verifyPin()
    {
        $pin = $this->request->getGet('pin');

        if (empty($pin)) {
            return $this->response->setJSON(['error' => 'PIN is required'])->setStatusCode(400);
        }

        $pinData = $this->pins->where('pin', $pin)->first();

        if (!$pinData) {
            return $this->response->setJSON(['valid' => false, 'message' => 'PIN not found']);
        }

        if ((int) $pinData['used'] === 1) {
            return $this->response->setJSON(['valid' => false, 'message' => 'PIN already used']);
        }

        // Optionally, mark as sold when verified
        if ((int) $pinData['sold'] === 0) {
            $this->pins->where('pin', $pin)->set(['sold' => 1])->update();
        }

        return $this->response->setJSON(['valid' => true, 'message' => 'PIN is valid']);
    }

    /**
     * Check the PIN status.
     * Endpoint: GET /api/pin-status?pin=xxxx
     */
    public function pinStatus()
    {
        $pin = $this->request->getGet('pin');

        if (empty($pin)) {
            return $this->response->setJSON(['error' => 'PIN is required'])->setStatusCode(400);
        }

        $pinData = $this->pins->where('pin', $pin)->first();

        if (!$pinData) {
            return $this->response->setJSON([
                'exists' => false,
                'used' => null,
                'message' => '❌ PIN not found'
            ]);
        }

        return $this->response->setJSON([
            'exists' => true,
            'used' => (bool) $pinData['used'],
            'message' => $pinData['used'] ? '❌ PIN already used' : '✅ PIN is available'
        ]);
    }
}
