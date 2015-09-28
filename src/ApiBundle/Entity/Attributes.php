<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attributes
 *
 * @ORM\Table(name="attributes", indexes={@ORM\Index(name="name_index", columns={"name", "value"}), @ORM\Index(name="fk_attributetype_idx", columns={"attributetype"})})
 * @ORM\Entity
 */
class Attributes
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
     * @ORM\Column(name="attributetype", type="integer", nullable=false)
     */
    private $attributetype;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=256, nullable=false)
     */
    private $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="attributeId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $attributeid;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return Attributes
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
     * Set attributetype
     *
     * @param integer $attributetype
     *
     * @return Attributes
     */
    public function setAttributetype($attributetype)
    {
        $this->attributetype = $attributetype;

        return $this;
    }

    /**
     * Get attributetype
     *
     * @return integer
     */
    public function getAttributetype()
    {
        return $this->attributetype;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Attributes
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get attributeid
     *
     * @return integer
     */
    public function getAttributeid()
    {
        return $this->attributeid;
    }
}
