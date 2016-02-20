<?php

namespace Hboie\JasperReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HboieJasperReportBundle:Default:index.html.twig');
    }
}
