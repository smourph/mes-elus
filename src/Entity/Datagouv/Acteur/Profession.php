<?php

namespace App\Entity\Datagouv\Acteur;

use App\Entity\AbstractApiEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Profession.
 *
 * @ORM\Table(name="acteur_profession")
 * @ORM\Entity(repositoryClass="App\Repository\Datagouv\Acteur\ProfessionRepository")
 */
class Profession implements AbstractApiEntity
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
     * @var string|null
     *
     * @ORM\Column(name="libelleCourant", type="string", length=255, nullable=true)
     */
    private $libelleCourant;

    /**
     * @var SocProcInsee
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Datagouv\Acteur\SocProcInsee", cascade={"persist", "merge", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="socProcINSEE_id", referencedColumnName="id", nullable=false)
     */
    private $socProcINSEE;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLibelleCourant(): ?string
    {
        return $this->libelleCourant;
    }

    public function setLibelleCourant(?string $libelleCourant): Profession
    {
        $this->libelleCourant = $libelleCourant;

        return $this;
    }

    public function getSocProcINSEE(): SocProcInsee
    {
        return $this->socProcINSEE;
    }

    public function setSocProcINSEE(SocProcInsee $socProcINSEE): Profession
    {
        $this->socProcINSEE = $socProcINSEE;

        return $this;
    }

    public function update(AbstractApiEntity $new): Profession
    {
        $this->setSocProcINSEE($this->getSocProcINSEE()->update($new->getSocProcINSEE()))
            ->setLibelleCourant($new->getLibelleCourant());

        return $this;
    }
}
