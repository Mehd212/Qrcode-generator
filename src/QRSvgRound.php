<?php

use chillerlan\QRCode\Output\QRMarkupSVG;

require __DIR__ . '/../vendor/autoload.php';


/**
 * Create SVG QR Codes with rounded corners
 */
class QRSvgRound extends QRMarkupSVG{



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
        $cr = $this->options->roundCornerSize;
        if ($cr < 0) {
            $cr = 0;
        } elseif ($cr > 0.5) {
            $cr = 0.5;
        }


        $path = 'M'.$x.' '.($y + 1).' h0.5';

        // corner bottom right
        if (!$this->matrix->check($x, $y +1) && !$this->matrix->check($x +1, $y)) {
            $path .= ' h'.(0.5 - $cr).'a'.$cr.' '.$cr.' 0 0 0 '.$cr.' '.-$cr.' v'.($cr - 0.5);
        } else {
            $path .= ' h0.5';
            if($this->matrix->check($x + 1, $y) && $this->matrix->check($x, $y + 1) && !$this->matrix->check($x + 1, $y + 1)) {
                $path .= ' v'.$cr.'a'.$cr.' '.$cr.' 0 0 1 '.$cr.' '.-$cr.' h'.-$cr;
            }
            $path .= ' v-0.5';
        }
        
        // corner top right
        if (!$this->matrix->check($x, $y -1) && !$this->matrix->check($x + 1, $y)) {
            $path .= ' v'.($cr - 0.5).'a'.$cr.' '.$cr.' 0 0 0 '.-$cr.' '.-$cr.' h'.($cr - 0.5);
        } else {
            $path .= ' v-0.5';
            if ($this->matrix->check($x + 1, $y) && $this->matrix->check($x, $y - 1) && !$this->matrix->check($x + 1, $y - 1)) {
                $path .= ' h'.$cr.'a'.$cr.' '.$cr.' 0 0 1 '.-$cr.' '.-$cr.' v'.$cr;
            }
            $path .= ' h-0.5';
        }

        // corner top left
        if (!$this->matrix->check($x, $y -1) && !$this->matrix->check($x -1, $y)) {
            $path .= ' h'.($cr - 0.5).'a'.$cr.' '.$cr.' 0 0 0 '.-$cr.' '.$cr.' v'.(0.5 - $cr);
        } else {
            $path .= ' h-0.5';
            if ($this->matrix->check($x - 1, $y) && $this->matrix->check($x, $y - 1) && !$this->matrix->check($x - 1, $y - 1)) {
                $path .= ' v'.-$cr.'a'.$cr.' '.$cr.' 0 0 1 '.-$cr.' '.$cr.' h'.$cr;
            }
            $path .= ' v0.5';
        }

        // corner bottom left
        if (!$this->matrix->check($x, $y +1) && !$this->matrix->check($x -1, $y)) {
            $path .= ' v'.(0.5 - $cr).'a'.$cr.' '.$cr.' 0 0 0 '.$cr.' '.$cr;
        } else {
            $path .= ' v0.5';
            if ($this->matrix->check($x - 1, $y) && $this->matrix->check($x, $y + 1) && !$this->matrix->check($x - 1, $y + 1)) {
                $path .= ' h'.-$cr.'a'.$cr.' '.$cr.' 0 0 1 '.$cr.' '.$cr.' v'.-$cr;
            }
        }

        $path .= ' Z';

        return $path;
    }

}

