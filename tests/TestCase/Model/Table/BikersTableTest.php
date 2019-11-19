<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BikersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BikersTable Test Case
 */
class BikersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BikersTable
     */
    public $Bikers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Bikers',
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
        $config = TableRegistry::getTableLocator()->exists('Bikers') ? [] : ['className' => BikersTable::class];
        $this->Bikers = TableRegistry::getTableLocator()->get('Bikers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bikers);

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
