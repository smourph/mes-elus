<?php

namespace App\Entity\Datagouv\Acteur;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EtatCivil.
 *
 * @ORM\Table(name="acteur_etatcivil")
 * @ORM\Entity(repositoryClass="App\Repository\Datagouv\Acteur\EtatCivilRepository")
 */
class EtatCivil
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Ident
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Datagouv\Acteur\Ident", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="ident_id", referencedColumnName="id", nullable=false)
     */
    private $ident;

    /**
     * @var InfoNaissance
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Datagouv\Acteur\InfoNaissance", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="infoNaissance_id", referencedColumnName="id", nullable=false)
     */
    private $infoNaissance;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="dateDeces", type="date", nullable=true)
     */
    private $dateDeces;

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdent(): Ident
    {
        return $this->ident;
    }

    public function setIdent(Ident $ident): EtatCivil
    {
        $this->ident = $ident;

        return $this;
    }

    public function getInfoNaissance(): InfoNaissance
    {
        return $this->infoNaissance;
    }

    public function setInfoNaissance(InfoNaissance $infoNaissance): EtatCivil
    {
        $this->infoNaissance = $infoNaissance;

        return $this;
    }

    public function getDateDeces(): ?DateTime
    {
        return $this->dateDeces;
    }

    public function setDateDeces(?DateTime $dateDeces): EtatCivil
    {
        $this->dateDeces = $dateDeces;

        return $this;
    }
}
