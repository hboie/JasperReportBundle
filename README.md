# JasperReportBundle

The JasperReportBundle requires jaspersoft/rest-client and provides an JasperReport-Client as service in the Symfony service container.

[Installation with Symfony Flex (4 / 5)](#installation_4_5)<br>
[Basic Usage in Symfony 4 / 5](#basic_usage_4_5)<br>
[Installation with Symfony 2 / 3](#installation_2_3)<br>
[Basic Usage in Symfony 2 / 3](#basic_usage_2_3)<br>
[Search Resource Command](#search_resource_command)<br>
[Export Resource Command](#export_resource_command)<br>
[Import Resource Command](#import_resource_command)<br>
[Copying Resources between different Servers](#copying_resources)<br>
[Additional Configuration Options](#configuration)<br>

## <a name="installation_4_5"></a>Installation with Symfony Flex (4 / 5) 

1 Add bundle to <code>composer.json</code>:
```shel
    composer require hboie/jasper_report_bundle
```
2 The Bundle will be registred automatically and by executing the recipe the configuration 
file <code>jasper-report.yaml</code>
will be created in the <code>config/packages</code> directory and the corresponding entries
in the <code>.env</code> file will be made

3 Change the standard setting in the file <code>jasper-report.yaml</code>

```yml
    hboie_jasper_report:
        host:      'http://localhost:8080/jasperserver'
        username:  '%env(HBOIE_JASPER_REPORT_USERNAME)%'
        password:  '%env(HBOIE_JASPER_REPORT_PASSWORD)%'
        org_id:    '%env(HBOIE_JASPER_REPORT_ORGID)%'
```

and in the <code>.env</code> file

```
HBOIE_JASPER_REPORT_USERNAME=jasperadmin
HBOIE_JASPER_REPORT_PASSWORD=jasperadmin
HBOIE_JASPER_REPORT_ORGID=
```

## <a name="basic_usage_4_5"></a>Basic Usage in Symfony 4 / 5

The bundle supports autowiring, so you can access the report-service directly in your controller, e.g.
```php
    use Symfony\Component\HttpFoundation\Request;
    use Hboie\JasperReportBundle\ReportService;

    public function reportAction(Request $request, ReportService $reportService)
    {
        $report = $reportService->runReport('/reports/TestReport', 'pdf');

        $response = new Response($report);
        $response->headers->set('Content-type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=Report.pdf');
        $response->headers->set('Cache-Control', 'must-revalidate');

        return $response;
    }
```

## <a name="installation_2_3"></a>Installation with Symfony 2 / 3

1 Add bundle to <code>composer.json</code>:
```shel
    composer require hboie/jasper_report_bundle
```
2 Register bundle in <code>app/AppKernel.php</code>:
```php
    $bundle = [
            ...
    new Hboie\JasperReportBundle\HboieJasperReportBundle(),
            ...
    ];
```
3 Add parameter to <code>app/config/config.yml</code>
```yml
    hboie_jasper_report:
        host:      "%jasper_host%"
        username:  "%jasper_user%"
        password:  "%jasper_password%"
        org_id:    "%jasper_org_id%"
```
4 Add a dummy configuration in <code>app/config/paramters.yml.dist</code>
```yml
    jasper_host: http://localhost:8080/jasperserver
    jasper_user: jasperadmin
    jasper_password: jasperadmin
    jasper_org_id:
```
5 Add your own configuration in <code>app/config/paramters.yml</code>

## <a name="basic_usage_2_3"></a>Basic Usage in Symfony 2 / 3

You can now access the <code>Client</code> object via the Symfony service <code>jasperreport.client</code>:
```php
    $client = $this->get('jasperreport.client');
```
or directly access the <code>ReportService</code> using the Symfony service <code>jasperreport.reportservice</code>:
```php
    $report = $this->get('jasperreport.reportservice')->runReport('/reports/TestReport', 'pdf');
```
So a controller giving back a pdf-report would look like
```php
    public function reportAction(Request $request)
    {
        $report = $this->get('jasperreport.reportservice')->runReport('/reports/TestReport', 'pdf');

        $response = new Response($report);
        $response->headers->set('Content-type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=Report.pdf');
        $response->headers->set('Cache-Control', 'must-revalidate');

        return $response;
    }
```

## <a name="search_resource_command"></a>Search Resource Command

With the <code>jasper:repository:search</code> you can search resources on the JaserReport server

```
    php bin/console jasper:repository:search <Citeria> <Detail>
```

**Criteria:** search criteria<br>
**Detail:** show details (optional)<br>
If no detail-value is given, only the uri of the resources will be listed. If an detail value greater 
than 0 is given, full data will be displayed.
 
## <a name="export_resource_command"></a>Export Resource Command

With the <code>jasper:export:resource</code> command, a given resource will be exported 
from the JasperServer and downloaded to an zip-archive file.

```
    php bin/console jasper:export:resource <UriOfResource> <Filename> <SkipDependentResources>
```

**UriOfResource:** uri of the resouce that should be downloaded<br>
**Filename:** filename of the local target file<br>
**SkipDependentResources:** if set to "true", dependent resource, e.g. the database 
connection of a report will be skipped.<br>

## <a name="import_resource_command"></a>Import Resource Command

With the <code>jasper:import:resource</code> command, a previously exported resource 
can be imported to a JasperServer.

```
    php bin/console jasper:import:resource <Filename> <IncludebrokenDependencies>
```

**Filename:** filename of the local import file<br>
**IncludebrokenDependencies:** if set to "true", for resources with broken dependencies
(e.g. exported with the option <code>SkipDependentResources</code>) the import process
attempts to import the resource by resolving dependencies with local resources.<br>

## <a name="copying_resources"></a>Copying Resources between different Servers

You can use the export and import resources commands to copy resources from 
one server to another, e.g. between different stages of
an application. Use the <code>SkipDependentResources</code> option when exporting a 
resource and the <code>IncludebrokenDependencies</code> option when importing it 
on the second server to avoid that the database connection is overwritten on 
the target server.

Take care that the export and import keys on both servers are adjusted. 
Read https://community.jaspersoft.com/documentation/tibco-jasperreports-server-security-guide/v7/using-custom-keys
for further information on how to use customs keys.

Create key store

```
    keytool -genseckey -keystore ./mystore -storetype jceks -storepass <storepass> -keyalg AES -keysize 128 -alias importExportEncSecret -keypass <keypass>
```

Copy store to JasperServer's buildomatic directory

```
    cp ./mystore /opt/jasperreports-server-cp-7.8.0/buildomatic/
```

Go to the buildomatic directory as root user and import key to JasperServer

```
    ./js-import.sh --input-key --keystore ./mystore --storepass <storepass> --keyalias importExportEncSecret --keypass <keypass>
```

Restart the JasperServer application or reboot the server

## <a name="configuration"></a>Additional Configuration Options

```yml
    hboie_jasper_report:
        host:      'http://localhost:8080/jasperserver'
        username:  '%env(HBOIE_JASPER_REPORT_USERNAME)%'
        password:  '%env(HBOIE_JASPER_REPORT_PASSWORD)%'
        org_id:    '%env(HBOIE_JASPER_REPORT_ORGID)%'
        timeout:   50
```

**timeout:** timeout for REST-request (in seconds)