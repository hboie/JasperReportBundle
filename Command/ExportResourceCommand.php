<?php

namespace Hboie\JasperReportBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Hboie\JasperReportBundle\ImportExportService;

use Jaspersoft\Dto\Resource\Resource;

class ExportResourceCommand extends Command
{
    /**
     * @var ImportExportService $exportService
     */
    private $exportService;

    public function __construct(ImportExportService $importExportService)
    {
        $this->exportService = $importExportService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('jasper:export:resource')
            ->setDescription('Export Resource from Jasper-Server')
            ->addArgument('uri', InputArgument::REQUIRED, 'uri of resource')
            ->addArgument('filename', InputArgument::OPTIONAL, 'filename of output');   }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $uri = null;
        $filename = "export";

        if ( $input->getArgument('uri') != "" ) {
            $uri = $input->getArgument('uri');
        } else {
            return Command::FAILURE;
        }

        if ( $input->getArgument('filename') != "" ) {
            $filename = $input->getArgument('filename');
        }
        $this->exportService->exportResource($uri, $filename);

        return Command::SUCCESS;
    }
}