Getting Started With SitemapBundle
===========================================

## Installation and usage

Installation and usage is a quick:

1. Download SitemapBundle using composer
2. Enable the Bundle
3. Configure bundle
4. Basic use the bundle dynamic
5. Basic use the bundle generate
6. Add Static route in sitemap


### Step 1: Download SitemapBundle using composer

Add SitemapBundle in your composer.json:

```js
{
    "require": {
        "fdevs/sitemap-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update fdevs/sitemap-bundle
```

Composer will install the bundle to your project's `vendor/fdevs` directory.


### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FDevs\SitemapBundle\FDevsSitemapBundle(),
    );
}
```

### Step 3: Configure bundle

``` yml
// app/config/config.yml
f_devs_sitemap:
    web_dir:              null      # full path to web dir default %kernel.root_dir%/../web
    filename:             sitemap   #name for sitemap with out ext
    sitemaps_dir:         sitemaps/ # dirs for sitemaps
    generate_sitemapindex: false    # need if generate each sitemap for parameters
    domain: 'http://%domain%'       # set domain fir sitemapindex
    parameters:                     # Must be used for the generation of loc
        _locale: ['ru','en']
        _format: ['html']
        other_variables: ['one','two','три']
```

Setting up Permissions for sitemaps dir and sitemap.xml(filename)

``` bash
$ HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
$ sudo chmod +a "$HTTPDUSER allow delete,write,append,file_inherit,directory_inherit" web/sitemaps web/sitemap.xml
$ sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" web/sitemaps web/sitemap.xml
```

if this not working please set permission for the `web/sitemaps` and `web/sitemap.xml` like [Symfony Docs](http://symfony.com/doc/current/book/installation.html#configuration-and-setup)


### Step 4: Basic use the bundle dynamic

add route

``` yml
// app/config/routing.yml
f_devs_geo:
    resource: "@FDevsSitemapBundle/Resources/config/routing.xml"
    prefix:   /{_locale}
```

### Step 5: Basic use the bundle generate

run command or add cron task

``` bash
$ bin/console fdevs:sitemap:generate
```

### Step 6: Add Static route in sitemap

add route

``` yml
// app/config/routing.yml
route_name:
    #....
    defaults:
        sitemap: true
        priority: 0.9
        changefreq: always #always|hourly|daily|weekly|monthly|yearly|never or empty
```


### Other Documentation

[Sitemaps XML format](http://www.sitemaps.org/protocol.html)

[SitemapGenerator](https://github.com/K-Phoen/SitemapGenerator)

[KunstmaanSitemapBundle](https://github.com/Kunstmaan/KunstmaanSitemapBundle)

[BerriartSitemapBundle](https://github.com/artberri/BerriartSitemapBundle)

[SitemapBundle](https://github.com/ouardisoft/SitemapBundle)

[PrestaSitemapBundle](https://github.com/prestaconcept/PrestaSitemapBundle)