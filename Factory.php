<?php

namespace hboie\JasperReportBundle;

use Jaspersoft\Client\Client;

class Factory
{
    /**
     * @var \Jaspersoft\Client\ $report_client
     */
    private $report_client;

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
        return $this->report_client->reportService();
    }
}