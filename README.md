# View Module

The View module provides the base infrastructure for view management in the SkeletonApp. It defines the interfaces, abstract classes, and managers required to implement and use various templating engines (such as Latte).

## Overview

The module acts as a bridge between the application and specific view engine implementations. It includes:
- **ViewManager**: The primary service for managing view configuration and rendering.
- **ViewInterface**: A standard interface that all view engine implementations must follow.
- **Plugin System**: Infrastructure for creating and managing view-specific plugins and custom functions.
- **Configuration Integration**: Automatically retrieves design-related settings from the database and application configuration.

## Requirements

- **PHP**: >= 8.2
- **SkeletonApp Core**: Provides the base `Provider` and DI container integration.
- **Slim Framework**: Uses `Slim\Http\Response` for rendering output.
- **Illuminate Database**: Used for fetching design settings from the database.

## Project Structure

- `ViewInterface.php`: Interface defining the required methods for any view implementation.
- `AbstractViewer.php`: Base class for view managers and engines.
- `ViewManager.php`: Main implementation for view management and service registration.
- `ServiceProvider.php`: Handles module initialization and plugin registration.
- `PluginManager.php`: Manages view plugins and their lifecycle.
- `AbstractPlugin.php`: Base class for creating custom view plugins.

## Setup & Run Commands

The module is typically included as a core dependency of the SkeletonApp.

1.  **Installation**:
    ```bash
    composer require skeleton-app/view
    ```

2.  **Registration**:
    The module's `ServiceProvider` should be registered in the application's bootstrap process.

## Usage

### Using the View Manager
The View Manager is typically accessed via the DI container as `ViewManager::View`.

```php
/** @var \Modules\View\ViewInterface $view */
$view = $container->get('ViewManager::View');
return $view->render($response, 'index', ['title' => 'Home Page']);
```

### Implementing a New View Engine
To create a new view engine, implement the `ViewInterface` and extend `AbstractViewer` (if applicable), then register it in the DI container under the `ViewManager::View` key.

### Plugins
You can add plugins to the view system through the `PluginManager` or by defining them in the `ServiceProvider`.

## Configuration (Env Vars / Config)

The module integrates with the application's configuration (`config/config.ini`) and database:

- `template.path`: Root path for template files (e.g., `www/template`).
- `template.name`: Current theme/template folder name.
- `template.layout`: Default layout filename.
- **Database Settings**: The module automatically fetches settings from the `settings` table where the group is `design`.

## Scripts

TODO: Document any module-specific CLI commands if implemented.

## Tests

TODO: Tests are not yet implemented for this module. When added, run them from the project root:
```bash
./vendor/bin/phpunit modules/View/tests
```

## License

This project is licensed under a proprietary license as specified in `composer.json`.
