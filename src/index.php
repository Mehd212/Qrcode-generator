<?php

use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QRMarkupSVG;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Create SVG QR Codes with embedded logos (that are also SVG)
 */
class QRSvgWithLogo extends QRMarkupSVG{



    /**
     * returns a path segment for a single module
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/SVG/Attribute/d
     */
    protected function module(int $x, int $y, int $M_TYPE):string{

        if($this->options->drawCircularModules && !$this->matrix->checkTypeIn($x, $y, $this->options->keepAsSquare)){
            return '';
        }

        // size of rounded corners @cr should be between 0 and 0.5
        $cr =0.4;


        // round corners

        // corner top left, top right, bottom left et bottom right
        if (!$this->matrix->check($x, $y +1) && !$this->matrix->check($x -1, $y) && !$this->matrix->check($x + 1, $y) && !$this->matrix->check($x, $y -1)) {
            return sprintf(
                'M%1$s %2$s h%5$s a%3$s %3$s 0 0 0 %3$s -%3$s v-%5$s a%3$s %3$s 0 0 0 -%3$s -%3$s h-%5$s a%3$s %3$s 0 0 0 -%3$s %3$s v%5$s a%3$s %3$s 0 0 0 %3$s %3$s Z',
                $x + $cr,
                $y + 1,
                $cr,
                1 - $cr,
                1 - 2 * $cr,
            );
        }

        // corner top left et top right
        if (!$this->matrix->check($x, $y -1) && !$this->matrix->check($x -1, $y) && !$this->matrix->check($x + 1, $y)) {
            return sprintf(
                'M%1$s %2$s h1 v-%4$s a%3$s %3$s 0 0 0 -%3$s -%3$s h-%5$s a%3$s %3$s 0 0 0 -%3$s %3$s  Z',
                $x,
                $y + 1,
                $cr,
                1 - $cr,
                1 - 2 * $cr,
            );
        }

        // corner top left et bottom left
        if (!$this->matrix->check($x, $y -1) && !$this->matrix->check($x -1, $y) && !$this->matrix->check($x, $y + 1)) {
            return sprintf(
                'M%1$s %2$s h%4$s v-1 h-%4$s a%3$s %3$s 0 0 0 -%3$s %3$s v%5$s a%3$s %3$s 0 0 0 %3$s %3$s Z',
                $x + $cr,
                $y + 1,
                $cr,
                1 - $cr,
                1 - 2 * $cr,
            );
        }

        // corner top right et bottom right
        if (!$this->matrix->check($x, $y -1) && !$this->matrix->check($x + 1, $y) && !$this->matrix->check($x, $y + 1)) {
            return sprintf(
                'M%1$s %2$s h%4$s a%3$s %3$s 0 0 0 %3$s -%3$s v-%5$s a%3$s %3$s 0 0 0 -%3$s -%3$s h-%4$s Z',
                $x,
                $y + 1,
                $cr,
                1 - $cr,
                1 - 2 * $cr,
            );
        }

        // corner bottom left et bottom right
        if (!$this->matrix->check($x, $y +1) && !$this->matrix->check($x -1, $y) && !$this->matrix->check($x + 1, $y)) {
            return sprintf(
                'M%1$s %2$s h%5$s a%3$s %3$s 0 0 0 %3$s -%3$s v-%4$s h-1 v%4$s a%3$s %3$s 0 0 0 %3$s %3$s Z',
                $x + $cr,
                $y + 1,
                $cr,
                1 - $cr,
                1 - 2 * $cr,
            );
        }

        // corner top left
        if (!$this->matrix->check($x, $y -1) && !$this->matrix->check($x -1, $y)) {
            if($this->matrix->check($x + 1, $y) && $this->matrix->check($x, $y + 1) && !$this->matrix->check($x + 1, $y + 1)){
                return sprintf(
                    'M%1$s %2$s h1 v-1 h-%4$s a%3$s %3$s 0 0 0 -%3$s %3$s v%4$s h1 h%3$s a%3$s %3$s 0 0 0 -%3$s %3$s v-%3$s Z',
                    $x,
                    $y + 1,
                    $cr,
                    1 - $cr,
                );
            }
            return sprintf(
                'M%1$s %2$s h1 v-1 h-%4$s a%3$s %3$s 0 0 0 -%3$s %3$s  Z',
                $x,
                $y + 1,
                $cr,
                1 - $cr,
            );
        }

        // corner top right
        if (!$this->matrix->check($x, $y -1) && !$this->matrix->check($x + 1, $y)) {
            if($this->matrix->check($x - 1, $y) && $this->matrix->check($x, $y + 1) && !$this->matrix->check($x - 1, $y + 1)){
                return sprintf(
                    'M%1$s %2$s h1 v-%4$s a%3$s %3$s 0 0 0 -%3$s -%3$s h-%4$s v1 v%3$s a%3$s %3$s 0 0 0 -%3$s -%3$s Z',
                    $x,
                    $y + 1,
                    $cr,
                    1 - $cr,
                );
            }
            return sprintf(
                'M%1$s %2$s h1 v-%4$s a%3$s %3$s 0 0 0 -%3$s -%3$s h-%4$s Z',
                $x,
                $y + 1,
                $cr,
                1 - $cr,
            );
        }

        // corner bottom right
        if (!$this->matrix->check($x, $y +1) && !$this->matrix->check($x +1, $y)) {
            if ($this->matrix->check($x - 1, $y) && $this->matrix->check($x, $y - 1) && !$this->matrix->check($x - 1, $y - 1)) {
                return sprintf(
                    'M%1$s %2$s h%4$s a%3$s %3$s 0 0 0 %3$s -%3$s v-%4$s h-1 h-%3$s a%3$s %3$s 0 0 0 %3$s -%3$s Z',
                    $x,
                    $y + 1,
                    $cr,
                    1 - $cr,
                );
            }
            return sprintf(
                'M%1$s %2$s h%4$s a%3$s %3$s 0 0 0 %3$s -%3$s v-%4$s h-1 Z',
                $x,
                $y + 1,
                $cr,
                1 - $cr,
            );
        }

        // corner bottom left
        if (!$this->matrix->check($x, $y +1) && !$this->matrix->check($x -1, $y)) {
            if ($this->matrix->check($x + 1, $y) && $this->matrix->check($x, $y - 1) && !$this->matrix->check($x + 1, $y - 1)) {
                return sprintf(
                    'M%1$s %2$s h%4$s v-1 h-1 v%4$s a%3$s %3$s 0 0 0 %3$s %3$s h%4$s v-1 h%3$s a%3$s %3$s 0 0 1 -%3$s -%3$s v%3$s v1 Z',
                    $x + $cr,
                    $y + 1,
                    $cr,
                    1 - $cr,
                );
            }
            return sprintf(
                'M%1$s %2$s h%4$s v-1 h-1 v%4$s a%3$s %3$s 0 0 0 %3$s %3$s Z',
                $x + $cr,
                $y + 1,
                $cr,
                1 - $cr,
            );
        }

        // draw inner corners
        $path = 'M'.$x.' '.($y + 1).' h1';

        if($this->matrix->check($x + 1, $y) && $this->matrix->check($x, $y + 1) && !$this->matrix->check($x + 1, $y + 1)) {
            $path .= ' h'.$cr.'a'.$cr.' '.$cr.' 0 0 0 '.-$cr.' '.$cr.'v'.-$cr;
        }

        $path .= ' v-1';
        
        if ($this->matrix->check($x + 1, $y) && $this->matrix->check($x, $y - 1) && !$this->matrix->check($x + 1, $y - 1)) {
            $path .= ' h'.$cr.'a'.$cr.' '.$cr.' 0 0 1 '.-$cr.' '.-$cr.' v'.$cr;
        }

        $path .= ' h-1';

        if ($this->matrix->check($x - 1, $y) && $this->matrix->check($x, $y - 1) && !$this->matrix->check($x - 1, $y - 1)) {
            $path .= ' h'.-$cr.'a'.$cr.' '.$cr.' 0 0 0 '.$cr.' '.-$cr.' v'.$cr;
        }

        $path .= ' v1';

        if ($this->matrix->check($x - 1, $y) && $this->matrix->check($x, $y + 1) && !$this->matrix->check($x - 1, $y + 1)) {
            $path .= ' h'.-$cr.'a'.$cr.' '.$cr.' 0 0 1 '.$cr.' '.$cr.' v'.-$cr;
        }

        $path .= ' Z';

        return $path;
    }

}


