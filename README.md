SitemapBundle
=========
[![Build Status](https://travis-ci.org/4devs/sitemap-bundle.svg?branch=master)](https://travis-ci.org/4devs/sitemap-bundle)

Documentation
-------------

use rules [Sitemaps XML format](http://www.sitemaps.org/protocol.html) for the generate sitemap

Installation
------------

Bundle uses Composer, please checkout the [composer website](http://getcomposer.org) for more information.

The simple following command will install `sitemap-bundle` into your project. It also add a new
entry in your `composer.json` and update the `composer.lock` as well.


```bash
composer require fdevs/sitemap-bundle
```

add to your `app/AppKernel.php`

```php
<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = [
        //....
            new FDevs\SitemapBundle\FDevsSitemapBundle(),
        ];
        //....

        return $bundles;
    }
    //....
}
```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    LICENSE

Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/4devs/sitemap-bundle/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.

---
Created by [4devs](http://4devs.pro/) - Check out our [blog](http://4devs.io/) for more insight into this and other open-source projects we release.
