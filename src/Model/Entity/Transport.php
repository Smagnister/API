<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transport Entity
 *
 * @property int $id
 * @property float $kilometer
 * @property int $transportsize_id
 * @property float $price
 * @property int $discount_id
 * @property float $final_price
 *
 * @property \App\Model\Entity\Transportsize $transportsize
 * @property \App\Model\Entity\Discount $discount
 */
class Transport extends Entity
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
        'kilometer' => true,
        'transportsize_id' => true,
        'price' => true,
        'discount_id' => true,
        'final_price' => true,
        'transportsize' => true,
        'discount' => true
    ];
}
