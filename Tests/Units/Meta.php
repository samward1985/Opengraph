<?php

namespace Opengraph\Tests\Units;

require_once __DIR__ . '/../../library/Opengraph/Test/Unit.php';
require_once __DIR__ . '/../../library/Opengraph/Meta.php';
require_once __DIR__ . '/../../library/Opengraph/Opengraph.php';

use Opengraph;

class Meta extends Opengraph\Test\Unit
{    
    public function testMeta()
    {
        $meta = new Opengraph\Meta(Opengraph\Opengraph::OG_TITLE, 'test');
        
        $this->assert->object($meta)
            ->isInstanceOf('\Opengraph\Meta');
        
        $this->assert->string($meta->getProperty())
            ->isEqualTo('og:title');
            
        $this->assert->string($meta->getContent())
            ->isEqualTo('test');
        
        $this->assert->string($meta->render())
            ->isEqualTo('<meta property="og:title" content="test" />');
        
    }
}