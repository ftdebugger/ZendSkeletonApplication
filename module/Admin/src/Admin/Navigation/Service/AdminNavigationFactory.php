<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Navigation\Service;

use Admin\Entities\Container;
use Zend\Navigation\Service\AbstractNavigationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

class AdminNavigationFactory extends AbstractNavigationFactory
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin';
    }

    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        if (null === $this->pages) {
            $pages = parent::getPages($serviceLocator);
            $this->pages = ArrayUtils::merge($pages, $this->getEntitiesPage($serviceLocator));
        }

        return $this->pages;
    }

    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return array
     */
    protected function getEntitiesPage(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Container $entities */
        $entities = $serviceLocator->get('admin-entities');

        $config = array();
        foreach ($entities->getEntities() as $entity) {
            if ($entity->getOptions()->isAllowList()) {
                $config[] = array(
                    'label' => $entity->getName(),
                    'route' => 'admin/entity/entity',
                    'params' => array(
                        'entity' => $entity->getName()
                    ),
                    'resource' => 'admin'
                );
            }
        }

        if (count($config)) {
            $config = array(
                'entities' => array(
                    'label' => 'Entities',
                    'route' => 'admin/entity',
                    'resource' => 'admin',
                    'pages' => $config
                )
            );

            $pages = $this->getPagesFromConfig($config);

            return $this->preparePages($serviceLocator, $pages);
        }

        return array();
    }

}
