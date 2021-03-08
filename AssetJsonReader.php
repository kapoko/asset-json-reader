<?php 

namespace Kapoko\AssetJsonReader;

use Symfony\Component\Filesystem\Filesystem;

class AssetJsonReader
{
    /**
     * @var array 
     */
    protected $manifest;

    /**
     * @var string 
     */
    protected $path;
    
    /**
     * Manifest constructor
     * 
     * @return void
     */
    public function __construct($path = false) 
    {
        if ($path) {
            $this->registerManifest($path);
        }
    }

    /**
     * Registers the manifest and parses the values
     * 
     * @param  string $path Path to the manifest file
     * @return void
     */
    public function registerManifest($path)
    {
        $this->path = $path;

        $manifest = $this->getJsonManifest($this->path);

        foreach ($manifest as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Setting key value pair, if array call function recursively
     * 
     * @return void
     */
    public function set($key, $value): void
    {
        if (is_array($value)) {
            foreach($value as $innerKey => $innerValue) {
                $this->set($key . '.' . $innerKey, $innerValue);
            }
        } else {
            $this->manifest[$this->normalizeRelativePath($key)] = $this->normalizeRelativePath($value);
        }
    }

    /**
     * Getting value from the manifest by key
     * 
     * @return string
     */
    public function get($key): string
    {
        $key = $this->normalizeRelativePath($key);

        $relative_path = $this->manifest[$key] ?? $key;

        return $relative_path;
    }

    /**
     * Normalizes to forward slashes and removes leading slash.
     *
     * @return string
     */
    protected function normalizeRelativePath(string $path): string
    {
        $path = str_replace('\\', '/', $path);
        return ltrim($path, '/');
    }

    /**
     * Get the file from disk and decoded it 
     * 
     * @param  string $jsonManifestPath Path to the manifest file
     * @return array
     */
    protected function getJsonManifest(string $jsonManifestPath): array
    {
        $filesystem = new Filesystem();
        
        return $filesystem->exists($jsonManifestPath) ? \json_decode(file_get_contents($jsonManifestPath), true) : [];
    }
}