<?php

namespace AppBundle\Helper\DoctrineExtensions;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

/**
 * DateFormat
 *
 * Allows Doctrine 2.0 Query Language to execute a MySQL DATE_FORMAT function
 * You must boostrap this function in your ORM as a DQLFunction.
 *
 *
 * DATE_FORMAT(TIMESTAMP,'%format')
 * @link http://stackoverflow.com/questions/6067526/how-do-i-group-a-date-field-to-get-quarterly-results-in-mysql
 * @link https://github.com/beberlei/DoctrineExtensions
 * @link https://github.com/orocrm/doctrine-extensions
 *
 *
 * PLEASE REMEMBER TO CHECK YOUR NAMESPACE
 *
 * @link labs.ultravioletdesign.co.uk
 * @author Rob Squires <rob@ultravioletdesign.co.uk>
 *
 *
 */
class DateFormat extends FunctionNode
{
    /**
     * holds the timestamp of the DATE_FORMAT DQL statement
     * @var mixed
     */
    protected $dateExpression;

    /**
     * holds the '%format' parameter of the DATE_FORMAT DQL statement
     * @var string
     */
    protected $formatChar;

    /**
     * getSql - allows ORM  to inject a DATE_FORMAT() statement into an SQL string being constructed
     * @param SqlWalker $sqlWalker
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'DATE_FORMAT('
        . $this->dateExpression->dispatch($sqlWalker)
        . ','
        . $this->formatChar->dispatch($sqlWalker)
        . ')';
    }

    /**
     * parse - allows DQL to breakdown the DQL string into a processable structure
     * @param Parser $parser
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->dateExpression = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);

        $this->formatChar = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
