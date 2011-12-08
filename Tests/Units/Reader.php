<?php

namespace Opengraph\Tests\Units;

require_once __DIR__ . '/../../library/Opengraph/Test/Unit.php';
require_once __DIR__ . '/../../library/Opengraph/Meta.php';
require_once __DIR__ . '/../../library/Opengraph/Opengraph.php';
require_once __DIR__ . '/../../library/Opengraph/Reader.php';

use Opengraph;

class Reader extends Opengraph\Test\Unit
{
    public function testClass()
    {
        $this->assert->testedClass
    		->isSubClassOf('\Opengraph\Opengraph')
    		->hasInterface('\Iterator')
    		->hasInterface('\Serializable')
    		->hasInterface('\Countable');
    }
    
    public function testReader()
    {
        $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
        <head>
        <title>Skyfall (2012) - IMDb</title>
        <meta property="og:url" content="http://www.imdb.com/title/tt1074638/" />
        <meta property="og:title" content="Skyfall (2012)"/>
        <meta property="og:type" content="video.movie"/>
        <meta property="og:image" content="http://ia.media-imdb.com/images/M/MV5BMTczMjQ5NjE4NV5BMl5BanBnXkFtZTcwMjk0NjAwNw@@._V1._SX95_SY140_.jpg"/>
        <meta property="og:site_name" content="IMDb"/>
        <meta property="fb:app_id" content="115109575169727"/>
        </head>
        <body><h1>test</h1></body></html>';
        
        $reader = new Opengraph\Reader();
        
        $this->assert->object($reader)
            ->isInstanceOf('\Opengraph\Reader');
        
        $reader->parse($html);
        
        $this->assert->integer($reader->count())
            ->isEqualTo(6);
        
        $this->assert->array($reader->getArrayCopy())->isEqualTo(array(
            'og:url' => 'http://www.imdb.com/title/tt1074638/',
            'og:title' => 'Skyfall (2012)',
            'og:type' => 'video.movie',
            'og:image' => array(
                0 => array(
                    'og:image:url' => 'http://ia.media-imdb.com/images/M/MV5BMTczMjQ5NjE4NV5BMl5BanBnXkFtZTcwMjk0NjAwNw@@._V1._SX95_SY140_.jpg',
                ),
            ),
            'og:site_name' => 'IMDb',
            'fb:app_id' => '115109575169727',
        ));
        
        $this->assert->object($reader->getMetas())
            ->isInstanceOf('\ArrayObject');
        
        $this->assert->object($reader->current())
            ->isInstanceOf('\Opengraph\Meta');
            
        $this->assert->integer($reader->key())
            ->isEqualTo(0);
        
        $reader->next();
        
        $this->assert->integer($reader->key())
            ->isEqualTo(1);
            
        $this->assert->boolean($reader->valid())->isTrue();
        
        $reader->next();
        $reader->next();
        $reader->next();
        $reader->next();
        $reader->next();
        
        $this->assert->boolean($reader->valid())->isFalse();
        
        $reader->rewind();
        
        $this->assert->integer($reader->key())
            ->isEqualTo(0);
        
    }
}