/*
 * Runtime
 */

$options = new QROptions([
    // QROptions
    'version'             => 4,
    'outputType'          => QROutputInterface::CUSTOM,
    'outputInterface'     => QRSvgWithLogo::class,
    'imageBase64'         => false,
    // ECC level H is necessary when using logos
    'eccLevel'            => EccLevel::H,
    'addQuietzone'        => true,
    // if set to true, the light modules won't be rendered
    'drawLightModules'    => true,
    // draw the modules as circles isntead of squares
//    'drawCircularModules' => true,
//    'circleRadius'        => 0.45,
    // connect paths
    'connectPaths'        => true,
    // keep modules of thhese types as square
    'keepAsSquare'        => [
        QRMatrix::M_FINDER_DARK,
        QRMatrix::M_FINDER_DOT,
        QRMatrix::M_ALIGNMENT_DARK,
    ],
    // https://developer.mozilla.org/en-US/docs/Web/SVG/Element/linearGradient
    'svgDefs'             => '
	<linearGradient id="gradient" x1="100%" y2="100%">
		<stop stop-color="#000000" offset="0"/>

	</linearGradient>
	<style><![CDATA[
		.dark{fill: url(#gradient);}
        .light{fill: #fff;}
	]]></style>',
    'moduleValues' => [
        QRMatrix::M_DATA_DARK => '#ffffff',
        QRMatrix::M_DATA => '#0000ff'
    ],
]);


$qrcode = (new QRCode($options))->render('https://github.com/Mehd212', __DIR__.'/qrcode.svg');


if(PHP_SAPI !== 'cli'){
    header('Content-type: image/svg+xml');

    if(extension_loaded('zlib')){
        header('Vary: Accept-Encoding');
        header('Content-Encoding: gzip');
        $qrcode = gzencode($qrcode, 9);
    }
}

echo $qrcode;

exit;
