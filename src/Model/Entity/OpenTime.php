<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OpenTime Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $days
 * @property \Cake\I18n\FrozenTime $start_hour
 * @property \Cake\I18n\FrozenTime $end_hour
 *
 * @property \App\Model\Entity\User $user
 */
class OpenTime extends Entity
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
        'days' => true,
        'start_hour' => true,
        'end_hour' => true,
        'user' => true
    ];
}
