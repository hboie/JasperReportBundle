<?php

namespace Hboie\JasperReportBundle;

class ImportExportService
{
    /**
     * @var \Jaspersoft\Service\ReportService $jaserReportService
     */
    private $jaserImportExportService;

    /**
     * ImportExportService constructor.
     * @param \Jaspersoft\Service\ImportExportService $importExportService
     */
    public function __construct(\Jaspersoft\Service\ImportExportService $importExportService)
    {
        $this->jaserImportExportService = $importExportService;
    }

    /**
     * Begin an export task
     *
     * @param \Jaspersoft\Dto\ImportExport\ExportTask $exportTask
     * @return \Jaspersoft\Dto\ImportExport\TaskState
     */
    public function startExportTask(ExportTask $exportTask)
    {
        return $this->jaserImportExportService->startExportTask($exportTask);
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
        return $this->jaserImportExportService->startImportTask($importTask, $file_data);
    }

    /**
     * Obtain the state of an ongoing import task
     *
     * @param int|string $id
     * @return \Jaspersoft\Dto\ImportExport\TaskState
     */
    public function getImportState($id)
    {
        return $this->jaserImportExportService->getImportState($id);
    }
}
