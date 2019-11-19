<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Addressbook Entity
 *
 * @property int $id
 * @property string $type
 * @property int $user_id
 * @property string $street
 * @property string $area
 * @property string $city
 * @property string|null $district
 * @property string $state
 * @property string $country
 * @property string $pincode
 * @property string $latitude
 * @property string $longitude
 *
 * @property \App\Model\Entity\User $user
 */
class Addressbook extends Entity
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
        'user_id' => true,
        'street' => true,
        'area' => true,
        'city' => true,
        'district' => true,
        'state' => true,
        'country' => true,
        'pincode' => true,
        'latitude' => true,
        'longitude' => true,
        'user' => true
    ];
}
