<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScholenAttr
 *
 * @ORM\Table(name="scholen_attr", indexes={@ORM\Index(name="schoolId", columns={"schoolId"}), @ORM\Index(name="attr_id", columns={"attr_id"})})
 * @ORM\Entity
 */
class ScholenAttr
{
    /**
     * @var integer
     *
     * @ORM\Column(name="schoolId", type="integer", nullable=true)
     */
    private $schoolid;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="attr_id", type="integer", nullable=true)
     */
    private $attrId;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    
    

    /**
     * Set schoolid
     *
     * @param integer $schoolid
     *
     * @return ScholenAttr
     */
    public function setSchoolid($schoolid)
    {
        $this->schoolid = $schoolid;

        return $this;
    }

    /**
     * Get schoolid
     *
     * @return integer
     */
    public function getSchoolid()
    {
        return $this->schoolid;
    }

    /**
     * Set attrId
     *
     * @param integer $attrId
     *
     * @return ScholenAttr
     */
    public function setAttrId($attrId)
    {
        $this->attrId = $attrId;

        return $this;
    }

    /**
     * Get attrId
     *
     * @return integer
     */
    public function getAttrId()
    {
        return $this->attrId;
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
