<?php

namespace Ecole\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eleve
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ecole\AdminBundle\Entity\EleveRepository")
 */
class Eleve
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ecole\AdminBundle\Entity\Cursus", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cursus;
    
    
     /**
     * @ORM\ManyToOne(targetEntity="Ecole\AdminBundle\Entity\Correspondant", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $correspondant;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Eleve
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Eleve
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return Eleve
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set cursus
     *
     * @param \Ecole\AdminBundle\Entity\Cursus $cursus
     * @return Eleve
     */
    public function setCursus(\Ecole\AdminBundle\Entity\Cursus $cursus)
    {
        $this->cursus = $cursus;

        return $this;
    }

    /**
     * Get cursus
     *
     * @return \Ecole\AdminBundle\Entity\Cursus 
     */
    public function getCursus()
    {
        return $this->cursus;
    }


    /**
     * Set correspondant
     *
     * @param \Ecole\AdminBundle\Entity\Correspondant $correspondant
     * @return Eleve
     */
    public function setCorrespondant(\Ecole\AdminBundle\Entity\Correspondant $correspondant)
    {
        $this->correspondant = $correspondant;

        return $this;
    }

    /**
     * Get correspondant
     *
     * @return \Ecole\AdminBundle\Entity\Correspondant 
     */
    public function getCorrespondant()
    {
        return $this->correspondant;
    }
}
