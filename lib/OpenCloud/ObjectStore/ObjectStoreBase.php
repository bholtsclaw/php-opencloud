<?php
/**
 * The Object Storage service
 *
 * @copyright 2012-2013 Rackspace Hosting, Inc.
 * See COPYING for licensing information
 *
 * @package phpOpenCloud
 * @version 1.0
 * @author Glen Campbell <glen.campbell@rackspace.com>
 */

namespace OpenCloud\ObjectStore;

use OpenCloud\Base\Lang;

define('SWIFT_MAX_OBJECT_SIZE', 5*1024*1024*1024+1);

/**
 * A base class for common code shared between the ObjectStore and
 * ObjectStoreCDN
 * objects
 *
 * @author Glen Campbell <glen.campbell@rackspace.com>
 */
class ObjectStoreBase extends \OpenCloud\AbstractClass\Service {

    const MAX_CONTAINER_NAME_LEN 	= 256;
    const MAX_OBJECT_NAME_LEN 		= 1024;
    const MAX_OBJECT_SIZE 			= SWIFT_MAX_OBJECT_SIZE;

    /**
     * Returns the URL of the service, selected from the connection's
     * serviceCatalog
     */
	public function Url(array $param = array()) 
	{
		return \OpenCloud\Base\Lang::noslash(parent::Url($param));
	}

    /**
     * Creates a Container object associated with the ObjectStore
     *
     * This is a factory method and should generally be used instead of
     * calling the Container class directly.
     *
     * @param mixed $cdata (optional) the name of the container (if string)
     *      or an object from which to set values
     * @return ObjectStore\Container
     */
	public function Container($cdata = NULL) 
	{
		return new Container($this, $cdata);
	}

    /**
     * Returns a Collection of Container objects
     *
     * This is a factory method and should generally be used instead of
     * calling the ContainerList class directly.
     *
     * @param array $filter a list of key-value pairs to pass to the
     *      service to filter the results
     * @return ObjectStore\ContainerList
     */
	public function ContainerList(array $filter = array()) 
	{
		$filter['format'] = 'json';
		return $this->Collection(
		    '\OpenCloud\ObjectStore\Container',
			$this->Url().'?'.$this->MakeQueryString($filter)
		);
	}

}