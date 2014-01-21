<?php
namespace StefanoDb\Adapter;

use StefanoDb\Adapter\Adapter;

interface AdapterAwareInterface
{
    /**
     * @param Adapter $adapter
     * @return this;
     */
    public function setDbAdapter(Adapter $adapter);
}