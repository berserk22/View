<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\View;

use DI\DependencyException;
use DI\NotFoundException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Connection;
use Monolog\Handler\Handler;
use Slim\Http\Response;

class ViewManager extends AbstractViewer {

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $path;

    /**
     * @var mixed
     */
    public mixed $template;

    /**
     * @var mixed
     */
    public mixed $layout;

    /**
     * @var array
     */
    public array $tmpVariable = [];

    /**
     * @var array
     */
    public array $plugins = [];

    /**
     * @var array
     */
    public array $config = [];

    /**
     * @var Connection|null
     */
    public ?Connection $db = null;

    public array $func = [
        "array_key_first",
        "array_key_last",
        "array_keys",
        "array_column",
        "array_shift",
        "array_pop",
        "next",
        "file_get_contents",
        "base64_encode",
        "base64_decode",
        "count",
        "empty"
    ];

    /**
     * @return void
     */
    public function registry(): void {
        try {
            $this->config = $this->getContainer()->get('config')->getSetting();

            $design_config = $this->getDB()->table('settings')
                ->select('settings.key', 'settings.value')
                ->join('settings_group', 'settings.settings_group_id', '=', 'settings_group.id')
                ->where('settings_group.key', '=', 'design')
                ->get();

            foreach($design_config as $design_item){
                $config_keys = explode('_', $design_item->key);
                $this->config[$config_keys[0]][$config_keys[1]] = $design_item->value;
            }

        } catch (DependencyException|NotFoundException $e) {
            die($e->getMessage());
        }
    }

    /**
     * @return Connection
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function getDB(): Connection {
        if (!property_exists($this, 'db') || $this->db===null){
            $config = $this->getContainer()->get('config')->getSetting('database');

            $default = $config['main'];
            $default['driver'] = $config['driver'];
            $default['charset'] = $config['charset'];
            $default['collation'] = $config['collation'];

            $capsule = new Manager();
            $capsule->addConnection($default);
            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            $capsule->getContainer()->singleton(
                ExceptionHandler::class,
                Handler::class
            );
            $this->db=$capsule->getConnection();
        }
        return $this->db;
    }

    /**
     * @param mixed $layout
     * @return void
     */
    public function setLayout(mixed $layout = ''): void {
        if (is_file($this->path.DIRECTORY_SEPARATOR.$layout)){
            $this->layout = $layout;
        }
    }

    /**
     * @return mixed
     */
    public function getLayout(): mixed {
        return $this->layout;
    }

    /**
     * @param string $template
     * @return void
     */
    public function setTemplatePath(string $template): void {
        $this->path = str_replace($this->config['template']['name'], $template, $this->path);
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string {
        return $this->path;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setVariable(string $name, mixed $value): void {
        $this->tmpVariable[$name]=$value;
    }

    /**
     * @param array $variables
     * @return void
     */
    public function setVariables(array $variables): void {
        $this->tmpVariable=array_merge($this->tmpVariable, $variables);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getVariable(string $name): mixed {
        return $this->tmpVariable[$name];
    }

    /**
     * @return array
     */
    public function getVariables(): array {
        return $this->tmpVariable;
    }

    /**
     * @param array $plugins
     * @return void
     */
    public function setPlugins(array $plugins = []): void {
        $this->plugins=array_merge($this->plugins, $plugins);
    }

    /**
     * @param mixed $template
     * @param array $data
     * @return string
     */
    public function getHtml(mixed $template = '', array $data = []): string {
        return '';
    }

    /**
     * @param mixed $content
     * @param array $data
     * @return string
     */
    public function getHtmlFromContent(mixed $content, array $data = [], string $tmp_path = "tmp/"): string {
        return '';
    }

    /**
     * @param Response $response
     * @param mixed $template
     * @param array $data
     * @return Response
     */
    public function render(Response $response, mixed $template = '', array $data = []): Response {
        return $response->withStatus(200)->withHeader('Content-Type', 'text/html');
    }

    /**
     * @param Response $response
     * @param mixed $template
     * @param array $data
     * @return Response
     */
    public function fetch(Response $response, mixed $template = '', array $data = []): Response {
        return $response->withStatus(200)->withHeader('Content-Type', 'text/html');
    }

    /**
     * @param Response $response
     * @param array $data
     * @param int $status
     * @return Response
     */
    public function renderJson(Response $response, array $data = [], int $status = 200): Response {
        $this->setVariables($data);
        return $response->withJson($this->getVariables(), $status);
    }
}
