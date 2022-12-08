<?php

namespace App\service\qrcode;



use App\Entity\DossierPatient;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;



class qrcode
{
    public function __construct()
    {

    }


    public function generate(DossierPatient $dossier)
    {

        $string = "Nom patient:" . $dossier->getNom() . "\n medicaments :" . $dossier->getMedicaments(). "\n Allergies : " . $dossier->getAllergieMedic(). "\n Maladies" . $dossier->getMaladies() . "\n Details operations: " . $dossier->getDetailsOperations();
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($string)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->labelText('QR code to Dossier ')
            ->labelFont(new NotoSans(20))
            ->labelAlignment(new LabelAlignmentCenter())
            ->validateResult(false)
            ->build();
        $result->saveToFile(__DIR__ . '\\..\\..\\public\\images\\qrcode' . $dossier->getId() . '.png');
        $dataUri = $result->getDataUri();
    }
}