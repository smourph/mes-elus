<?php

namespace App\Tests\Service\Utils;

use App\Entity\Datagouv\Acteur\Acteur;
use App\Entity\Datagouv\Acteur\EtatCivil;
use App\Entity\Datagouv\Acteur\Ident;
use App\Entity\Datagouv\Acteur\InfoNaissance;
use App\Entity\Datagouv\Acteur\Profession;
use App\Entity\Datagouv\Acteur\SocProcInsee;
use App\Service\Normalizer\AbstractApiEntityNormalizer;
use App\Service\Utils\EntityImporter;
use DateTime;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class EntityImporterTest extends TestCase
{
    /**
     * @var AbstractApiEntityNormalizer
     */
    private $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new AbstractApiEntityNormalizer();
    }

    /**
     * @throws ConnectionException
     */
    public function testStoreNewEntity(): void
    {
        $acteur = (new Acteur())
            ->setUid('uid1')
            ->setEtatCivil(
                (new EtatCivil())
                    ->setIdent(
                        (new Ident())
                            ->setCiv('civ1')
                            ->setPrenom('prenom1')
                            ->setNom('nom1')
                            ->setAlpha('alpha1')
                    )
                    ->setInfoNaissance(
                        (new InfoNaissance())
                            ->setDateNais(new DateTime('2000-01-01'))
                            ->setVilleNais('ville1')
                            ->setDepNais('dep1')
                            ->setPaysNais('pays1')
                    )
                    ->setDateDeces(null)
            )
            ->setProfession(
                (new Profession())
                    ->setLibelleCourant('libelle1')
                    ->setSocProcINSEE(
                        (new SocProcInsee())
                            ->setCatSocPro('cat1')
                            ->setFamSocPro('fam1')
                    )
            );

        $acteurRepository = $this->createMock(ObjectRepository::class);
        $acteurRepository->expects($this->once())
            ->method('find')
            ->with('uid1')
            ->willReturn(null);

        $connection = $this->createMock(Connection::class);
        $connection->method('getConfiguration')
            ->willReturn(new Configuration());

        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->method('getConnection')
            ->willReturn($connection);

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($acteurRepository);
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($acteur);
        $entityManager->expects($this->once())
            ->method('flush');
        $entityManager->expects($this->once())
            ->method('clear');

        $entityImporter = new EntityImporter($entityManager, $this->createMock(Logger::class));
        $entityImporter->store($acteur, Acteur::class);
    }

    /**
     * @throws ConnectionException
     */
    public function testStoreExistingEntity(): void
    {
        $oldActeur = (new Acteur())
            ->setUid('uid1')
            ->setEtatCivil(
                (new EtatCivil())
                    ->setIdent(
                        (new Ident())
                            ->setCiv('civ1')
                            ->setPrenom('prenom1')
                            ->setNom('nom1')
                            ->setAlpha('alpha1')
                    )
                    ->setInfoNaissance(
                        (new InfoNaissance())
                            ->setDateNais(new DateTime('2000-01-01'))
                            ->setVilleNais('ville1')
                            ->setDepNais('dep1')
                            ->setPaysNais('pays1')
                    )
                    ->setDateDeces(null)
            )
            ->setProfession(
                (new Profession())
                    ->setLibelleCourant('libelle1')
                    ->setSocProcINSEE(
                        (new SocProcInsee())
                            ->setCatSocPro('cat1')
                            ->setFamSocPro('fam1')
                    )
            );

        $newActeur = (new Acteur())
            ->setUid('uid1')
            ->setEtatCivil(
                (new EtatCivil())
                    ->setIdent(
                        (new Ident())
                            ->setCiv('civ2')
                            ->setPrenom('prenom2')
                            ->setNom('nom2')
                            ->setAlpha('alpha2')
                    )
                    ->setInfoNaissance(
                        (new InfoNaissance())
                            ->setDateNais(new DateTime('2000-01-02'))
                            ->setVilleNais('ville2')
                            ->setDepNais('dep2')
                            ->setPaysNais('pays2')
                    )
                    ->setDateDeces(null)
            )
            ->setProfession(
                (new Profession())
                    ->setLibelleCourant('libelle2')
                    ->setSocProcINSEE(
                        (new SocProcInsee())
                            ->setCatSocPro('cat2')
                            ->setFamSocPro('fam2')
                    )
            );

        $acteurRepository = $this->createMock(ObjectRepository::class);
        $acteurRepository->expects($this->once())
            ->method('find')
            ->with('uid1')
            ->willReturn($oldActeur);

        $connection = $this->createMock(Connection::class);
        $connection->method('getConfiguration')
            ->willReturn(new Configuration());

        $entityManager = $this->createMock(EntityManager::class);
        $entityManager->method('getConnection')
            ->willReturn($connection);

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($acteurRepository);
        $entityManager->expects($this->never())
            ->method('persist');
        $entityManager->expects($this->once())
            ->method('flush');
        $entityManager->expects($this->once())
            ->method('clear');

        $entityImporter = new EntityImporter($entityManager, $this->createMock(Logger::class));
        $entityImporter->store($newActeur, Acteur::class);
    }
}
