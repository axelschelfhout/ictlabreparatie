<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profiles
 *
 * @ORM\Table(name="profiles")
 * @ORM\Entity
 */
class Profiles
{
    /**
     * @var string
     *
     * @ORM\Column(name="SoortAanbod", type="string", length=45, nullable=true)
     */
    private $soortaanbod;

    /**
     * @var string
     *
     * @ORM\Column(name="HuisPrijsVan", type="string", length=45, nullable=true)
     */
    private $huisprijsvan;

    /**
     * @var string
     *
     * @ORM\Column(name="HuisPrijsTot", type="string", length=45, nullable=true)
     */
    private $huisprijstot;

    /**
     * @var string
     *
     * @ORM\Column(name="HeeftBalkon", type="string", length=45, nullable=true)
     */
    private $heeftbalkon;

    /**
     * @var string
     *
     * @ORM\Column(name="HeeftCv", type="string", length=45, nullable=true)
     */
    private $heeftcv;

    /**
     * @var string
     *
     * @ORM\Column(name="HeeftGarage", type="string", length=45, nullable=true)
     */
    private $heeftgarage;

    /**
     * @var string
     *
     * @ORM\Column(name="HeeftTuin", type="string", length=45, nullable=true)
     */
    private $heefttuin;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set soortaanbod
     *
     * @param string $soortaanbod
     *
     * @return Profiles
     */
    public function setSoortaanbod($soortaanbod)
    {
        $this->soortaanbod = $soortaanbod;

        return $this;
    }

    /**
     * Get soortaanbod
     *
     * @return string
     */
    public function getSoortaanbod()
    {
        return $this->soortaanbod;
    }

    /**
     * Set huisprijsvan
     *
     * @param string $huisprijsvan
     *
     * @return Profiles
     */
    public function setHuisprijsvan($huisprijsvan)
    {
        $this->huisprijsvan = $huisprijsvan;

        return $this;
    }

    /**
     * Get huisprijsvan
     *
     * @return string
     */
    public function getHuisprijsvan()
    {
        return $this->huisprijsvan;
    }

    /**
     * Set huisprijstot
     *
     * @param string $huisprijstot
     *
     * @return Profiles
     */
    public function setHuisprijstot($huisprijstot)
    {
        $this->huisprijstot = $huisprijstot;

        return $this;
    }

    /**
     * Get huisprijstot
     *
     * @return string
     */
    public function getHuisprijstot()
    {
        return $this->huisprijstot;
    }

    /**
     * Set heeftbalkon
     *
     * @param string $heeftbalkon
     *
     * @return Profiles
     */
    public function setHeeftbalkon($heeftbalkon)
    {
        $this->heeftbalkon = $heeftbalkon;

        return $this;
    }

    /**
     * Get heeftbalkon
     *
     * @return string
     */
    public function getHeeftbalkon()
    {
        return $this->heeftbalkon;
    }

    /**
     * Set heeftcv
     *
     * @param string $heeftcv
     *
     * @return Profiles
     */
    public function setHeeftcv($heeftcv)
    {
        $this->heeftcv = $heeftcv;

        return $this;
    }

    /**
     * Get heeftcv
     *
     * @return string
     */
    public function getHeeftcv()
    {
        return $this->heeftcv;
    }

    /**
     * Set heeftgarage
     *
     * @param string $heeftgarage
     *
     * @return Profiles
     */
    public function setHeeftgarage($heeftgarage)
    {
        $this->heeftgarage = $heeftgarage;

        return $this;
    }

    /**
     * Get heeftgarage
     *
     * @return string
     */
    public function getHeeftgarage()
    {
        return $this->heeftgarage;
    }

    /**
     * Set heefttuin
     *
     * @param string $heefttuin
     *
     * @return Profiles
     */
    public function setHeefttuin($heefttuin)
    {
        $this->heefttuin = $heefttuin;

        return $this;
    }

    /**
     * Get heefttuin
     *
     * @return string
     */
    public function getHeefttuin()
    {
        return $this->heefttuin;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
