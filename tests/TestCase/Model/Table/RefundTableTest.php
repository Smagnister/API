<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RefundTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RefundTable Test Case
 */
class RefundTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RefundTable
     */
    public $Refund;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Refund',
        'app.Orders',
        'app.FundTransfers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Refund') ? [] : ['className' => RefundTable::class];
        $this->Refund = TableRegistry::getTableLocator()->get('Refund', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Refund);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
