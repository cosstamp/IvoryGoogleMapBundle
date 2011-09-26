<?php

namespace Ivory\GoogleMapBundle\Model\Overlays;

use Ivory\GoogleMapBundle\Model\Base\Bound;
use Ivory\GoogleMapBundle\Model\Base\Coordinate;

/**
 * Rectangle which describes a google map rectangle
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Rectangle extends AbstractAsset implements IExtendable
{
    /**
     * @var Ivory\GoogleMapBundle\Model\Base\Bound Rectangle bound
     */
    protected $bound = null;

    /**
     * @var array Rectangle options
     * @see http://code.google.com/apis/maps/documentation/javascript/reference.html#RectangleOptions
     */
    protected $options = array();

    /**
     * Create a rectangle
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setPrefixJavascriptVariable('rectangle_');

        $this->bound = new Bound();
        $this->bound->setNorthEast(new Coordinate(-1, -1));
        $this->bound->setSouthWest(new Coordinate(1, 1));
    }

    /**
     * Gets the rectangle bound
     *
     * @return Ivory\GoogleMapBundle\Model\Bound
     */
    public function getBound()
    {
        return $this->bound;
    }

    /**
     * Sets the rectangle bound
     *
     * Available prototype:
     * 
     * public function setBound(Ivory\GoogleMapBundle\Model\Base\Bound $bound)
     * public function setBount(Ivory\GoogleMapBundle\Model\Base\Coordinate $southWest, Ivory\GoogleMapBundle\Model\Base\Coordinate $northEast)
     * public function setBound(double $southWestLatitude, double $southWestLongitude, double $northEastLatitude, double $northEastLongitude, boolean southWestNoWrap = true, boolean $northEastNoWrap = true)
     */
    public function setBound()
    {
        $args = func_get_args();
        
        if(isset($args[0]) && ($args[0] instanceof Bound))
            $this->bound = $args[0];
        else if(isset($args[0]) && ($args[0] instanceof Coordinate) && isset($args[1]) && ($args[1] instanceof Coordinate))
        {
            $this->bound->setSouthWest($args[0]);
            $this->bound->setNorthEast($args[1]);
        }
        else if(isset($args[0]) && is_numeric($args[0]) && isset($args[1]) && is_numeric($args[1]) && isset($args[2]) && is_numeric($args[2]) && isset($args[3]) && is_numeric($args[3]))
        {
            $this->bound->setSouthWest(new Coordinate($args[0], $args[1]));
            $this->bound->setNorthEast(new Coordinate($args[2], $args[3]));
            
            if(isset($args[4]) && is_bool($args[4]))
                $this->bound->getSouthWest()->setNoWrap($args[4]);

            if(isset($args[5]) && is_bool($args[5]))
                $this->bound->getNorthEast()->setNoWrap($args[5]);
        }
        else
            throw new \InvalidArgumentException(sprintf('%s'.PHP_EOL.'%s'.PHP_EOL.'%s'.PHP_EOL.'%s'.PHP_EOL.'%s',
                'The bound setter arguments is invalid.',
                'The available prototypes are :',
                ' - public function setBound(Ivory\GoogleMapBundle\Model\Base\Bound $bound)',
                ' - public function setBount(Ivory\GoogleMapBundle\Model\Base\Coordinate $southWest, Ivory\GoogleMapBundle\Model\Base\Coordinate $northEast)',
                ' - public function setBound(double $southWestLatitude, double $southWestLongitude, double $northEastLatitude, double $northEastLongitude, boolean southWestNoWrap = true, boolean $northEastNoWrap = true)'));
    }

    /**
     * Gets the rectangle options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets the rectangle options
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        foreach($options as $option => $value)
            $this->setOption($option, $value);
    }

    /**
     * Gets a specific rectangle option
     *
     * @param string $option
     * @return mixed
     */
    public function getOption($option)
    {
        if(is_string($option))
            return isset($this->options[$option]) ? $this->options[$option] : null;
        else
            throw new \InvalidArgumentException('The option property of a rectangle must be a string value.');
    }

    /**
     * Sets a specific rectangle option
     *
     * @param string $option
     * @param mixed $value
     */
    public function setOption($option, $value)
    {
        if(is_string($option))
            $this->options[$option] = $value;
        else
            throw new \InvalidArgumentException('The option property of a rectangle must be a string value.');
    }
}