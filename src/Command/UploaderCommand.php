<?php

namespace App\Command;

use App\Entity\Stock;
use App\Manager\StockManager;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UploaderCommand
 * @package App\Command
 */
class UploaderCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'uploader:upload';

    /** @var string */
    private $dir;

    /** @var  StockManager */
    private $stockManager;

    /**
     * @param mixed $file
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
    }

    /**
     * @param $stockManager
     */
    public function setStockManager($stockManager)
    {
        $this->stockManager = $stockManager;
    }

    protected function configure()
    {
        $this
            ->setName('uploader:upload')
            ->addArgument('file')
            ->addOption('test')
            ->setDescription('uploader upload');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $isTest = $input->getOption('test');
        $file = $this->dir . DIRECTORY_SEPARATOR . $input->getArgument('file');
        if (!file_exists($file)) {
            $output->writeln('file not exists');

            return;
        }
        $data = file($file);
        unset($data[0]); //remove title

        $badData = [];
        $loadData = [];

        $i = 0;
        //read data
        foreach ($data as $item) {
            $i++;
            if(empty(trim($item))){
                continue;
            }
            $item = explode(',', trim($item));

            // valid data has only 6 column
            if (count($item) != 6) {
                $badData[] = ['item' => $item, 'error' => 'not valid data'];
                continue;
            }

            $code = $item[0];
            // check duplicate code
            if (array_key_exists($code, $loadData)) {
                $badData[] = ['item' => $item, 'error' => 'duplicate code'];
                continue;
            }

            $stock = (int)$item[3];

            if ($stock < 0) {
                $badData[] = ['item' => $item, 'error' => 'not valid stock'];
            }

            $cost = (double)$item[4];
            if ($cost <= 0) {
                $badData[] = ['item' => $item, 'error' => 'not valid cost'];
            }
            $discontinue = $item[5] === 'yes';

            if (($cost < 5 && $stock < 10) || ($cost > 1000)) {
                $badData[] = ['item' => $item, 'error' => 'the product does not meet the condition'];
            }

            $this->stockManager->addStock($code, $item[1], $item[2], $stock, $cost, $discontinue);
            $loadData[$code] = $item;

            if (!$isTest && $i % 1000 === 0) {
                $this->stockManager->flush();
                $this->stockManager->clear();
            }
        }
        if (!$isTest) {
            $this->stockManager->flush();
        }

        $output->writeln('Insert items :'.count($loadData));
        $output->writeln('Not Insert items :'.count($badData));
        foreach ($badData as $item) {
            $output->writeln(sprintf('%s: %s', $item['error'], implode(',', $item['item'])));
        }
    }
}