<?php

namespace App\Services\Auth;

use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthenticationService
{
    protected Google2FA $engine;

    public function __construct(?Google2FA $engine = null)
    {
        $this->engine = $engine ?? new Google2FA();
        $this->engine->setWindow(1); // ±30s window drift tolerance
    }

    /**
     * Generate a new Base32 secret key.
     */
    public function generateSecretKey(int $length = 16): string
    {
        return $this->engine->generateSecretKey($length);
    }

    /**
     * Get standard OTPAuth URL for QR Code scanner.
     */
    public function getQrCodeUrl(string $companyName, string $companyEmail, string $secret): string
    {
        return $this->engine->getQRCodeUrl(
            $companyName,
            $companyEmail,
            $secret
        );
    }

    /**
     * Generate offline SVG QR Code string from OTPAuth URL.
     */
    public function getQrCodeSvg(string $qrCodeUrl, int $size = 200): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(
                $size,
                1, // Margin
                null,
                null,
                Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(15, 23, 42)) // Light background, slate dark foreground
            ),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        return $writer->writeString($qrCodeUrl);
    }

    /**
     * Verify a 6-digit TOTP code against a secret key.
     */
    public function verify(string $secret, string $code): bool
    {
        $cleanCode = str_replace(' ', '', trim($code));
        if (strlen($cleanCode) !== 6 || !ctype_digit($cleanCode)) {
            return false;
        }

        return (bool) $this->engine->verifyKey($secret, $cleanCode);
    }

    /**
     * Generate a collection of 8 random recovery codes.
     */
    public function generateRecoveryCodes(int $count = 8): array
    {
        return Collection::times($count, function () {
            return Str::random(10) . '-' . Str::random(10);
        })->all();
    }
}
