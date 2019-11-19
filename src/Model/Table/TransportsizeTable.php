<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transportsize Model
 *
 * @property \App\Model\Table\TransportTable&\Cake\ORM\Association\HasMany $Transport
 *
 * @method \App\Model\Entity\Transportsize get($primaryKey, $options = [])
 * @method \App\Model\Entity\Transportsize newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Transportsize[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transportsize|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transportsize saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transportsize patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Transportsize[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transportsize findOrCreate($search, callable $callback = null, $options = [])
 */
class TransportsizeTable extends Table
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

        $this->setTable('transportsize');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Transport', [
            'foreignKey' => 'transportsize_id'
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
            ->scalar('size_type')
            ->maxLength('size_type', 10)
            ->requirePresence('size_type', 'create')
            ->notEmptyString('size_type');

        $validator
            ->numeric('height')
            ->requirePresence('height', 'create')
            ->notEmptyString('height');

        $validator
            ->numeric('width')
            ->requirePresence('width', 'create')
            ->notEmptyString('width');

        $validator
            ->numeric('weight')
            ->requirePresence('weight', 'create')
            ->notEmptyString('weight');

        return $validator;
    }
}
