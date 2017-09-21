<?php
namespace StefanoDb\Adapter\Service;

use Interop\Container\ContainerInterface;
use StefanoDb\Adapter\AdapterFactory;
use Zend\Db\Adapter\AdapterServiceFactory as ZendAdapterServiceFactory;

class AdapterServiceFactory
    extends ZendAdapterServiceFactory
{
    private $adapterFactory;

    /**
     * @param AdapterFactory $adapterFactory
     */
    public function __construct(AdapterFactory $adapterFactory = null) {
        $this->adapterFactory = $adapterFactory;
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $config = $container->get('Config');

        return $this->getAdapterFactory()
                    ->create($config['db']);
    }

    /**
     * @return AdapterFactory
     */
    private function getAdapterFactory() {
       if(null == $this->adapterFactory) {
           $this->adapterFactory = new AdapterFactory();
       }

       return $this->adapterFactory;
    }
}