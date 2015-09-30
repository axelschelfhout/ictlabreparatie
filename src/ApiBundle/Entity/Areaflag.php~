<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Areaflag
 *
 * @ORM\Table(name="areaflag")
 * @ORM\Entity
 */
class Areaflag
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="areaflagId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $areaflagid;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return Areaflag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get areaflagid
     *
     * @return integer
     */
    public function getAreaflagid()
    {
        return $this->areaflagid;
    }
}
