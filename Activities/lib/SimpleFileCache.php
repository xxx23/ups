<?php


class SimpleFileCache
{
    protected $lifetime = 0; //in second
    protected $cacheDir = '';
    protected $prefix = 'UPS_SIMPLE_CACHE_';
    public $cacheData = array();

    public function __construct($config)
    {

        $this->lifetime = $config['lifetime'];
        $this->cacheDir = $config['cacheDir'];
        if(empty($this->cacheDir))
            $this->cacheDir = '.';
    }
    
    /**
     *
     * @param string 
     * @param mixed
     */
    public function save($key,$value)
    {
        $this->cacheData[$key]= $value;
        
        file_put_contents($this->cacheDir.'/'.$this->prefix.$key,serialize($this->cacheData[$key]));
    }

    /**
     *
     * @param string
     * @return mixed
     */
    public function load($key)
    {
        if(!file_exists($this->cacheDir.'/'.$this->prefix.$key))
            return false;

        if( (filemtime($this->cacheDir.'/'.$this->prefix.$key)+$this->lifetime) < time() )
            return false;

        $this->cacheData[$key] = unserialize(file_get_contents($this->cacheDir.'/'.$this->prefix.$key));

        return $this->cacheData[$key];
    }
}
