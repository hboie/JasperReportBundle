<?php

namespace Hboie\JasperReportBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Hboie\JasperReportBundle\RepositoryService;

use Jaspersoft\Service\Criteria\RepositorySearchCriteria;
use Jaspersoft\Service\Result\SearchResourcesResult;
use Jaspersoft\Dto\Resource\ResourceLookup;

class SearchRepositoryCommand extends Command
{
    /**
     * @var RepositoryService $repositoryService
     */
    private $repositoryService;

    public function __construct(RepositoryService $repositoryService)
    {
        $this->repositoryService = $repositoryService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('jasper:repository:search')
            ->setDescription('Search Jasper-Report Repository')
            ->addArgument('criteria', InputArgument::OPTIONAL, 'search citeria')
            ->addArgument('detail', InputArgument::OPTIONAL, 'show full details');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $criteria = null;

        if ( $input->getArgument('criteria') != "" && $input->getArgument('criteria') != "null" ) {
            $criteria = new RepositorySearchCriteria();
            $criteria->q = $input->getArgument('criteria');
        }

        /** @var SearchResourcesResult $results */
        $results = $this->repositoryService->searchResources($criteria);

        foreach ($results->items as $result) {
            /** @var ResourceLookup $result */
            if ( $input->getArgument('detail') > 0 ) {
                $output->writeln( var_export($result, true) );
            } else {
                $output->writeln( $result->uri . " (" . $result->resourceType .")" );
            }
        }

        return Command::SUCCESS;
    }

}