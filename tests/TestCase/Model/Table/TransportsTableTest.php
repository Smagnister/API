<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransportsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransportsTable Test Case
 */
class TransportsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TransportsTable
     */
    public $Transports;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Transports',
        'app.Transportsizes',
        'app.Discounts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Transports') ? [] : ['className' => TransportsTable::class];
        $this->Transports = TableRegistry::getTableLocator()->get('Transports', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Transports);

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
