<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Biker Entity
 *
 * @property int $id
 * @property int $user_id
 * @property \Cake\I18n\FrozenDate|null $dob
 * @property string|null $license
 * @property string|null $aadar
 * @property string|null $remarks
 * @property float|null $ratings
 *
 * @property \App\Model\Entity\User $user
 */
class Biker extends Entity
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
        'dob' => true,
        'license' => true,
        'aadar' => true,
        'remarks' => true,
        'ratings' => true,
        'user' => true
    ];
}
