<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OtpsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OtpsTable Test Case
 */
class OtpsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OtpsTable
     */
    public $Otps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Otps',
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
        $config = TableRegistry::getTableLocator()->exists('Otps') ? [] : ['className' => OtpsTable::class];
        $this->Otps = TableRegistry::getTableLocator()->get('Otps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Otps);

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
