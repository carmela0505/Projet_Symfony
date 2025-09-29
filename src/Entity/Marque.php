<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marque
 *
 * @ORM\Table(name="marque", indexes={@ORM\Index(name="FK_MARQUE_PAYS", columns={"ID_PAYS"}), @ORM\Index(name="FK_MARQUE_FABRICANT", columns={"ID_FABRICANT"})})
 * @ORM\Entity(repositoryClass="App\Repository\MarqueRepository")
 */
class Marque
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_MARQUE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMarque;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_MARQUE", type="string", length=40, nullable=false)
     */
    private $nomMarque;

    /**
     * @var \Fabricant|null
     *
     * @ORM\ManyToOne(targetEntity="Fabricant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_FABRICANT", referencedColumnName="ID_FABRICANT")
     * })
     */
    private $idFabricant;

    /**
     * @var \Pays|null
     *
     * @ORM\ManyToOne(targetEntity="Pays")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_PAYS", referencedColumnName="ID_PAYS")
     * })
     */
    private $idPays;

    public function getIdMarque(): ?int
    {
        return $this->idMarque;
    }

    public function getNomMarque(): ?string
    {
        return $this->nomMarque;
    }

    public function setNomMarque(string $nomMarque): static
    {
        $this->nomMarque = $nomMarque;

        return $this;
    }

    public function getIdFabricant(): ?Fabricant
    {
        return $this->idFabricant;
    }

    public function setIdFabricant(?Fabricant $idFabricant): static
    {
        $this->idFabricant = $idFabricant;

        return $this;
    }

     
   public  function getNomFabricant() :?string
   {
    if($this->idFabricant == null){
        return "non renseigné";
    }else{
        return $this->idFabricant->getNomFabricant();
    }    
   }

   public  function getNomPays() :?string
   {

    if($this->idPays == null){
        return "non renseigné";
    }else{
        return $this->idPays->getNomPays();
    }
    
   }

    public function getIdPays(): ?Pays
    {
        return $this->idPays;
    }

    public function setIdPays(?Pays $idPays): static
    {
        $this->idPays = $idPays;

        return $this;
    }

    public function __toString()
    {
        return $this->nomMarque;
    }
}
