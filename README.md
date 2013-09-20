Twig Markdown Extension
=======================

This is a fork from [Aptoma/twig-markdown](https://github.com/aptoma/twig-markdown), adding a "Wrapper" option to
automatically wrap markdown content in an arbitrary wrapper.

Twig Markdown extension provides a new filter and a tag to allow parsing of
content as Markdown in [Twig][1] templates.

This extension provides an integration with [dflydev-markdown](https://github.com/dflydev/dflydev-markdown)
for the actual parsing of Markdown.

## Installation

Update your composer.json:

```
// composer.json

{
    "require": {
        "cpappas/twig-markdown": "dev-master"
    }
}
```

## Usage

It's assumed that you will use Composer to handle autoloading.

You can define an arbitrary wrapper that the rendered html will be output with. It uses the %%content%% placeholder to
denote where the rendered HTML should be output (can appear multiple times, if you really want)

Add the extension to the twig environment:

```php
$parser = new \dflydev\markdown\MarkdownParser();
$wrapper = "<div class='markdown'>%%content%%</div>";

$twig->addExtension(new \cpappas\Twig\Extension\MarkdownExtension($parser, $wrapper));
```

Use filter or tag in your templates:

```twig
// Filter
{{ "#Title"|markdown }}

// becomes

<div class='markdown'><h1>Title</h1></div>

// Tag
{% markdown %}
#Title

Paragraph of text.

    $block = 'code';
{% endmarkdown %}

// becomes

<div class='markdown'><h1>Title</h1>

<p>Paragraph of text</p>

<pre><code>$block = 'code';</pre></code></div>
```

If you only want to use the `markdown`-tag, you can also just add the token parser
to the Twig environment:

```php
$twig->addTokenParser(new \cpappas\Twig\TokenParser\MarkdownTokenParser());
```

When used as a tag, any whitespace on the first line we be treated as padding and
removed form all lines. This allows you to mix HTML and Markdown in your templates,
without having all Markdown content being treated as code:

```php
<div>
    <h1 class="someClass">{{ title }}</h1>

    {% markdown %}
    This is a list that is indented to match the context around the markdown tag:

    * List item 1
    * List item 2

    The following block will be treated as code, as it is indented more than the
    surrounding content:

        $code = "good";

    {% endmarkdown %}

</div>
```

## Tests

The test suite uses PHPUnit:

    $ phpunit

## License

Twig Markdown Extension is licensed under the MIT license.

[1]: http://twig.sensiolabs.org/
