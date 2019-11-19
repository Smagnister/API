<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DeliveryItem Entity
 *
 * @property int $id
 * @property string $name
 * @property float $weight
 * @property int $order_id
 * @property int $quantity
 * @property string|null $image
 * @property string $description
 *
 * @property \App\Model\Entity\Order $order
 */
class DeliveryItem extends Entity
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
        'name' => true,
        'weight' => true,
        'order_id' => true,
        'quantity' => true,
        'image' => true,
        'description' => true,
        'order' => true
    ];
}
