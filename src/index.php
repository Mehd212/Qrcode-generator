<?php

use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\QRCode;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/QRSvgRoundOptions.php';

require __DIR__ . '/QRSvgRound.php';



$options = new QRSvgRoundOptions([
    // QROptions
    'version'             => 4,
    // CHANGE ROUND CORNER SIZE HERE
    // size of rounded corners should be between 0 and 0.5
    'roundCornerSize'     => 0.4,
    'outputType'          => QROutputInterface::CUSTOM,
    'outputInterface'     => QRSvgRound::class,
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


$qrcode = (new QRCode($options))->render('https://github.com/Mehd212', __DIR__.'/../qrcode.svg');


// if(PHP_SAPI !== 'cli'){
//     header('Content-type: image/svg+xml');

//     if(extension_loaded('zlib')){
//         header('Vary: Accept-Encoding');
//         header('Content-Encoding: gzip');
//         $qrcode = gzencode($qrcode, 9);
//     }
// }

echo $qrcode;

exit;
