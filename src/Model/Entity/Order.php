<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property string $type
 * @property int $order_by
 * @property int $assigned_store
 * @property int $assigned_biker
 * @property string $store_assigned_by
 * @property string $biker_assigned_by
 * @property string $status
 * @property string $pickup_address
 * @property string $pickup_latlng
 * @property string|null $delivery_person_name
 * @property string|null $delivery_mobile
 * @property string $delivery_address
 * @property string $delivery_latlng
 * @property \Cake\I18n\FrozenTime $created_at
 * @property int $modified_at
 * @property bool $is_cancelled
 * @property string $cancelled_by
 * @property \Cake\I18n\FrozenTime $cancelled_at
 * @property string $payment_type
 * @property string $payment_status
 * @property \Cake\I18n\FrozenTime $payed_at
 * @property float $delivery_fee
 * @property bool $refund_status
 * @property int $fund_transfer_id
 *
 * @property \App\Model\Entity\FundTransfer $fund_transfer
 * @property \App\Model\Entity\DeliveryItem[] $delivery_items
 * @property \App\Model\Entity\OrderItem[] $order_items
 * @property \App\Model\Entity\Refund[] $refund
 */
class Order extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'type' => true,
        'order_by' => true,
        'assigned_store' => true,
        'assigned_biker' => true,
        'store_assigned_by' => true,
        'biker_assigned_by' => true,
        'status' => true,
        'pickup_address' => true,
        'pickup_latlng' => true,
        'delivery_person_name' => true,
        'delivery_mobile' => true,
        'delivery_address' => true,
        'delivery_latlng' => true,
        'created_at' => true,
        'modified_at' => true,
        'is_cancelled' => true,
        'cancelled_by' => true,
        'cancelled_at' => true,
        'payment_type' => true,
        'payment_status' => true,
        'payed_at' => true,
        'delivery_fee' => true,
        'refund_status' => true,
        'fund_transfer_id' => true,
        'fund_transfer' => true,
        'delivery_items' => true,
        'order_items' => true,
        'refund' => true
    ];
}
