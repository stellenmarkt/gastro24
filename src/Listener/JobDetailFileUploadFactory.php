<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace Gastro24\Listener;

use Gastro24\Form\JobDetailsForm;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for \Gastro24\Listener\JobDetailFileUpload
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test  
 */
class JobDetailFileUploadFactory implements FactoryInterface
{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = $container->get('forms')->get(JobDetailsForm::class);
        $form->setName('details');

        $repository = $container->get('repositories')->get('Gastro24/TemplateImage');

        $service = new JobDetailFileUpload($form, $repository);
        
        return $service;    
    }
}
