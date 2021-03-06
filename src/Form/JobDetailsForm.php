<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2018 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace Gastro24\Form;

use Core\Form\HeadscriptProviderInterface;
use Core\Form\SummaryForm;
use Zend\Http\PhpEnvironment\Request;
use Zend\Stdlib\ArrayUtils;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class JobDetailsForm extends SummaryForm implements HeadscriptProviderInterface
{
    public function setHeadscripts(array $scripts)
    {
        return $this;
    }

    public function getHeadscripts()
    {
        return [
            'assets/blueimp-file-upload/js/vendor/jquery.ui.widget.js',
            'assets/blueimp-file-upload/js/jquery.iframe-transport.js',
            'assets/blueimp-file-upload/js/jquery.fileupload.js',
            'Gastro24/jobpdfupload.js'
        ];
    }


    protected $baseFieldset = [
        'type' => JobDetails::class,
        'name' => 'details',
        'options' => [
            'enable_descriptions' => false,
            'enable_ajax' => true,
        ]
    ];

    public function init()
    {
        parent::init();
        $this->setAttribute('class', $this->getAttribute('class') . ' file-upload');
        $this->setAttribute('data-dropzone', 'csj-pdf-wrapper');
    }

    public function setData($data)
    {
        $data = is_array($data) ? $data : $data->toArray();
        $request = new Request();
        $files = $request->getFiles()->toArray();
        $data = ArrayUtils::merge($data, $files);
        return parent::setData($data); // TODO: Change the autogenerated stub
    }

    public function isValid()
    {
        $isValid = \Zend\Form\Form::isValid();
        if ($isValid) {
            $this->setRenderMode(self::RENDER_SUMMARY);
        }

        return $isValid;
    }


}
