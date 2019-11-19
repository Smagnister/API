<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Store Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $contact_person_name
 * @property string|null $contact_person_mobile
 * @property string|null $phone
 * @property string|null $gst_no
 * @property string|null $website
 * @property float|null $ratings
 * @property bool|null $is_available
 * @property bool $is_approved
 * @property string|null $remarks
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\OpenTime[] $open_time
 * @property \App\Model\Entity\Product[] $products
 */
class Store extends Entity
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
        'contact_person_name' => true,
        'contact_person_mobile' => true,
        'phone' => true,
        'gst_no' => true,
        'website' => true,
        'ratings' => true,
        'is_available' => true,
        'is_approved' => true,
        'remarks' => true,
        'user' => true,
        'open_time' => true,
        'products' => true
    ];
}
