<?php

namespace App\Command;

use App\Entity\Datagouv\Acteur\Acteur;
use App\Entity\Meselus\Actor;
use App\Service\Utils\DataConverter;
use App\Service\Utils\DataImporter;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class ImportDataCommand.
 */
class ImportDataCommand extends Command
{
    private const BATCH_SIZE = 100;

    private const CLASSES_TO_IMPORT = [
        'deputes_actifs' => [
            Acteur::class,
        ],
    ];
    private const CLASSES_TO_CONVERT = [
        Acteur::class => Actor::class,
    ];

    /** @var ParameterBagInterface */
    private $parameterBag;

    /** @var RegistryInterface */
    private $registry;

    /** @var DataImporter */
    private $dataImporter;

    /** @var DataConverter */
    private $dataConverter;

    /**
     * ImportDataCommand constructor.
     */
    public function __construct(
        ParameterBagInterface $parameterBag,
        RegistryInterface $registry,
        DataImporter $dataImporter,
        DataConverter $dataConverter
    ) {
        $this->parameterBag = $parameterBag;
        $this->registry = $registry;
        $this->dataImporter = $dataImporter;
        $this->dataConverter = $dataConverter;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('api:import')
            ->setDescription('Import entities for API');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        try {
            $now = new \DateTime();
            $output->writeln('<info>Start : '.$now->format('d-m-Y G:i:s').'</info>');

            foreach (self::CLASSES_TO_IMPORT as $filenameParam => $classNames) {
                foreach ($classNames as $className) {
                    $this->importData($output, $className, $filenameParam);
                }
            }

            foreach (self::CLASSES_TO_CONVERT as $classFrom => $classTo) {
                $this->convertData($output, $classFrom, $classTo);
            }

            $now = new \DateTime();
            $output->writeln('<info>End : '.$now->format('d-m-Y G:i:s').'</info>');
        } catch (\Exception $e) {
            $output->writeln('<error>Exception: '.$e->getMessage().'</error>');
        }
    }

    /**
     * @throws \Exception
     */
    protected function importData(OutputInterface $output, string $className, string $filenameParam): void
    {
        // Define services
        $em = $this->registry->getEntityManager('full_api');

        // Define filename
        $fileName = $this->parameterBag->get('data_file.'.$filenameParam);

        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger();

        $output->writeln('<info>Import new data: "'.$className.'"</info>');

        // Begin an SQL transaction
        $em->getConnection()->beginTransaction();

        try {
            // Remove all previous entities
            $output->write('<comment>Purge all previous data</comment>');
            $entities = $em->getRepository($className)->findAll();
            foreach ($entities as $entity) {
                $em->remove($entity);
            }
            $em->flush();
            $em->clear();
            $output->writeln('<comment>... OK!</comment>');

            // Get data from json
            $entities = $this->dataImporter->extractEntitiesFromJsonFile($fileName, $className);
            unset($fileName);

            // Initialize progress bar
            $size = count($entities);
            $progress = new ProgressBar($output, $size);

            $output->write('<comment>');
            $progress->start();
            $output->writeln('</comment>');

            $i = 1;
            foreach ($entities as $entity) {
                // Store entity in database
                $em->persist($entity);

                if (0 === ($i % self::BATCH_SIZE)) {
                    $em->flush();
                    $em->clear();

                    // Advance the progress bar each 'batchSize' elements
                    $output->write('<comment>');
                    $progress->advance(self::BATCH_SIZE);
                    $output->writeln(' of entities imported</comment>');
                }
                ++$i;
            }

            $em->flush();
            $em->clear();

            $output->write('<comment>');
            $progress->finish();
            $output->writeln('</comment>');

            // Commit to end the SQL transaction
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            // Rollback to previous data then close transaction
            $em->getConnection()->rollBack();
            $em->close();

            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    protected function convertData(OutputInterface $output, string $classFrom, string $classTo): void
    {
        // Define services and filename
        $dataConverter = $this->dataConverter;

        // Get Entity Managers
        $em = $this->registry->getEntityManager('default');
        $emFullApi = $this->registry->getEntityManager('full_api');

        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger();

        $output->writeln('<info>Convert new data: "'.$classTo.'" from "'.$classFrom.'"</info>');

        // Begin an SQL transaction
        $em->getConnection()->beginTransaction();

        try {
            // Remove all previous entities
            $output->write('<comment>Purge all previous data</comment>');
            $entitiesFrom = $em->getRepository($classTo)->findAll();
            foreach ($entitiesFrom as $entityFrom) {
                $em->remove($entityFrom);
            }
            $em->flush();
            $em->clear();
            $output->writeln('<comment>... OK!</comment>');

            // Fetch data to convert
            $entitiesFrom = $emFullApi->getRepository($classFrom)->findAll();
            unset($emFullApi);

            // Initialize progress bar
            $size = count($entitiesFrom);
            $progress = new ProgressBar($output, $size);

            $output->write('<comment>');
            $progress->start();
            $output->writeln('</comment>');

            $i = 1;
            foreach ($entitiesFrom as $entityFrom) {
                // Convert entities
                if (Actor::class === $classTo) {
                    // Store entity in database
                    $em->persist($dataConverter->convertActor($entityFrom));
                }

                if (0 === ($i % self::BATCH_SIZE)) {
                    $em->flush();
                    $em->clear();

                    // Advance the progress bar each 'batchSize' elements
                    $output->write('<comment>');
                    $progress->advance(self::BATCH_SIZE);
                    $output->writeln(' of entities imported</comment>');
                }
                ++$i;
            }

            $em->flush();
            $em->clear();

            $output->write('<comment>');
            $progress->finish();
            $output->writeln('</comment>');

            // Commit to end the SQL transaction
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            // Rollback to previous data then close transaction
            $em->getConnection()->rollBack();
            $em->close();

            throw $e;
        }
    }
}
