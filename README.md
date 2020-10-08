# JasperReportBundle

The JasperReportBundle requires jaspersoft/rest-client and provides an JasperReport-Client as service in the Symfony service container.

## Installation with Symfony Flex (4 / 5)

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

## Usage in Symfony 4 / 5

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

## Installation with Symfony 2 / 3

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

## Usage in Symfony 2 / 3

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
