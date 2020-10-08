<?php

namespace Hboie\JasperReportBundle;

class RepositoryService
{
    /**
     * @var \Jaspersoft\Service\RepositoryService $jaserRepositoryService
     */
    private $jaserRepositoryService;

    /**
     * RepositoryService constructor.
     * @param \Jaspersoft\Service\RepositoryService $repositoryService
     */
    public function __construct(\Jaspersoft\Service\RepositoryService $repositoryService)
    {
        $this->jaserRepositoryService = $repositoryService;
    }

    /**
     * Search repository by criteria
     *
     * @param \Jaspersoft\Service\Criteria\RepositorySearchCriteria $criteria
     * @return \Jaspersoft\Service\Result\SearchResourcesResult
     */
    public function searchResources(\Jaspersoft\Service\Criteria\RepositorySearchCriteria $criteria = null)
    {
        return $this->jaserRepositoryService->searchResources($criteria);
    }

    /**
     * Get resource by URI
     *
     * @param string $uri
     * @param bool $expanded Return subresources as definitions and not references?
     * @return \Jaspersoft\Dto\Resource\Resource
     */
    public function getResource($uri, $expanded = false)
    {
        return $this->jaserRepositoryService->getResource($uri, $expanded);
    }

    /**
     * Obtain the raw binary data of a file resource stored on the server (e.x: image)
     *
     * @param \Jaspersoft\Dto\Resource\File $file
     * @return string
     */
    public function getBinaryFileData(\Jaspersoft\Dto\Resource\File $file)
    {
        return $this->jaserRepositoryService->getBinaryFileData($file);
    }

    /**
     * Create a resource
     *
     * Note: Resources can be placed at arbitrary locations, or in a folder. Thus, you must set EITHER $parentFolder
     * OR the uri parameter of the Resource used in the first argument.
     *
     * @param \Jaspersoft\Dto\Resource\Resource $resource Resource object fully describing new resource
     * @param string $parentFolder folder in which the resource should be created
     * @param bool $createFolders Create folders in the path that may not exist?
     * @throws \Exception
     * @return \Jaspersoft\Dto\Resource\Resource
     */
    public function createResource(\Jaspersoft\Dto\Resource\Resource $resource, $parentFolder = null, $createFolders = true)
    {
        return $this->jaserRepositoryService->createResource($resource, $parentFolder, $createFolders);
    }

    /**
     * Update a resource
     *
     * @param \Jaspersoft\Dto\Resource\Resource $resource Resource object fully describing updated resource
     * @param boolean $overwrite Replace existing resource even if type differs?
     * @return \Jaspersoft\Dto\Resource\Resource
     */
    public function updateResource(\Jaspersoft\Dto\Resource\Resource $resource, $overwrite = false)
    {
        return $this->jaserRepositoryService->updateResource($resource, $overwrite);
    }

    /**
     * Update a file on the server by supplying binary data
     *
     * @param \Jaspersoft\Dto\Resource\File $resource A resource descriptor for the File
     * @param string $binaryData The binary data of the file to update
     * @return \Jaspersoft\Dto\Resource\Resource
     */
    public function updateFileResource(\Jaspersoft\Dto\Resource\File $resource, $binaryData)
    {
        return $this->jaserRepositoryService->updateFileResource($resource, $binaryData);
    }
}
