<?php

namespace App\Manager;

use App\Entity\Stock;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class StockManager
{
    /** @var   EntityManager */
    protected $em;

    /** @var EntityRepository */
    protected $repository;

    /**
     * @param EntityRepository $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param EntityManager $em
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    /**
     * @param string  $code
     * @param string  $name
     * @param string  $description
     * @param integer $stock
     * @param double  $cost
     * @param boolean $discontinued
     *
     * @return Stock
     */
    public function addStock($code, $name, $description, $stock, $cost, $discontinued)
    {
        /** @var Stock $stock */
        $stock = new Stock($code, $name, $description, $stock, $cost, $discontinued);
        /** @var Stock $old */
        $old = $this->repository->findOneBy(['code' => $stock->getCode()]);
        if (!is_null($old)) {
            $old->setName($stock->getName());
            $old->setDescription($stock->getDescription());
            $old->setCost($stock->getCost());
            $old->setStock($stock->getStock());
            if (is_null($old->getDiscontinued())) {
                $old->setDiscontinued($stock->getDiscontinued());
            }
            $stock = $old;
        }
        $this->save($stock, false);

        return $stock;
    }

    /**
     * @param object $entity
     * @param bool   $flush
     *
     * @throws \Exception
     */
    public function save($entity, $flush = true)
    {
        $this->em->persist($entity);
        if ($flush) {
            $this->em->flush();
        }
    }

    /**
     * @param null|object|array $entity
     *
     * @return void
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function flush($entity = null)
    {
        $this->em->flush($entity);
    }

    /**
     * @param string|null $entity
     *
     * @return void
     */
    public function clear($entity = null)
    {
        $this->em->clear($entity);
    }
}