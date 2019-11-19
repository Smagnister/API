<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Otp Entity
 *
 * @property int $id
 * @property int $otp
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $modified_at
 * @property int $user_id
 * @property bool $is_used
 * @property \Cake\I18n\FrozenTime $expired_on
 *
 * @property \App\Model\Entity\User $user
 */
class Otp extends Entity
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
        'otp' => true,
        'created_at' => true,
        'modified_at' => true,
        'user_id' => true,
        'is_used' => true,
        'expired_on' => true,
        'user' => true
    ];
}
