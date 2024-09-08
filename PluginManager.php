<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\View;

class PluginManager {

    protected array $plugins = [];

    /**
     * @param string $name
     * @param string $plugin
     * @return void
     */
    public function addPlugin(string $name, string $plugin): void {
        if (class_exists($plugin)) {
            $this->plugins[$name] = $plugin;
        }
    }

    /**
     * @param array $plugins
     * @return void
     */
    public function addPlugins(array $plugins): void {
        if (!empty($plugins)){
            foreach ($plugins as $name => $plugin){
                $this->addPlugin($name, $plugin);
            }
        }
    }

    /**
     * @return array
     */
    public function getPlugins(): array {
        return $this->plugins;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getPlugin(string $name): mixed {
        return $this->plugins[$name] ?? null;
    }
}
