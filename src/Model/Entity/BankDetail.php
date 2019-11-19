<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BankDetail Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $bank_name
 * @property string $branch_name
 * @property int $account_no
 * @property string $acc_holder_name
 * @property string $ifsc
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\FundTransfer[] $fund_transfer
 */
class BankDetail extends Entity
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
        'bank_name' => true,
        'branch_name' => true,
        'account_no' => true,
        'acc_holder_name' => true,
        'ifsc' => true,
        'created_at' => true,
        'modified_at' => true,
        'user' => true,
        'fund_transfer' => true
    ];
}
