<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\View;

use Core\Traits\App;
use Slim\Http\Response;

abstract class AbstractViewer {

    use App;

    /**
     * @param array $plugins
     * @return void
     */
    abstract public function setPlugins(array $plugins = []): void;

    /**
     * @return void
     */
    abstract public function registry(): void;

    /**
     * @param mixed $layout
     * @return void
     */
    abstract public function setLayout(mixed $layout = ''): void;

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    abstract public function setVariable(string $name, mixed $value): void;

    /**
     * @param array $variables
     * @return void
     */
    abstract public function setVariables(array $variables): void;

    /**
     * @param string $name
     * @return mixed
     */
    abstract public function getVariable(string $name): mixed;

    /**
     * @return array
     */
    abstract public function getVariables():array;

    /**
     * @param mixed $template
     * @param array $data
     * @return string
     */
    abstract public function getHtml(mixed $template='', array $data=[]): string;

    /**
     * @param mixed $content
     * @param array $data
     * @return string
     */
    abstract public function getHtmlFromContent(mixed $content, array $data = []): string;

    /**
     * @param Response $response
     * @param mixed $template
     * @param array $data
     * @return Response
     */
    abstract public function render(Response $response, mixed $template = '', array $data = []):Response;

    /**
     * @param Response $response
     * @param mixed $template
     * @param array $data
     * @return Response
     */
    abstract public function fetch(Response $response, mixed $template = '', array $data = []):Response;

    /**
     * @param Response $response
     * @param array $data
     * @param int $status
     * @return Response
     */
    abstract public function renderJson(Response $response, array $data = [], int $status = 200):Response;

}
