<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OpenTimeTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OpenTimeTable Test Case
 */
class OpenTimeTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OpenTimeTable
     */
    public $OpenTime;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OpenTime',
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
        $config = TableRegistry::getTableLocator()->exists('OpenTime') ? [] : ['className' => OpenTimeTable::class];
        $this->OpenTime = TableRegistry::getTableLocator()->get('OpenTime', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OpenTime);

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
