<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\AddressbooksTable&\Cake\ORM\Association\HasMany $Addressbooks
 * @property \App\Model\Table\BankDetailsTable&\Cake\ORM\Association\HasMany $BankDetails
 * @property \App\Model\Table\BikersTable&\Cake\ORM\Association\HasMany $Bikers
 * @property \App\Model\Table\FundTransferTable&\Cake\ORM\Association\HasMany $FundTransfer
 * @property &\Cake\ORM\Association\HasMany $OpenTime
 * @property \App\Model\Table\OtpsTable&\Cake\ORM\Association\HasMany $Otps
 * @property \App\Model\Table\StoresTable&\Cake\ORM\Association\HasMany $Stores
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Addressbooks', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('BankDetails', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Bikers', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('FundTransfer', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('OpenTime', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Otps', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Stores', [
            'foreignKey' => 'user_id'
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
            ->scalar('role')
            ->maxLength('role', 50)
            ->requirePresence('role', 'create')
            ->notEmptyString('role');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 10)
            ->requirePresence('mobile', 'create')
            ->notEmptyString('mobile')
            ->add('mobile', 'validFormat', [
                'rule' => array('custom', '/^([0-9]{10})$/i'),
                'message' => 'Please enter a valid mobile number.'
            ]);

        $validator
            ->email('email')
            ->allowEmptyString('email')
            ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => 'E-mail must be valid'
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 50)
            ->allowEmptyString('password');

        $validator
            ->scalar('username')
            ->maxLength('username', 50)
            ->allowEmptyString('username');

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmptyString('modified_by');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('modified_at')
            ->notEmptyDateTime('modified_at');

        $validator
            ->boolean('is_active')
            ->requirePresence('is_active', 'create')
            ->notEmptyString('is_active');

        $validator
            ->scalar('profile_img')
            ->maxLength('profile_img', 255)
            ->allowEmptyFile('profile_img');

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
        $rules->add($rules->isUnique(['mobile', 'role']));
        return $rules;
    }
}
