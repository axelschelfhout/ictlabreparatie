<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attributetype
 *
 * @ORM\Table(name="attributetype")
 * @ORM\Entity
 */
class Attributetype
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="attributetypeId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $attributetypeid;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return Attributetype
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
     * Get attributetypeid
     *
     * @return integer
     */
    public function getAttributetypeid()
    {
        return $this->attributetypeid;
    }
}
