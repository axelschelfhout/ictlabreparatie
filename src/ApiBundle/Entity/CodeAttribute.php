<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CodeAttribute
 *
 * @ORM\Table(name="code_attribute", indexes={@ORM\Index(name="fk_codeattribute_atributeId_idx", columns={"attributeId"})})
 * @ORM\Entity
 */
class CodeAttribute
{
    /**
     * @var string
     *
     * @ORM\Column(name="areacodeId", type="string", length=12)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $areacodeid;

    /**
     * @var integer
     *
     * @ORM\Column(name="attributeId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $attributeid;



    /**
     * Set areacodeid
     *
     * @param string $areacodeid
     *
     * @return CodeAttribute
     */
    public function setAreacodeid($areacodeid)
    {
        $this->areacodeid = $areacodeid;

        return $this;
    }

    /**
     * Get areacodeid
     *
     * @return string
     */
    public function getAreacodeid()
    {
        return $this->areacodeid;
    }

    /**
     * Set attributeid
     *
     * @param integer $attributeid
     *
     * @return CodeAttribute
     */
    public function setAttributeid($attributeid)
    {
        $this->attributeid = $attributeid;

        return $this;
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
