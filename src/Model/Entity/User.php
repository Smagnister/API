<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $role
 * @property string $mobile
 * @property string|null $email
 * @property string|null $password
 * @property string|null $username
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 * @property bool $is_active
 * @property string|null $profile_img
 *
 * @property \App\Model\Entity\Addressbook[] $addressbooks
 * @property \App\Model\Entity\BankDetail[] $bank_details
 * @property \App\Model\Entity\Biker[] $bikers
 * @property \App\Model\Entity\FundTransfer[] $fund_transfer
 * @property \App\Model\Entity\Otp[] $otps
 * @property \App\Model\Entity\Store[] $stores
 */
class User extends Entity
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
        'role' => true,
        'mobile' => true,
        'email' => true,
        'password' => true,
        'username' => true,
        'created_by' => true,
        'modified_by' => true,
        'created_at' => true,
        'modified_at' => true,
        'is_active' => true,
        'profile_img' => true,
        'addressbooks' => true,
        'bank_details' => true,
        'bikers' => true,
        'fund_transfer' => true,
        'otps' => true,
        'stores' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
