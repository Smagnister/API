<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Discounts Model
 *
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\HasMany $Products
 * @property \App\Model\Table\TransportsTable&\Cake\ORM\Association\HasMany $Transports
 *
 * @method \App\Model\Entity\Discount get($primaryKey, $options = [])
 * @method \App\Model\Entity\Discount newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Discount[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Discount|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Discount saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Discount patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Discount[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Discount findOrCreate($search, callable $callback = null, $options = [])
 */
class DiscountsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('discounts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Products', [
            'foreignKey' => 'discount_id'
        ]);
        $this->hasMany('Transports', [
            'foreignKey' => 'discount_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 250)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('image')
            ->maxLength('image', 250)
            ->allowEmptyFile('image');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->numeric('value')
            ->requirePresence('value', 'create')
            ->notEmptyString('value');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 10)
            ->requirePresence('unit', 'create')
            ->notEmptyString('unit');

        $validator
            ->dateTime('expired_on')
            ->requirePresence('expired_on', 'create')
            ->notEmptyDateTime('expired_on');

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 50)
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        $validator
            ->integer('modified_by')
            ->requirePresence('modified_by', 'create')
            ->notEmptyString('modified_by');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('modified_at')
            ->requirePresence('modified_at', 'create')
            ->notEmptyDateTime('modified_at');

        return $validator;
    }
}
