<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransportsizeTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransportsizeTable Test Case
 */
class TransportsizeTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TransportsizeTable
     */
    public $Transportsize;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Transportsize',
        'app.Transport'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Transportsize') ? [] : ['className' => TransportsizeTable::class];
        $this->Transportsize = TableRegistry::getTableLocator()->get('Transportsize', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Transportsize);

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
}
