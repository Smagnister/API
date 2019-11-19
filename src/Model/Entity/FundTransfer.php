<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FundTransfer Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $bank_detail_id
 * @property string $status
 * @property string $reason
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\BankDetail $bank_detail
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\Refund[] $refund
 */
class FundTransfer extends Entity
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
        'user_id' => true,
        'bank_detail_id' => true,
        'status' => true,
        'reason' => true,
        'created_at' => true,
        'modified_at' => true,
        'user' => true,
        'bank_detail' => true,
        'orders' => true,
        'refund' => true
    ];
}
