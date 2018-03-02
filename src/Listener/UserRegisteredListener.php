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

use Auth\Listener\Events\AuthEvent;
use Gastro24\Entity\UserProduct;

/**
 * ${CARET}
 * 
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @todo write test 
 */
class UserRegisteredListener 
{
    /**
     *
     *
     * @var null|string
     */
    private $productType;

    /**
     *
     *
     * @var \Zend\Http\PhpEnvironment\Response
     */
    private $response;

    /**
     *
     *
     * @var \Zend\Router\RouteStackInterface
     */
    private $router;

    /**
     *
     *
     * @var \Auth\AuthenticationService
     */
    private $authService;

    public function __construct($productType = null, $router, $response, $authService)
    {
        $this->productType = ucfirst($productType);
        $this->router      = $router;
        $this->response    = $response;
        $this->authService = $authService;
    }

    public function __invoke(AuthEvent $event)
    {
        if (!$this->productType) {
            return;
        }

        $productClass = '\Gastro24\Entity\Product\\' . $this->productType;

        if (!class_exists($productClass)) {
            return;
        }

        /* @var \Auth\Entity\User $user
         * @var \Gastro24\Entity\UserProduct $wrapper */
        $user    = $event->getUser();
        $wrapper = $user->createAttachedEntity(UserProduct::class);
        $product = new $productClass();
        $wrapper->setProduct($product);

        $uri = $this->router->assemble(['action' => 'edit'], ['name' => 'lang/jobs/manage', 'only_return_path' => true]);
        $this->response->setStatusCode(302);
        $this->response->getHeaders()->addHeaderLine('Location', $uri);

        $this->authService->getStorage()->write($user->getId());
    }
}