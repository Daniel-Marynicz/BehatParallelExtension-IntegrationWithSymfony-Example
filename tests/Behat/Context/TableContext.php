<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use App\Tests\Behat\Asserter;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;

use function array_values;
use function count;
use function implode;
use function sprintf;
use function trim;

class TableContext extends RawMinkContext
{
    use Asserter;

    /**
     * Checks that the data matches the given schema
     *
     * @param TableNode<string[]> $tableNode
     *
     * @example
     *  Then the data of the "table" table should match:
     *    | Id  | Name       | Price | actions   |
     *    | 123 | Calculator | 14.22 | show edit |
     *    | 456 | Notebook   | 99.99 | show edit |
     *
     * @example 2
     * Then the data of the "table" table should match:
     *   | Id               | Name       | Price | actions   |
     *   | no records found |            |       |           |
     *
     * @Then the data of the :table table should match:
     */
    public function theDataOfTheTableShouldMatch(string $table, TableNode $tableNode): void
    {
        $rowsSelector      = sprintf('%s tbody tr', $table);
        $htmlRows          = $this->getSession()->getPage()->findAll('css', $rowsSelector);
        $actualCountRows   = count($htmlRows);
        $expectedCountRows = count($tableNode->getRows()) - 1;
        $this->assertEquals($expectedCountRows, $actualCountRows);

        foreach ($tableNode as $index => $row) {
            $expectedText = implode(' ', array_values($row));
            $this->assertArrayHasKey($index, $htmlRows);
            $htmlRow    = $htmlRows[$index];
            $actualText = $htmlRow->getText();
            $this->assertEquals(trim($expectedText), trim($actualText));
        }
    }
}
