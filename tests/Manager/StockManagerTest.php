<?php

namespace App\Tests\Manager;

use App\Manager\StockManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class DateFormatterTest
 * @package Tests\AppBundle\Services
 */
class StockManagerTest extends KernelTestCase
{
    /**
     * @var StockManager $service
     */
    protected $service;

    protected function setUp()
    {
        self::bootKernel();

        $this->service = static::$kernel->getContainer()->get('app.stock_manager');
    }

    /**
     * test
     */
    public function testAddStock()
    {
        $scenarios = [
            ['P0005', 'XBOX360', 'Best.console.ever', 5, 30.44, false],
            ['P0025', 'TV', 'Great for television', 21, 40, true],
        ];

        foreach ($scenarios as $scenario) {

             $this->assertEquals(
                is_object(
                    $this->service->addStock(
                        $scenario[0],
                        $scenario[1],
                        $scenario[2],
                        $scenario[3],
                        $scenario[4],
                        $scenario[5]
                    )
                ),
                true
            );
        }
    }
}