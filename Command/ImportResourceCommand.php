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
            ->addArgument('filename', InputArgument::REQUIRED, 'filename');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = null;

        if ( $input->getArgument('filename') != "" ) {
            $filename = $input->getArgument('filename');
        } else {
            return Command::FAILURE;
        }

        $this->importService->importResource($filename);

        return Command::SUCCESS;
    }
}