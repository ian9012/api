<?php

use App\Handler\HomePageHandler;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageHandlerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var ContainerInterface|ObjectProphecy */
    protected $container;

    /** @var RouterInterface|ObjectProphecy */
    protected $router;
    
    protected function _before()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
        $this->router    = $this->prophesize(RouterInterface::class);
    }

    /**
     * @test
     */
    public function testReturnsJsonResponseWhenNoTemplateRendererProvided()
    {
        $homePage = new HomePageHandler(
            get_class($this->container->reveal()),
            $this->router->reveal(),
            null
        );
        $response = $homePage->handle(
            $this->prophesize(ServerRequestInterface::class)->reveal()
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * @test
     */
    public function testReturnsHtmlResponseWhenTemplateRendererProvided()
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render('app::home-page', Argument::type('array'))
            ->willReturn('');

        $homePage = new HomePageHandler(
            get_class($this->container->reveal()),
            $this->router->reveal(),
            $renderer->reveal()
        );

        $response = $homePage->handle(
            $this->prophesize(ServerRequestInterface::class)->reveal()
        );

        $this->assertInstanceOf(HtmlResponse::class, $response);
    }
}