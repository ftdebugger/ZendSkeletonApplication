<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Admin\Navigation\Page;


use Zend\Navigation\Page\AbstractPage;

class Entities extends AbstractPage
{
    /**
     * Returns href for this page
     *
     * @return string  the page's href
     */
    public function getHref()
    {
        return '#';
    }

}