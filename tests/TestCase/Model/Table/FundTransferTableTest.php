<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FundTransferTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FundTransferTable Test Case
 */
class FundTransferTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FundTransferTable
     */
    public $FundTransfer;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FundTransfer',
        'app.Users',
        'app.BankDetails',
        'app.Orders',
        'app.Refund'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FundTransfer') ? [] : ['className' => FundTransferTable::class];
        $this->FundTransfer = TableRegistry::getTableLocator()->get('FundTransfer', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FundTransfer);

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
