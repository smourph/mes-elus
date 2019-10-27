<?php

namespace App\Command;

use App\Entity\AbstractApiEntity;
use App\Entity\Datagouv\Acteur\Acteur;
use App\Service\Utils\EntityImporterInterface;
use DateTime;
use Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ImportDataCommand.
 */
class ImportDataCommand extends Command
{
    private const LOG_VERBOSITY_LEVEL_MAP = [
        LogLevel::NOTICE => OutputInterface::VERBOSITY_NORMAL,
        LogLevel::INFO => OutputInterface::VERBOSITY_NORMAL,
    ];
    private const DEBUG_VERBOSITY_LEVEL_MAP = [
        LogLevel::DEBUG => OutputInterface::VERBOSITY_NORMAL,
    ];

    private const CLASSES_TO_IMPORT = [
        'deputes_actifs' => [
            Acteur::class,
        ],
    ];

    /** @var ParameterBagInterface */
    private $parameterBag;

    /** @var SerializerInterface */
    private $serializer;

    /** @var EntityImporterInterface */
    private $entityImporter;

    /** @var LoggerInterface */
    private $logger;

    /** @var bool */
    private $debug = false;

    /**
     * ImportDataCommand constructor.
     */
    public function __construct(
        ParameterBagInterface $parameterBag,
        SerializerInterface $serializer,
        EntityImporterInterface $entitiesImporter
    ) {
        $this->parameterBag = $parameterBag;
        $this->serializer = $serializer;
        $this->entityImporter = $entitiesImporter;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('api:import')
            ->setDescription('Import API entities')
            ->setHelp('This command import entities from json files into doctrine schema')
            ->addOption('debug', 'd', InputOption::VALUE_NONE, 'Enable debug mode');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        // Get option values
        $this->debug = $input->getOption('debug');

        // Instantiate the logger with log options
        $logLevelMap = $this->debug
            ? array_merge(self::LOG_VERBOSITY_LEVEL_MAP, self::DEBUG_VERBOSITY_LEVEL_MAP)
            : self::LOG_VERBOSITY_LEVEL_MAP;
        $this->logger = new ConsoleLogger($output, $logLevelMap);

        // Pass the logger to the Utils service
        $this->entityImporter->setLogger($this->logger);

        try {
            $start = new DateTime();
            $this->logger->notice('Start: '.$start->format('d-m-Y G:i:s'));

            $this->processImportationFromDataFiles();

            $end = new DateTime();
            $this->logger->notice('End: '.$end->format('d-m-Y G:i:s'));
            $this->logger->notice('Script running in : '.$end->diff($start)->format('%s.%f').' seconds');
        } catch (Exception $e) {
            $this->logger->error(get_class($e).': '.$e->getMessage());
            $this->logger->error($e->getTraceAsString());
        }
    }

    protected function processImportationFromDataFiles(): void
    {
        foreach (self::CLASSES_TO_IMPORT as $filesDirnameParam => $classNames) {
            $this->logger->info('Import "'.$filesDirnameParam.'" files');

            $fileDir = $this->parameterBag->get('data_file.'.$filesDirnameParam);

            $finder = new Finder();
            $finder->files()->in($fileDir);

            foreach ($finder as $file) {
                $filePath = $file->getRealPath();
                $fileContents = file_get_contents($filePath);
                foreach ($classNames as $className) {
                    /** @var AbstractApiEntity $entity */
                    $entity = $this->serializer->deserialize($fileContents, $className, 'json');
                    $this->entityImporter->store($entity, $className);
                }
            }
        }
    }
}
