<?php
namespace App\Tests\Command;

use App\Command\UploaderCommand;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class UploaderCommandTest extends KernelTestCase
{
    /**
     * @var UploaderCommand $service
     */
    protected $service;

    public function testExecute(){

        self::bootKernel();
        $this->service = static::$kernel->getContainer()->get('user.command.uploader');

        $commandTester = new CommandTester($this->service);
        $commandTester->execute(['file'=>'stock1.csv'], ['test']);
        $this->assertEquals('file not exists', trim($commandTester->getDisplay()));

        $commandTester->execute(['file'=>'stock_test.csv'], ['test']);

        $result = explode(PHP_EOL, $commandTester->getDisplay());

        $this->assertEquals('Insert items :1', trim($result[0]));
        $this->assertEquals('Not Insert items :1', trim($result[1]));
        $this->assertEquals('not valid data: P0011,Misc Cables,error in export', trim($result[2]));
    }
}