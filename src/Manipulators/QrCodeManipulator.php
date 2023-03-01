<?php

declare(strict_types=1);

namespace PreemStudio\CharacterBuilder\Manipulators;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Intervention\Image\Facades\Image as Intervention;
use Intervention\Image\Image;
use PreemStudio\CharacterBuilder\Contracts\Manipulator;
use PreemStudio\CharacterBuilder\Path;

class QrCodeManipulator implements Manipulator
{
    public function __construct(private QrCode $image)
    {
        //
    }

    public function manipulate(string $seed, array $configuration, Image $backgroundImage): Image
    {
        (new PngWriter)->write($this->image)->saveToFile(Path::characters("{$seed}/qr.png"));

        $qrImage = Intervention::make(Path::characters("{$seed}/qr.png"));
        $backgroundImage->insert($qrImage, 'bottom-right', 4, 4);

        unlink(Path::characters("{$seed}/qr.png"));

        return $backgroundImage;
    }
}