<?php

namespace App\service;


use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCodeBundle\Response\QrCodeResponse;

class QrcodeService
{
    /**
     * @var BuilderInterface
     */
    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function qrcode($query='No informations available',
                           $url = 'Event details :')
    {
        $objDateTime = new \DateTime('NOW');
        $dateString = $objDateTime->format('d-m-Y H:i:s');
        $path = dirname(__DIR__, 2).'/public/';
        // set qrcode
        $result = $this->builder
            ->data($url.$query)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(330)
            ->margin(10)
            ->labelText($dateString)
            ->build()
        ;
//generate and save file
        //generate name
        $namePng = uniqid('', '') . '.png';
        //Save img png
        $result->saveToFile($path.'QRCodeImg/'.$namePng);
//au lieu d'aller chercher resultat je vais juste faire $result->getDataUri();
        return $result->getDataUri();
    }
}