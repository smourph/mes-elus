<?php

namespace App\Command;

use App\Entity\Datagouv\Acteur\Acteur;
use App\Service\Utils\EntitiesImporterInterface;
use App\Service\Utils\EntitiesSerializerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;

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

    /** @var EntitiesSerializerInterface */
    private $entitiesSerializer;

    /** @var EntitiesImporterInterface */
    private $entitiesImporter;

    /** @var LoggerInterface */
    private $logger;

    /** @var bool */
    private $debug = false;

    /**
     * ImportDataCommand constructor.
     */
    public function __construct(
        ParameterBagInterface $parameterBag,
        EntitiesSerializerInterface $entitiesSerializer,
        EntitiesImporterInterface $entitiesImporter
    ) {
        $this->parameterBag = $parameterBag;
        $this->entitiesSerializer = $entitiesSerializer;
        $this->entitiesImporter = $entitiesImporter;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('api:import')
            ->setDescription('Import API entities')
            ->setHelp('This command import entities from json files into doctrine schema')
            ->addOption(
                'debug',
                null,
                InputOption::VALUE_NONE,
                'Enable debug mode'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        // Get option value
        $this->debug = $input->getOption('debug');

        // Instantiate the logger with log options
        $logLevelMap = $this->debug
            ? array_merge(self::LOG_VERBOSITY_LEVEL_MAP, self::DEBUG_VERBOSITY_LEVEL_MAP)
            : self::LOG_VERBOSITY_LEVEL_MAP;
        $this->logger = new ConsoleLogger($output, $logLevelMap);

        // Use the logger in Utils services
        $this->entitiesSerializer->setLogger($this->logger);
        $this->entitiesImporter->setLogger($this->logger);

        try {
            $start = new \DateTime();
            $this->logger->notice('Start: '.$start->format('d-m-Y G:i:s'));

            $this->processImportationFromDataFile();

            $end = new \DateTime();
            $this->logger->notice('End: '.$end->format('d-m-Y G:i:s'));
            $this->logger->notice('Script running in : '.$end->diff($start)->format('%s.%f').' seconds');
        } catch (\Exception $e) {
            $this->logger->error(get_class($e).': '.$e->getMessage());
            $this->logger->error($e->getTraceAsString());
        }
    }

    protected function processImportationFromDataFile(): void
    {
        foreach (self::CLASSES_TO_IMPORT as $filesDirnameParam => $classNames) {
            $this->logger->info('Import "'.$filesDirnameParam.'" files');

            $fileDir = $this->parameterBag->get('data_file.'.$filesDirnameParam);

            $finder = new Finder();
            $finder->files()->in($fileDir);

            if ($finder->hasResults()) {
                foreach ($finder as $file) {
                    $filePath = $file->getRealPath();
                    $fileContents = file_get_contents($filePath);
                    foreach ($classNames as $className) {
                        $this->entitiesImporter->store(
                            $this->entitiesSerializer->extractFromJson($fileContents, $className),
                            $className
                        );
                        die();
                    }
                }
            }
        }
    }
}
