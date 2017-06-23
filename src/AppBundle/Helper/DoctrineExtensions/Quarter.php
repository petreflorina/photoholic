<?php

namespace AppBundle\Helper\DoctrineExtensions;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

/**
 * Quarter
 *
 * Allows Doctrine 2.0 Query Language to execute a MySQL QUARTER function
 * You must boostrap this function in your ORM as a DQLFunction.
 *
 *
 * QUARTER(DATETIME)
 * @link http://stackoverflow.com/questions/6067526/how-do-i-group-a-date-field-to-get-quarterly-results-in-mysql
 * @link https://github.com/beberlei/DoctrineExtensions
 * @link https://github.com/orocrm/doctrine-extensions
 *
 *
 */
class Quarter extends FunctionNode
{
    /**
     * holds the timestamp of the QUARTER DQL statement
     * @var mixed
     */
    protected $dateExpression;

    /**
     * getSql - allows ORM  to inject a QUARTER() statement into an SQL string being constructed
     * @param SqlWalker $sqlWalker
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'QUARTER(' . $this->dateExpression->dispatch($sqlWalker) . ')';
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
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
