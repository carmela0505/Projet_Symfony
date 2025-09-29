<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pays
 *
 * @ORM\Table(name="pays", indexes={@ORM\Index(name="FK_PAYS_CONTINENT", columns={"ID_CONTINENT"})})
 * @ORM\Entity(repositoryClass="App\Repository\PaysRepository")
 */
class Pays
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PAYS", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPays;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_PAYS", type="string", length=40, nullable=false)
     */
    private $nomPays;

    /**
     * @var \Continent|null
     *
     * @ORM\ManyToOne(targetEntity="Continent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CONTINENT", referencedColumnName="ID_CONTINENT")
     * })
     */
    private $idContinent;

    public function getIdPays(): ?int
    {
        return $this->idPays;
    }

    public function getNomPays(): ?string
    {
        return $this->nomPays;
    }

    public function setNomPays(string $nomPays): static
    {
        $this->nomPays = $nomPays;

        return $this;
    }

    public function getIdContinent(): ?Continent
    {
        return $this->idContinent;
    }

    public function setIdContinent(?Continent $idContinent): static
    {
        $this->idContinent = $idContinent;

        return $this;
    }
    
    public  function getNomContinent() :?string
    {
     if($this->idContinent == null){
         return "non renseigné";
     }else{
         return $this->idContinent->getNomContinent();
     }    
    }

    public function __toString()
    {
        return $this->nomPays;
    }

}
