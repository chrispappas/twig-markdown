<?php

namespace cpappas\Twig\TokenParser;

use cpappas\Twig\Node\MarkdownNode;

/**
 * @author Gunnar Lium <gunnar@aptoma.com>
 */
class MarkdownTokenParser extends \Twig_TokenParser
{
    /**
     * Parses a token and returns a node.
     *
     * @param \Twig_Token $token A \Twig_Token instance
     *
     * @throws \Twig_Error_Syntax
     * @return \Twig_NodeInterface A \Twig_NodeInterface instance
     */
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();

        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

        return new MarkdownNode($body, $lineno, $this->getTag());
    }

    /**
     * Decide if current token marks end of Markdown block.
     *
     * @param \Twig_Token $token
     * @return bool
     */
    public function decideBlockEnd(\Twig_Token $token)
    {
        return $token->test('endmarkdown');
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag()
    {
        return 'markdown';
    }
}
