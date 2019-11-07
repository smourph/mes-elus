<?php

namespace App\Entity\Datagouv\Acteur;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Acteur.
 *
 * @ORM\Table(name="acteur")
 * @ORM\Entity(repositoryClass="App\Repository\Datagouv\Acteur\ActeurRepository")
 */
class Acteur
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="uid", type="string", length=15)
     */
    private $uid;

    /**
     * @var EtatCivil
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Datagouv\Acteur\EtatCivil", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="etatCivil_id", referencedColumnName="id", nullable=false)
     */
    private $etatCivil;

    /**
     * @var Profession
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Datagouv\Acteur\Profession", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="profession_id", referencedColumnName="id", nullable=false)
     */
    private $profession;

    public function getUid(): string
    {
        return $this->uid;
    }

    public function setUid(string $uid): Acteur
    {
        $this->uid = $uid;

        return $this;
    }

    public function getEtatCivil(): EtatCivil
    {
        return $this->etatCivil;
    }

    public function setEtatCivil(EtatCivil $etatCivil): Acteur
    {
        $this->etatCivil = $etatCivil;

        return $this;
    }

    public function getProfession(): Profession
    {
        return $this->profession;
    }

    public function setProfession(Profession $profession): Acteur
    {
        $this->profession = $profession;

        return $this;
    }
}
