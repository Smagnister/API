<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CartTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CartTable Test Case
 */
class CartTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CartTable
     */
    public $Cart;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Cart',
        'app.Users',
        'app.Products'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Cart') ? [] : ['className' => CartTable::class];
        $this->Cart = TableRegistry::getTableLocator()->get('Cart', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cart);

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
