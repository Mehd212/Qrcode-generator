<?php

use chillerlan\QRCode\QROptions;


class QRSvgRoundOptions extends QROptions {

    protected $roundCornerSize = 0.4;


    protected function set_roundCornerSize(float $roundCornerSize):void{
        $this->roundCornerSize = $roundCornerSize;
    }
}