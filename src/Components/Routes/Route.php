<?php

namespace App\Components\Routes;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Route
{
    public const DEFAULT_REGEX = '[\w\-]+';

    /**
     * @var array $parameters
     */
    private array $parameters = [];

    /**
     * @param string $path
     * @param ?string $name
     * @param ?string[] $methods
     */
    public function __construct(
        private string $path,
        private string $name = '',
        private array $methods = ['GET'],
    ) {
        if (empty($this->name)) {
            $this->name = $this->path;
        }
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @return bool
     */
    public function hasParams(): bool
    {
        return preg_match('/{([\w\-%]+)(<(.+)>)?}/', $this->path);
    }

    /**
     * @return array
     */
    public function fetchParams(): array
    {
        if (empty($this->parameters)) {
            preg_match_all('/{([\w\-%]+)(?:<(.+?)>)?}/', $this->getPath(), $params);
            $this->parameters = array_combine($params[1], $params[2]);
        }

        return $this->parameters;
    }
}
