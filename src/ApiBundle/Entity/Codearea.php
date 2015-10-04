<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Codearea
 *
 * @ORM\Table(name="codearea", indexes={@ORM\Index(name="fk_geo_code_idx", columns={"geoId"}), @ORM\Index(name="fk_areaflag_idx", columns={"areaflagId"})})
 * @ORM\Entity
 */
class Codearea
{
    /**
     * @var integer
     *
     * @ORM\Column(name="geoId", type="integer", nullable=false)
     */
    private $geoid;

    /**
     * @var integer
     *
     * @ORM\Column(name="areaflagId", type="integer", nullable=false)
     */
    private $areaflagid;

    /**
     * @var string
     *
     * @ORM\Column(name="codeareaId", type="string", length=30)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeareaid;



    /**
     * Set geoid
     *
     * @param integer $geoid
     *
     * @return Codearea
     */
    public function setGeoid($geoid)
    {
        $this->geoid = $geoid;

        return $this;
    }

    /**
     * Get geoid
     *
     * @return integer
     */
    public function getGeoid()
    {
        return $this->geoid;
    }

    /**
     * Set areaflagid
     *
     * @param integer $areaflagid
     *
     * @return Codearea
     */
    public function setAreaflagid($areaflagid)
    {
        $this->areaflagid = $areaflagid;

        return $this;
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

    /**
     * Get codeareaid
     *
     * @return string
     */
    public function getCodeareaid()
    {
        return $this->codeareaid;
    }
}
