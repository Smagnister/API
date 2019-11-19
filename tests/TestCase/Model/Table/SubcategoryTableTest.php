<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubcategoryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SubcategoryTable Test Case
 */
class SubcategoryTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SubcategoryTable
     */
    public $Subcategory;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Subcategory',
        'app.Category'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Subcategory') ? [] : ['className' => SubcategoryTable::class];
        $this->Subcategory = TableRegistry::getTableLocator()->get('Subcategory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Subcategory);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
