<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AddressbooksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AddressbooksTable Test Case
 */
class AddressbooksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AddressbooksTable
     */
    public $Addressbooks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Addressbooks',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Addressbooks') ? [] : ['className' => AddressbooksTable::class];
        $this->Addressbooks = TableRegistry::getTableLocator()->get('Addressbooks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Addressbooks);

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
