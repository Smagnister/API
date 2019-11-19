<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransportTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransportTable Test Case
 */
class TransportTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TransportTable
     */
    public $Transport;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Transport',
        'app.Transportsizes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Transport') ? [] : ['className' => TransportTable::class];
        $this->Transport = TableRegistry::getTableLocator()->get('Transport', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Transport);

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
