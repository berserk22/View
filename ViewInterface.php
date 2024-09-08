<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\View;

use Slim\Http\Response;

interface ViewInterface {


    public function loadPlugins(): void;

    /**
     * @return void
     */
    public function initView(): void;

    /**
     * @param Response $response
     * @param mixed $template
     * @param array $data
     * @return Response
     */
    public function render(Response $response, mixed $template='', array $data = []): Response;

    /**
     * @param Response $response
     * @param mixed $template
     * @param array $data
     * @return Response
     */
    public function fetch(Response $response, mixed $template='', array $data = []): Response;

    /**
     * @param mixed $template
     * @param array $data
     * @return mixed
     */
    public function getHtml(mixed $template='', array $data = []): mixed;

    /**
     * @param mixed $content
     * @param array $data
     * @return string
     */
    public function getHtmlFromContent(mixed $content, array $data = []): string;

    /**
     * @param Response $response
     * @param array $data
     * @param int $status
     * @return Response
     */
    public function renderJson(Response $response, array $data = [], int $status = 200): Response;

}
