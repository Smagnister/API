<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \App\Model\Table\FundTransfersTable&\Cake\ORM\Association\BelongsTo $FundTransfers
 * @property \App\Model\Table\DeliveryItemsTable&\Cake\ORM\Association\HasMany $DeliveryItems
 * @property \App\Model\Table\OrderItemsTable&\Cake\ORM\Association\HasMany $OrderItems
 * @property \App\Model\Table\RefundTable&\Cake\ORM\Association\HasMany $Refund
 *
 * @method \App\Model\Entity\Order get($primaryKey, $options = [])
 * @method \App\Model\Entity\Order newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Order|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Order[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdersTable extends Table
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

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('FundTransfers', [
            'foreignKey' => 'fund_transfer_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('DeliveryItems', [
            'foreignKey' => 'order_id'
        ]);
        $this->hasMany('OrderItems', [
            'foreignKey' => 'order_id'
        ]);
        $this->hasMany('Refund', [
            'foreignKey' => 'order_id'
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
            ->scalar('type')
            ->maxLength('type', 50)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->integer('order_by')
            ->requirePresence('order_by', 'create')
            ->notEmptyString('order_by');

        $validator
            ->integer('assigned_store')
            ->requirePresence('assigned_store', 'create')
            ->notEmptyString('assigned_store');

        $validator
            ->integer('assigned_biker')
            ->requirePresence('assigned_biker', 'create')
            ->notEmptyString('assigned_biker');

        $validator
            ->scalar('store_assigned_by')
            ->maxLength('store_assigned_by', 50)
            ->requirePresence('store_assigned_by', 'create')
            ->notEmptyString('store_assigned_by');

        $validator
            ->scalar('biker_assigned_by')
            ->maxLength('biker_assigned_by', 50)
            ->requirePresence('biker_assigned_by', 'create')
            ->notEmptyString('biker_assigned_by');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->scalar('pickup_address')
            ->maxLength('pickup_address', 255)
            ->requirePresence('pickup_address', 'create')
            ->notEmptyString('pickup_address');

        $validator
            ->scalar('pickup_latlng')
            ->requirePresence('pickup_latlng', 'create')
            ->notEmptyString('pickup_latlng');

        $validator
            ->scalar('delivery_person_name')
            ->maxLength('delivery_person_name', 50)
            ->allowEmptyString('delivery_person_name');

        $validator
            ->scalar('delivery_mobile')
            ->maxLength('delivery_mobile', 12)
            ->allowEmptyString('delivery_mobile');

        $validator
            ->scalar('delivery_address')
            ->maxLength('delivery_address', 255)
            ->requirePresence('delivery_address', 'create')
            ->notEmptyString('delivery_address');

        $validator
            ->scalar('delivery_latlng')
            ->requirePresence('delivery_latlng', 'create')
            ->notEmptyString('delivery_latlng');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmptyDateTime('created_at');

        $validator
            ->integer('modified_at')
            ->requirePresence('modified_at', 'create')
            ->notEmptyString('modified_at');

        $validator
            ->boolean('is_cancelled')
            ->requirePresence('is_cancelled', 'create')
            ->notEmptyString('is_cancelled');

        $validator
            ->scalar('cancelled_by')
            ->maxLength('cancelled_by', 50)
            ->requirePresence('cancelled_by', 'create')
            ->notEmptyString('cancelled_by');

        $validator
            ->dateTime('cancelled_at')
            ->requirePresence('cancelled_at', 'create')
            ->notEmptyDateTime('cancelled_at');

        $validator
            ->scalar('payment_type')
            ->maxLength('payment_type', 50)
            ->requirePresence('payment_type', 'create')
            ->notEmptyString('payment_type');

        $validator
            ->scalar('payment_status')
            ->maxLength('payment_status', 50)
            ->requirePresence('payment_status', 'create')
            ->notEmptyString('payment_status');

        $validator
            ->dateTime('payed_at')
            ->requirePresence('payed_at', 'create')
            ->notEmptyDateTime('payed_at');

        $validator
            ->numeric('delivery_fee')
            ->requirePresence('delivery_fee', 'create')
            ->notEmptyString('delivery_fee');

        $validator
            ->boolean('refund_status')
            ->requirePresence('refund_status', 'create')
            ->notEmptyString('refund_status');

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
        $rules->add($rules->existsIn(['fund_transfer_id'], 'FundTransfers'));

        return $rules;
    }
}
