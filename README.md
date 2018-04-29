# File Extensions

Provide a simple way to generate any file icon so that you don't to download icon each extension type.

## Install
	
	composer require "gavande/extensions"
	
## Usage 	
	
### Generate a extension icon
 
 	$icon = new Extensions\FileExtension();
 	
 	$icon->generate('png', 40)->saveAsPng('/path/to/file.png');
 	
 	# If you don't specify a size, the max size will be used (240 by default)	 			
 		
### Custom font

The font used by default is Open Sans Regular from google font.
If you want, you can use any TTF font by setting the font file full path like so :

    $icon->setFontFile('path/to/ttf_file.ttf')
        ->generate('png', 40)
        ->saveAsPng('/path/to/file.png');
 		
 		

### Save as jpeg

	$icon->generate('png')
	    ->saveAsJpeg('/path/to/file.jpg');	
	

### Save as png

	$icon->generate('png')
	    ->saveAsPng('/path/to/file.png');	
	


### Text color

	$icon->setTextColor([255, 0, 0])
	    ->generate('png')
	    ->saveAsJpeg('/path/to/file.jpg');	
		

### Text shadow

	$icon
	    ->setTextColor([255, 0, 0])
	    ->generate('png')
	    ->showTextShadow(false)
	    ->saveAsJpeg('/path/to/file.jpg');	
		
### Background colors palette

	$icon
	    ->setBackgroundColors([[255, 0, 0], [0, 255, 0], [0, 0, 255]])
	    ->generate('png')
	    ->saveAsJpeg('/path/to/file.jpg');
			
### Using the same background color 
			
You can chain multiple generation to keep the same background color. (Generating multiple sizes)			

	$icon
	    ->generate('png', 50)->saveAsJpeg('/path/to/50x50/file.jpg')
	    ->generate('png', 100)->saveAsJpeg('/path/to/100x100/file.jpg');
        		
### Reset background color

If you want you can reset background color (so that a new random one will be used) in the middle of chaining
        	
	$icon
	    ->generate('png', 50)->saveAsJpeg('/path/to/50x50/file.jpg')
	    ->generate('png', 100)->saveAsJpeg('/path/to/100x100/file.jpg')
        ->resetBackgroundColor()
        ->generate('png', 100)->saveAsJpeg('/path/to/100x100/file.jpg');

        			
        		
		
			

	
