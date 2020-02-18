<?php

namespace Hboie\JasperReportBundle;

use Jaspersoft\Client\Client;
use Hboie\JasperReportBundle\ReportService;

class Factory
{
    /**
     * @var \Jaspersoft\Client\ $report_client
     */
    private $report_client;

    /**
     * @var ReportService
     */
    private $report_service;

    public function createClient($config)
    {
        $server_url = $config['host'];
        $username = $config['username'];
        $password = $config['password'];
        $org_id = $config['org_id'];

        $this->report_client = new Client($server_url, $username, $password, $org_id);
    }

    /**
     * @return \Jaspersoft\Client\|Client
     */
    public function getClient()
    {
        return $this->report_client;
    }

    public function getReportService()
    {
        if ( ! isset( $this->report_service ) )
        {
            $this->report_service = new ReportService( $this->report_client->reportService() );
        }
        return $this->report_service;
    }
}