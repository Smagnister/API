<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BankDetails Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\FundTransferTable&\Cake\ORM\Association\HasMany $FundTransfer
 *
 * @method \App\Model\Entity\BankDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\BankDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BankDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BankDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BankDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BankDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BankDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BankDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class BankDetailsTable extends Table
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

        $this->setTable('bank_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('FundTransfer', [
            'foreignKey' => 'bank_detail_id'
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
            ->scalar('bank_name')
            ->maxLength('bank_name', 255)
            ->requirePresence('bank_name', 'create')
            ->notEmptyString('bank_name');

        $validator
            ->scalar('branch_name')
            ->maxLength('branch_name', 255)
            ->requirePresence('branch_name', 'create')
            ->notEmptyString('branch_name');

        $validator
            ->requirePresence('account_no', 'create')
            ->notEmptyString('account_no');

        $validator
            ->scalar('acc_holder_name')
            ->maxLength('acc_holder_name', 50)
            ->requirePresence('acc_holder_name', 'create')
            ->notEmptyString('acc_holder_name');

        $validator
            ->scalar('ifsc')
            ->maxLength('ifsc', 20)
            ->requirePresence('ifsc', 'create')
            ->notEmptyString('ifsc');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('modified_at')
            ->notEmptyDateTime('modified_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
