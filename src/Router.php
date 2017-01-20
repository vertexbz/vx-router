<?php
namespace Router;

use Router\Exception\BadRequestMethodException;
use Router\Exception\RouteNotFoundException;
use Router\Response\ResponseInterface;
use Router\Route\Route;

class Router
{
    /**
     * @var RouteResolver
     */
    protected $routeResolver;

    /**
     * @var Request
     */
    protected $request;


    protected $notFoundPagePath;
    protected $badRequestPagePath;

    /**
     * @param RouteResolver $routeResolver
     * @param Request $request
     */
    public function __construct(RouteResolver $routeResolver, Request $request)
    {
        $this->routeResolver = $routeResolver;
        $this->request = $request;
    }

    /**
     * @return Response
     */
    public function runApplication()
    {
        try {
            $route = $this->routeResolver->resolveRouteForRequest($this->request);
            $result = $this->execute($route);

            switch (true) {
                case $result instanceof Response:
                    $response = $result;
                    break;

                case $result instanceof ResponseInterface:
                    $response = $this->buildResponse($result);
                    break;
                default:
                    throw new InvalidArgumentException;
            }
        }
        catch(BadRequestMethodException $exception) {
            $response = $this->displayErrorPageWithCodeAndContentPath(
                Response::HTTP_BAD_REQUEST,
                $this->badRequestPagePath
            );
        }
        catch(RouteNotFoundException $exception) {
            $response = $this->displayErrorPageWithCodeAndContentPath(
                Response::HTTP_NOT_FOUND,
                $this->notFoundPagePath
            );
        }

        return $response;
    }

    protected function displayErrorPageWithCodeAndContentPath($httpCode, $contentPath)
    {
        $content = '';
        if (!empty($contentPath)) {
            $content = file_get_contents($contentPath);
        }
        return new Response($content, $httpCode);
    }

    /**
     * @param string $path
     */
    public function setNotFoundPagePath($path)
    {
        if (is_file($path)) {
            $this->notFoundPagePath = realpath($path);
        }
    }

    /**
     * @param string $path
     */
    public function setBadRequestPagePath($path)
    {
        if (is_file($path)) {
            $this->badRequestPagePath = realpath($path);
        }
    }

    /**
     * @param Route $route
     * @return Response|ResponseInterface
     */
    protected function execute(Route $route)
    {
        $controller = new $route->controller($this->context);

        if($route->requestType) {
            $request = $this->createRequest($route->requestType, $route);
            $response = $controller->{$route->method}($request);
        }
        else {
            $response = $controller->{$route->method}();
        }
        return $response;
    }

    /**
     * @param string $requestType
     * @param Route $route
     * @return Request
     */
    protected function createRequest($requestType, Route $route)
    {
        if ($requestType == Request::class) {
            return $this->request;
        }
        $request = new $requestType($this->request, $route->parameters);
        return $request;
    }

    /**
     * @param ResponseInterface $response
     * @return Response
     */
    protected function buildResponse(ResponseInterface $response)
    {
        return new Response($response->render(), $response->getHttpCode(), $response->getHeaders());
    }

    /**
     * @param string $name
     * @param array $routeParameters
     * @param bool $prependCurrentSchemeAndHost
     * @return string
     * @throws InvalidRouteParametersException
     * @throws MissingRouteParameterException
     */
    public function assembleUrlForNamedRoute($name, array $routeParameters = [], $prependCurrentSchemeAndHost = false)
    {
        $route = $this->routeResolver->getNamedRoute($name);
        $missingParams = array_diff($route->parameters, array_keys($routeParameters));
        if (empty($missingParams)) {
            $template = strtr($route->regex,[
                '\\' => '',
                '/^' => '',
                '$/' => ''
            ]);
            $uri = preg_replace_callback('/\(\?P<([^>]*)>[^\)]*\)/', function($m) use ($routeParameters) {
                return $routeParameters[$m[1]];
            }, $template);

            if (!$this->routeResolver->routeMatchesUri(['regex'=>$route->regex], $uri)) {
                throw new InvalidRouteParametersException("Provided parameters don't fit route placeholders!");
            }

            if ($prependCurrentSchemeAndHost) {
                $uri = $this->request->getSchemeAndHttpHost().$uri;
            }
            return $uri;
        }
        throw new MissingRouteParameterException(
            "Cannot assemble route url because of missing parameters `".join('`, `', $missingParams)."`");
    }

}
