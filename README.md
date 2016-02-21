# JasperReportBundle

The JasperReportBundle requires jaspersoft/rest-client and provides an JasperReport-Client as service in the Symfony service container.

## Installation

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

## Usage

You can now access the <code>Client</code> object via the Symfony service <code>jasperreport.client</code>:
```php
    $client = $this->get('jasperreport.client');
```
or directly access the <code>ReportService</code> using the Symfony service <code>jasperreport.reportservice</code>:
```php
    $report = $this->get('jasperreport.reportservice')->runReport('/reports/TestReport', 'pdf');
```
