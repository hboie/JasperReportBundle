<?php

namespace Hboie\JasperReportBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Hboie\JasperReportBundle\ImportExportService;

use Jaspersoft\Dto\Resource\Resource;

class ImportResourceCommand extends Command
{
    /**
     * @var ImportExportService $importService
     */
    private $importService;

    public function __construct(ImportExportService $importExportService)
    {
        $this->importService = $importExportService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('jasper:import:resource')
            ->setDescription('Import Resource from Jasper-Server')
            ->addArgument('filename', InputArgument::REQUIRED, 'filename')
            ->addArgument('includebrokenDependencies', InputArgument::OPTIONAL,
                'include broken dependencies');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = null;
        $includebrokenDependencies = false;

        if ( $input->getArgument('filename') != "" ) {
            $filename = $input->getArgument('filename');
        } else {
            return Command::FAILURE;
        }

        if ( $input->getArgument('includebrokenDependencies') == "true" ) {
            $includebrokenDependencies = true;
        }

        $this->importService->importResource($filename, $includebrokenDependencies, 2, false);

        return Command::SUCCESS;
    }
}