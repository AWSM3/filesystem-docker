<?php
/**
 * Author: AWSM3
 * Request.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\Utils\Http;

/** @uses */
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class Request
 *
 * @package App\Utils\Http
 */
class Request
{
    /** @var HttpRequest */
    private $request;

    /**
     * Request constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function makeAbsolutePublicPath(string $path): string
    {
        return "//{$this->request->getHttpHost()}".$path;
    }
}