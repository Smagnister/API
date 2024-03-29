<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Refund Entity
 *
 * @property int $id
 * @property int $order_id
 * @property string $status
 * @property int $fund_transfer_id
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\FundTransfer $fund_transfer
 */
class Refund extends Entity
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
        'order_id' => true,
        'status' => true,
        'fund_transfer_id' => true,
        'created_at' => true,
        'modified_at' => true,
        'order' => true,
        'fund_transfer' => true
    ];
}
