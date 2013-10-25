<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Application\Cache\Storage\Plugin;


use Zend\Cache\Storage\Event;
use Zend\Cache\Storage\Plugin\AbstractPlugin;
use Zend\EventManager\EventManagerInterface;

class HashKey extends AbstractPlugin
{

    /**
     * @var array
     */
    protected $listeners = [];

    /**
     * {@inheritdoc}
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $callback = array($this, 'hashKey');

        $this->listeners[] = $events->attach('hasItem.pre', $callback, $priority);
        $this->listeners[] = $events->attach('getItem.pre', $callback, $priority);
        $this->listeners[] = $events->attach('setItem.pre', $callback, $priority);
    }

    /**
     * @param Event $e
     */
    public function hashKey(Event $e)
    {
        $e->setParam('key', md5($e->getParam('key')));
    }

}