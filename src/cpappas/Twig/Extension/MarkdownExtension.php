<?php

namespace cpappas\Twig\Extension;

use cpappas\Twig\TokenParser\MarkdownTokenParser;
use dflydev\markdown\IMarkdownParser;

/**
 * MarkdownExtension provides support for Markdown.
 *
 * @author Gunnar Lium <gunnar@aptoma.com>
 */
class MarkdownExtension extends \Twig_Extension
{

	/**
	 * @var IMarkdownParser
	 */
	private $parser;

	/**
	 * @var string a string representing tags/things to wrap the html output
	 */
	private $wrapper;

	const WRAPPER_PLACEHOLDER = '%%content%%';

	public function __construct(IMarkdownParser $parser, $wrapper = false)
	{
		$this->parser = $parser;

		$this->wrapper = $wrapper;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFilters()
	{
		return array(
			'markdown' => new \Twig_Filter_Method(
				$this,
				'parseMarkdown',
				array(
					'is_safe' => array('html'),
				)
			),
		);
	}

	public function getHtmlOutput($text) {
		if ($this->wrapper && strpos($this->wrapper, self::WRAPPER_PLACEHOLDER) !== false){
			return str_replace(self::WRAPPER_PLACEHOLDER, $this->parser->transformMarkdown($text), $this->wrapper);
		} else {
			$this->parser->transformMarkdown($text);
		}
	}

	/**
	 * Transform Markdown text to HTML
	 *
	 * @param $text
	 * @return string
	 */
	public function parseMarkdown($text)
	{
		return "<div class='markdown'>" . $this->parser->transformMarkdown($text) . "</div>";
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTokenParsers()
	{
		return array(
			new MarkdownTokenParser()
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'markdown';
	}
}
