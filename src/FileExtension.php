<?php
namespace Extensions;

use GDText\Box;
use GDText\Color;

class FileExtension
{
    /**
     * Max size to generate
     *
     * @var integer
     */
    private $maxSize = 240;

    /**
     * @var int
     */
    private $minSize = 20;

    /**
     * Path to ttf font file
     *
     * @var string
     */
    private $fontFile;

    /**
     * Image php gd resource
     *
     * @var resource
     */
    private $img;

    /**
     * Background colors palette
     *
     * @var
     */
    private $backgroundColors;

    /**
     * Background color that will be used
     *
     * @var array color used for background
     */
    private $backgroundColor;

    /**
     * Font ratio
     * Used to calculate font size from image request size
     *
     * @var float
     */
    private $fontRatio = 0.3;

    /**
     * Text color
     *
     * @var array
     */
    private $textColor;

    /**
     * Text Shadow
     *
     * @var boolean
     */
    private $showTextShadow = true;

    /**
     * Set max size
     *
     * @param int $maxSize
     * @return $this
     */
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
        return $this;
    }

    /**
     * Set minimum size
     *
     * @param int $minSize
     * @return $this
     */
    public function setMinSize($minSize)
    {
        $this->minSize = $minSize;
        return $this;
    }

    /**
     * Returns font file path
     *
     * @return string
     */
    public function getFontFile()
    {
        if (!$this->fontFile) {
            return __DIR__ . '/../fonts/OpenSans-Regular.ttf';
        }

        return $this->fontFile;
    }

    /**
     * Sets font file path
     *
     * @param string $fontFile
     * @return $this
     */
    public function setFontFile($fontFile)
    {
        $this->fontFile = $fontFile;
        return $this;
    }

    /**
     * Returns color palette
     *
     * @return mixed
     */
    public function getBackgroundColors()
    {
        if (empty($this->backgroundColors)) {
            $this->backgroundColors = ColorPalette::getColors();
        }

        return $this->backgroundColors;
    }

    /**
     * Set color palette
     *
     * @param array $backgroundColors
     * @return $this
     */
    public function setBackgroundColors(array $backgroundColors)
    {
        $this->backgroundColors = $backgroundColors;
        return $this;
    }

    /**
     * Set font ratio
     *
     * @param float $fontRatio
     * @return $this
     */
    public function setFontRatio($fontRatio)
    {
        $this->fontRatio = $fontRatio;
        return $this;
    }

    /**
     * Return text color
     *
     * @return Color
     */
    public function getTextColor()
    {
        if (empty($this->textColor)) {
            $this->textColor = [255, 255, 255];
        }

        return new Color($this->textColor[0], $this->textColor[1], $this->textColor[2]);
    }

    /**
     * Set text color
     *
     * @param array $textColor (rgb)
     * @return $this
     */
    public function setTextColor(array $textColor)
    {
        $this->textColor = $textColor;
        return $this;
    }

    /**
     * Show text shadow
     *
     * @param boolean $show
     * @return $this
     */
    public function showTextShadow($show)
    {
        $this->showTextShadow = $show;
        return $this;
    }


	/**
	 * Generate a extension and return image content
	 * Background color is picked randomly.
	 *
	 * @param $extension
	 * @param null $size
	 *
	 * @return $this
	 * @internal param $string (Extension of file)
	 */
    public function generate($extension, $size = null)
    {
        $this->createImage(
	        strtoupper($extension),
            $this->getBackgroundColor(),
            $this->getSize($size)
        );

        return $this;
    }

    /**
     * Save as png
     *
     * @param     $path
     * @param int $quality
     * @return $this
     */
    public function saveAsPng($path, $quality = 9)
    {
        imagepng($this->img, $path, $quality);
        imagedestroy($this->img);

        return $this;
    }

    /**
     * Save image as Jpeg
     *
     * @param     $path
     * @param int $quality
     * @return $this
     */
    public function saveAsJpeg($path, $quality = 100)
    {
        imagejpeg($this->img, $path, $quality);
        imagedestroy($this->img);

        return $this;
    }

    /**
     * Reset background color to null, so that the next generation use
     * a new random color
     */
    public function resetBackgroundColor()
    {
        $this->backgroundColor = null;
        return $this;
    }

    /**
     * Generate image and return image
     *
     * @param $letter
     * @param $color
     * @param $size
     * @return resource
     */
    protected function createImage($extension, $color, $size)
    {
        $this->img = imagecreatetruecolor($size, $size);
        $bgColor   = imagecolorallocate($this->img, $color[0], $color[2], $color[1]);
        imagefill($this->img, 0, 0, $bgColor);

        $box = new Box($this->img);
        $box->setFontFace($this->getFontFile());
        $box->setFontColor($this->getTextColor());
        $box->setFontSize(round($size * $this->fontRatio));
        $box->setBox(0, 0, $size, $size);
        $box->setTextAlign('center', 'center');
        $box->draw($extension);
    }

    /**
     * Returns a random background color
     *
     * return  array rgb color
     */
    protected function getRandomBackgroundColor()
    {
        $colors = $this->getBackgroundColors();
        return $colors[array_rand($colors)];
    }

    /**
     * Returns color that will be used as background
     *
     * @return Color
     */
    protected function getBackgroundColor()
    {
        if (empty($this->backgroundColor)) {
            $this->backgroundColor = $this->getRandomBackgroundColor();
        }

        return $this->backgroundColor;
    }

    /**
     * Check size
     *
     * @param $size
     * @return bool|int
     */
    protected function getSize($size)
    {
        if (!$size) {
            return $this->maxSize;
        }

        $size = (int) $size;

        if ($size > $this->maxSize) {
            return $this->maxSize;
        }

        if ($size < $this->minSize) {
            return $this->minSize;
        }

        return $size;
    }

}
