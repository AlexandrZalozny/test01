<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Act
 * ORM\Entity(repositoryClass="AppBundle\Repository\ActRepository")
 * @ORM\Entity()
 * @ORM\Table(name="tblProductData")
 */
class Stock
{

    /**
     * @ORM\Column(name="intProductDataId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="strProductName", type="string", length=50, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(name="strProductDesc", type="string", length=255, nullable=false)
     */
    protected $description;

    /**
     * @ORM\Column(name="strProductCode", type="string", length=10, nullable=false, unique=true)
     */
    protected $code;

    /**
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true)
     */
    protected $added;

    /**
     * @ORM\Column(name="dtmDiscontinued", type="datetime", nullable=true)
     */
    protected $discontinued;

    /**
     * @var \DateTime $timestamp
     *
     * Gedmo\Timestampable(on={"create", "update"})
     * ORM\Column(name="stmTimestamp", type="datetime")
     */
    protected $timestamp;


    /**
     * @ORM\Column(name="intStock", type="integer", nullable=false)
     */
    protected $stock;

    /**
     * @ORM\Column(name="dblCost", type="decimal", precision=15, scale=2, nullable=false)
     */
    protected $cost;

    public function __construct($code, $name, $description, $stock, $cost, $discontinued)
    {
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->stock = $stock;
        $this->cost = $cost;
        if($discontinued){
            $this->discontinued = new \DateTime();
        }
        $this->added = new \DateTime();

    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Stock
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Stock
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Stock
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * @param \DateTime $added
     *
     * @return Stock
     */
    public function setAdded($added)
    {
        $this->added = $added;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDiscontinued()
    {
        return $this->discontinued;
    }

    /**
     * @param \DateTime $discontinued
     *
     * @return Stock
     */
    public function setDiscontinued($discontinued)
    {
        $this->discontinued = $discontinued;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     *
     * @return Stock
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param integer $stock
     *
     * @return Stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return double
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param double $cost
     *
     * @return Stock
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }
}
