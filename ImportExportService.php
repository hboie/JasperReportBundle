<?php

namespace Hboie\JasperReportBundle;

use Jaspersoft\Dto\ImportExport\ExportTask;
use Jaspersoft\Dto\ImportExport\ImportTask;
use Jaspersoft\Dto\ImportExport\TaskState;
use Symfony\Component\Filesystem\Filesystem;

class ImportExportService
{
    /**
     * @var \Jaspersoft\Service\ReportService $jaserReportService
     */
    private $jasperImportExportService;

    /**
     * ImportExportService constructor.
     * @param \Jaspersoft\Service\ImportExportService $importExportService
     */
    public function __construct(\Jaspersoft\Service\ImportExportService $importExportService)
    {
        $this->jasperImportExportService = $importExportService;
    }

    /**
     * Begin an export task
     *
     * @param \Jaspersoft\Dto\ImportExport\ExportTask $exportTask
     * @return \Jaspersoft\Dto\ImportExport\TaskState
     */
    public function startExportTask(ExportTask $exportTask)
    {
        return $this->jasperImportExportService->startExportTask($exportTask);
    }

    /**
     * Retrieve the state of your export request
     *
     * @param int|string $id task ID
     * @return \Jaspersoft\Dto\ImportExport\TaskState
     */
    public function getExportState($id)
    {
        return $this->getExportState($id);
    }

    /**
     * Begin an import task
     *
     * @param \Jaspersoft\Dto\Importexport\ImportTask $importTask
     * @param string $file_data Raw binary data of import zip
     * @return \Jaspersoft\Dto\ImportExport\TaskState
     */
    public function startImportTask(ImportTask $importTask, $file_data)
    {
        return $this->jasperImportExportService->startImportTask($importTask, $file_data);
    }

    /**
     * Obtain the state of an ongoing import task
     *
     * @param int|string $id
     * @return \Jaspersoft\Dto\ImportExport\TaskState
     */
    public function getImportState($id)
    {
        return $this->jasperImportExportService->getImportState($id);
    }

    /**
     * export resource from jasper server
     *
     * @param $uri
     * @param string $filename
     * @param boolean $skipDependentResources
     * @param int $refreshSec
     */
    public function exportResource($uri, $filename = "export", $skipDependentResources = false,
                                   $refreshSec = 3, $silent = true)
    {
        /** @var ExportTask $exportTask */
        $exportTask = new ExportTask();

        array_push($exportTask->uris, $uri );

        if ( $skipDependentResources ) {
            array_push($exportTask->parameters, "skip-dependent-resources" );
        }

        /** @var TaskState $taskState */
        $taskState = $this->jasperImportExportService->startExportTask($exportTask);

        if ( ! $silent ) {
            echo $taskState->message . "\n";
        }

        $decline = true;
        while ($decline) {
            $taskState = $this->jasperImportExportService->getExportState($taskState->id);
            if ($taskState->phase == "finished") {
                if ( ! $silent ) {
                    echo $taskState->message . "\n";
                }
                $decline = false;
            } else {
                sleep($refreshSec);
            }
        }

        $exportFilename = $filename;
        $ext = pathinfo($exportFilename, PATHINFO_EXTENSION);

        if ( $ext != 'zip') {
            $exportFilename .= '.zip';
        }

        $f = fopen($exportFilename, 'w');
        $data = $this->jasperImportExportService->fetchExport($taskState->id);
        fwrite($f, $data);
        fclose($f);
    }

    /**
     * import resource from file to jasper server
     *
     * @param string $filename
     * @param bool $includebrokenDependencies
     * @param int $refreshSec
     */
    public function importResource($filename = "export", $includebrokenDependencies = false,
                                   $refreshSec = 3, $silent = true)
    {
        /** @var ImportTask $importTask */
        $importTask = new ImportTask();

        $importTask->update = true;
        $importTask->includeAccessEvents = false;
        $importTask->includeAuditEvents = false;
        $importTask->includeMonitoringEvents = false;
        $importTask->includeServerSettings = false;

        if ( $includebrokenDependencies ) {
            $importTask->brokenDependencies = "include";
        }

        /** @var TaskState $taskState */
        $taskState = $this->jasperImportExportService->startImportTask($importTask, file_get_contents($filename));

        if ( ! $silent ) {
            echo $taskState->message . "\n";
        }

        $decline = true;
        while ($decline) {
            $taskState = $this->jasperImportExportService->getImportState($taskState->id);
            if ($taskState->phase == "finished") {
                if ( ! $silent ) {
                    echo $taskState->message . "\n";
                }
                $decline = false;
            } else {
                sleep($refreshSec);
            }
        }
    }
}