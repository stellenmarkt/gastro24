<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2017 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace Gastro24\WordpressApi\Service;

use Gastro24\WordpressApi\Service\Plugin;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;
use Zend\ServiceManager\Exception\RuntimeException;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class WordpressClientPluginManager extends AbstractPluginManager
{
    protected $factories = [
        Plugin\WordpressV2::class => InvokableFactory::class,
        Plugin\MenusV1::class     => InvokableFactory::class,

        /* this is needed, because we still are not on zf3 */
        'gastro24wordpressapiservicepluginwordpressv2' => InvokableFactory::class,
        'gastro24wordpressapiservicepluginmenusv1'     => InvokableFactory::class,
    ];

    protected $aliases = [
        'wp'    => Plugin\WordpressV2::class,
        'menus' => Plugin\MenusV1::class,
    ];

    /**
     *
     *
     * @var WordpressClientInterface
     */
    protected $wordpressClient;

    /**
     * Validate the plugin
     *
     * Checks that the filter loaded is either a valid callback or an instance
     * of FilterInterface.
     *
     * @param  mixed $plugin
     *
     * @return void
     * @throws RuntimeException if invalid
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceOf Plugin\PluginInterface) {
            throw new RuntimeException('WordpressClientPlugins must implement ' . Plugin\PluginInterface::class);
        }
    }

    public function setClient(WordpressClientInterface $client)
    {
        $this->client = $client;

        $this->addInitializer(function($instance) use ($client) {
                /* @var \Gastro24\WordpressApi\Service\Plugin\PluginInterface $instance */
                $instance->setClient($client);
        });

        return $this;
    }
}