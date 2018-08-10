# NavalexConfigBundle

Allows you to create configurations that can be used in your project (Twig and Controller services) and manage them through an admin panel divided into two parts:

- Configuration forms divided in category and fieldset to edit values of your configs:
<div>
    <img src="http://navalex.net/uploads/public/config-bundle/screens/screen_form.png" alt"ConfigBundle Form" width="49%" />
</div>

- Create Category, Fieldset and Configuration field for you forms
<div>
    <img src="http://navalex.net/uploads/public/config-bundle/screens/screen_manage_cat.png" alt"ConfigBundle Form" width="30%" />
    <img src="http://navalex.net/uploads/public/config-bundle/screens/screen_manage_field.png" alt"ConfigBundle Form" width="30%" />
    <img src="http://navalex.net/uploads/public/config-bundle/screens/screen_manage_conf.png" alt"ConfigBundle Form" width="30%" />
</div>

Installation
============

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require navalex/config-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require navalex/config-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Navalex\ConfigBundle\NavalexConfigBundle(),
        );

        // ...
    }

    // ...
}
```

### Step 3: Update database

To make the plugin work, you need to update database table by entering the following command:
```console
$ php bin/console doctrine:schema:update --force
```

Configuration
============

### Step 1: Enable routes

Open `app/config/routing.yml` and add:

```yaml
# app/config/routing.yml

navalex.config_bundle:
    resource: '@NavalexConfigBundle/Resources/config/routing.yml'
```


### (Optional) Step 2: Protect admin panel

If you want to restrict access to the panel to a specific role you can something like that (restrict access for ROLE_ADMIN only) in `app/config/security.yml`:

```yaml
# app/config/security.yml

security:
    
    # ...

    role_hierarchy:
         # ...
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: ROLE_ADMIN

    access_control:
         # ...
        - { path: ^/admin/, role: ROLE_ADMIN }
```

### Step 3: Update cache

Once evrything is done, update symfony cache to access to the panel
```console
$ php bin/console cache:clear
or
$ php bin/console cache:clear --env=prod
```

Usage
============

### Step 1: Create configurations

Go to http://<your_website>/admin/config/admin/config/conf

Here you can create Form Category, then give it fieldsets to organize your form, and finaly create configuration. Here a detail of configuration fields:
- Name: Admin form label for this configuration
- Code: Unique code to call the configuration in Twig and Controller
- Category/Field: Select form and fieldset for this configuration
- Type: What kind of field will be the configuration
By default, the bundle give the value "data" to every new configuration.

### Step 2: Edit configurations value

You'll now see your configurations category form appear on the navbar of the panel. Just go on it and enjoy !

### Step 3: Call the configuration in your project

#### In Controller:
```php
$configs = $this->get('navalex_config.config');
$configs->get('<your_configuration_code>');
```

#### In Twig:
```twig
{{ getConfig('<your_configuration_code>') }}
```

## Incoming Features
- Translation domain for configuration label
- New complexe field types:
    - Array (with text inputs added with ajax button)
    - Image (with automatique upload and naming)
- Complete Navapanel Dashboard
- Order Form Category in the panel
- Get config from ajax with API url like _http://<your_website>/config/\<code\>_ and JSON return
- Customize field types in symfony configuration
- ...

# License

This bundle is under the MIT license. See the complete license [in the bundle](LICENSE)
